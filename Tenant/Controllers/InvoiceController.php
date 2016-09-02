<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Agent;
use App\Modules\Tenant\Models\Application\CourseApplication;
use App\Modules\Tenant\Models\Application\StudentApplicationPayment;
use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\Client\ClientPayment;
use App\Modules\Tenant\Models\Invoice\CollegeInvoice;
use App\Modules\Tenant\Models\Invoice\CollegeInvoicePayment;
use App\Modules\Tenant\Models\Invoice\Invoice;
use App\Modules\Tenant\Models\Invoice\StudentInvoice;
use App\Modules\Tenant\Models\Invoice\SubAgentInvoice;
use App\Modules\Tenant\Models\Payment\CollegePayment;
use App\Modules\Tenant\Models\Payment\SubAgentApplicationPayment;
use App\Modules\Tenant\Models\PaymentInvoiceBreakdown;
use Flash;
use DB;

use Illuminate\Http\Request;

class InvoiceController extends BaseController
{

    protected $request;

    function __construct(Invoice $invoice, Request $request, PaymentInvoiceBreakdown $payment_invoice, SubAgentApplicationPayment $subagent_payment, CollegeInvoice $college_invoice, StudentInvoice $student_invoice, SubAgentInvoice $subagent_invoice, CollegeInvoicePayment $college_payment, StudentApplicationPayment $student_payment, Client $client)
    {
        $this->invoice = $invoice;
        $this->client = $client;
        $this->request = $request;
        $this->payment_invoice = $payment_invoice;
        $this->subagent_payment = $subagent_payment;
        $this->college_payment = $college_payment;
        $this->student_payment = $student_payment;
        $this->college_invoice = $college_invoice;
        $this->student_invoice = $student_invoice;
        $this->subagent_invoice = $subagent_invoice;
        parent::__construct();
    }

    /**
     * Assign payment to invoice
     * Same for both student and sub agent
     */
    function postAssign($payment_id)
    {
        $assigned = $this->payment_invoice->assign($this->request->all(), $payment_id);
        if ($assigned) {
            \Flash::success('Payment assigned to invoice successfully!');
            return redirect()->back();
        }
    }

    /**
     * Assign payment to college invoice
     */
    function postCollegeAssign($payment_id)
    {
        $assigned = $this->college_payment->assign($this->request->all(), $payment_id);
        if ($assigned) {
            \Flash::success('Payment assigned to invoice successfully!');
            return redirect()->back();
        }
    }

    function payments($invoice_id, $type = 1)
    {
        $data['invoice'] = $this->getInvoiceDetails($invoice_id, $type);
        $data['invoice_id'] = $invoice_id;
        $data['type'] = $type;
        /* For Navbar */
        $data['application'] = new \stdClass();
        $data['application']->application_id = $app_id = $this->getApplicationId($invoice_id, $type);
        $client_id = CourseApplication::find($app_id)->client_id;
        $data['client'] = $this->client->getDetails($client_id);

        return view("Tenant::Invoice/payments", $data);
    }

    function getApplicationId($invoice_id, $type)
    {
        switch ($type) {
            case 1:
                $application_id = CollegeInvoice::find($invoice_id)->course_application_id;
                break;
            case 2:
                $application_id = StudentInvoice::where('invoice_id', $invoice_id)->first()->application_id;
                break;
            default:
                $application_id = SubAgentInvoice::where('invoice_id', $invoice_id)->first()->course_application_id;
        }
        return $application_id;
    }

    function getInvoiceDetails($invoice_id, $type)
    {
        switch ($type) {
            case 1:
                $invoice = CollegeInvoice::select(['college_invoice_id as invoice_id', 'invoice_date', 'total_commission as total_amount', 'total_gst', 'final_total']) //, 'total_paid', 'status', 'outstanding_amount'
                    ->find($invoice_id);
                $invoice->formatted_id = format_id($invoice_id, 'CI');
                $invoice->paid = $this->college_invoice->getPaidAmount($invoice_id);

                $outstanding = $invoice->final_total - $invoice->paid;
                $invoice->outstanding = ($outstanding > 0 )? $invoice->final_total - $invoice->paid : 0;
                $invoice->status = ($outstanding > 0 )? 'Outstanding' : 'Paid';
                break;
            case 2:
                $invoice = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
                    ->select(['student_invoice_id as invoice_id', 'invoice_date', 'amount as total_amount', 'total_gst', 'final_total'])
                    ->where('student_invoices.invoice_id', $invoice_id)
                    ->first();
                $invoice->formatted_id = format_id($invoice->invoice_id, 'SI');
                break;
            default:
                $invoice = SubAgentInvoice::where('invoice_id', $invoice_id)->first();
                $invoice->formatted_id = format_id($invoice->subagent_invoice_id, 'SAI');
        }
        //dd($invoice->toArray());
        return $invoice;
    }


    /**
     * Get all the payments through ajax request.
     * Type - 1 : college, 2 : student, 3 : subagent
     * @return JSON response
     */
    function getPaymentsData($invoice_id, $type = 1)
    {
        switch ($type) {
            case 1:
                $payments = $this->collegePayments($invoice_id);
                break;
            case 2:
                $payments = $this->studentPayments($invoice_id);
                break;
            default:
                $payments = $this->subagentPayments($invoice_id);
        }

        $datatable = \Datatables::of($payments)
            ->addColumn('action', '<div class="btn-group">
                  <button class="btn btn-primary" type="button">Action</button>
                  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="http://localhost/condat/tenant/contact/2">View</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">Edit</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">Delete</a></li>
                  </ul>
                </div>')
            ->editColumn('date_paid', function ($data) {
                return format_date($data->date_paid);
            })
            ->addColumn('payment_id', function ($data) {
                return format_id($data->payment_id, 'P');
            });
        return $datatable->make(true);
    }

    function subagentPayments($invoice_id)
    {
        $payments = SubAgentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'subagent_application_payments.client_payment_id')
            ->join('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->where('payment_invoice_breakdowns.invoice_id', $invoice_id)
            ->select(['subagent_application_payments.subagent_payments_id', 'subagent_application_payments.course_application_id', 'payment_invoice_breakdowns.invoice_id', 'client_payments.*', 'client_payments.client_payment_id as payment_id']);
        return $payments;
    }

    function collegePayments($invoice_id)
    {
        $payments = CollegePayment::join('college_invoice_payments', 'college_payments.college_payment_id', '=', 'college_invoice_payments.ci_payment_id')
            ->where('college_invoice_payments.college_invoice_id', $invoice_id)
            ->select(['college_payments.*', 'college_payments.college_payment_id as payment_id']);
        return $payments;
    }

    function studentPayments($invoice_id)
    {
        $payments = StudentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'student_application_payments.client_payment_id')
            ->join('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->where('payment_invoice_breakdowns.invoice_id', $invoice_id)
            ->select(['student_application_payments.student_payments_id', 'client_payments.*', 'client_payments.client_payment_id as payment_id'])
            ->get();
        return $payments;
    }

    function createPayment($invoice_id, $type = 1)
    {
        $data['invoice_id'] = $invoice_id;
        $data['type'] = $type;
        return view("Tenant::Client/Invoice/payment", $data);

    }

    function postPayment($invoice_id, $type = 1)
    {
        switch ($type) {
            case 1:
                $created = $this->college_payment->add($this->request->all(), $invoice_id);
                break;
            case 2:
                $created = $this->student_payment->addAndAssign($this->request->all(), $invoice_id);
                break;
            default:
                $created = $this->subagent_payment->addAndAssign($this->request->all(), $invoice_id);
        }

        if ($created)
            \Flash::success('Payment added successfully!');
        return redirect()->back();
    }

}
