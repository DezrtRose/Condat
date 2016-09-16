<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Application\StudentApplicationPayment;
use App\Modules\Tenant\Models\Institute\Institute;
use App\Modules\Tenant\Models\Invoice\CollegeInvoice;
use App\Modules\Tenant\Models\Invoice\Invoice;
use App\Modules\Tenant\Models\Invoice\StudentInvoice;
use App\Modules\Tenant\Models\Payment\CollegePayment;
use App\Modules\Tenant\Models\Payment\SubAgentApplicationPayment;
use App\Modules\Tenant\Models\Report\Report;
use Flash;
use DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class InvoiceReportController extends BaseController
{

    function __construct(Invoice $invoice, StudentInvoice $student_invoice, Report $report, Institute $institute, Request $request, CollegeInvoice $college_invoice)
    {
        $this->invoice = $invoice;
        $this->student_invoice = $student_invoice;
        $this->college_invoice = $college_invoice;
        $this->report = $report;
        $this->institute = $institute;
        $this->request = $request;
        parent::__construct();
    }

    public function clientInvoicePending()
    {
        $data['invoice_reports'] = $this->student_invoice->getAll();
        return view("Tenant::InvoiceReport/ClientInvoice/invoice_pending", $data);
    }

    public function clientInvoicePaid()
    {
        $data['invoice_reports'] = $this->invoice->getInvoiceDetails();

        $data['date'] = Carbon::now();

        return view("Tenant::InvoiceReport/ClientInvoice/invoice_paid", $data);

    }


    public function clientInvoiceFuture()
    {
        $data['invoice_reports'] = $this->invoice->getInvoiceDetails();

        $data['date'] = Carbon::now();

        return view("Tenant::InvoiceReport/Invoice/invoice_future", $data);
    }

    public function clientInvoiceSearch()
    {
        $data['status'] = [0 => 'All',
            1 => 'Pending',
            2 => 'Paid',
            3 => 'Future'];

        $data['colleges'] = $this->institute->getList()->toArray();

        $data['search_attributes'] = array();

        if ($this->request->isMethod('post')) {
            $data['invoice_reports'] = $this->student_invoice->getFilterResults($this->request->all());
            $data['search_attributes'] = $this->request->all();
            Flash::success(count($data['invoice_reports']) . ' record(s) found.');
        }
        return view('Tenant::InvoiceReport/ClientInvoice/search', $data);
    }


    // college Invoices
    public function collegeInvoicePending()
    {
        $data['invoice_reports'] = $this->college_invoice->getAll();
        return view("Tenant::InvoiceReport/CollegeInvoice/invoice_pending", $data);
    }

    public function CollegeInvoicePaid()
    {
        $data['invoice_reports'] = $this->college_invoice->getAll(2);
        return view("Tenant::InvoiceReport/CollegeInvoice/invoice_paid", $data);
    }


    public function collegeInvoiceFuture()
    {
        $data['invoice_reports'] = $this->college_invoice->getAll(3);
        return view("Tenant::InvoiceReport/CollegeInvoice/invoice_future", $data);
    }

    public function groupInvoice()
    {
        $data['invoice_reports'] = $this->college_invoice->getAll();
        $data['date'] = Carbon::now();

        return view("Tenant::InvoiceReport/CollegeInvoice/group_invoice", $data);
    }

    public function collegeInvoiceSearch()
    {
        $data['status'] = [0 => 'All',
            1 => 'Pending',
            2 => 'Paid',
            3 => 'Future'];

        $data['colleges'] = $this->institute->getList()->toArray();
        array_unshift($data['colleges'], 'All');

        if ($this->request->isMethod('post')) {
            //$data['applications'] = $this->application->getFilterResults($this->request->all());
            Flash::success(count($data['applications']) . ' records found.');
        }
        return view('Tenant::InvoiceReport/CollegeInvoice/search', $data);
    }

    public function clientPayments()
    {
        $data['payments'] = StudentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'student_application_payments.client_payment_id')
            ->leftJoin('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->select(['student_application_payments.student_payments_id', 'client_payments.*', 'payment_invoice_breakdowns.invoice_id', 'course_application_id'])
            ->get();
        return view("Tenant::InvoiceReport/Payment/clients", $data);
    }

    public function collegePayments()
    {
        $data['payments'] = CollegePayment::leftJoin('college_invoice_payments', 'college_payments.college_payment_id', '=', 'college_invoice_payments.ci_payment_id')
            ->select(['college_payments.*', 'college_invoice_payments.college_invoice_id'])
            ->get();
        return view("Tenant::InvoiceReport/Payment/institutes", $data);
    }

    public function subagentsPayments()
    {
        $data['payments'] = SubAgentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'subagent_application_payments.client_payment_id')
            ->leftJoin('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->select(['subagent_application_payments.subagent_payments_id', 'subagent_application_payments.course_application_id', 'payment_invoice_breakdowns.invoice_id', 'client_payments.*'])
            ->get();
        return view("Tenant::InvoiceReport/Payment/subagents", $data);
    }


}//end of controller
