<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Setting;
use App\Modules\Tenant\Models\Agent;
use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\Application\CourseApplication;
use App\Modules\Tenant\Models\Institute\Institute;
use App\Modules\Tenant\Models\Invoice\CollegeInvoice;
use App\Modules\Tenant\Models\Payment\CollegePayment;
use App\Modules\Agency\Models\Agency;
use Carbon;
use Flash;
use DB;

use Illuminate\Http\Request;

class CollegeController extends BaseController
{

    protected $request;/* Validation rules for user create and edit */
    protected $rules = [
        'amount' => 'required|numeric',
        'date_paid' => 'required',
        'payment_method' => 'required|min:2|max:45'
    ];

    function __construct(Client $client, Request $request, CourseApplication $application, CollegePayment $payment, CollegeInvoice $invoice, Agency $agency, Agent $agent, Setting $setting)
    {
        $this->client = $client;
        $this->request = $request;
        $this->application = $application;
        $this->invoice = $invoice;
        $this->payment = $payment;
        $this->agency = $agency;
        $this->agent = $agent;
        $this->setting = $setting;
        parent::__construct();
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($application_id)
    {
        $data['stats'] = $this->invoice->getStats($application_id);
        $data['application'] = $application = $this->application->getDetails($application_id);
        $data['client'] = $this->client->getDetails($application->client_id);
        return view("Tenant::College/Account/index", $data);
    }

    /*
     * Controllers for payment
     * */
    public function createPayment($application_id, $type = 1)
    {
        $data['application_id'] = $application_id;
        $data['pay_type'] = $type;
        return view("Tenant::College/Payment/add", $data);
    }

    public function editPayment($payment_id)
    {
        $data['payment'] = $this->payment->getDetails($payment_id);
        $data['pay_type'] = 1; // Can change to any payment type
        return view("Tenant::College/Payment/edit", $data);
    }

    public function updatePayment($payment_id)
    {
        $this->validate($this->request, $this->rules);

        $application_id = $this->payment->editPayment($this->request->all(), $payment_id);
        Flash::success('Payment has been updated successfully.');
        return redirect()->route('tenant.application.college', $application_id);
    }

    public function storePayment($application_id)
    {
        $this->validate($this->request, $this->rules);
        // if validates
        $created = $this->payment->add($this->request->all(), $application_id);
        if ($created) {
            Flash::success('Payment has added successfully.');
            $payment = $this->payment->getDetails($created);
            $client_id = CourseApplication::find($application_id)->client_id;
            $this->client->addLog($client_id, 5, ['{{NAME}}' => get_tenant_name(), '{{TYPE}}' => $payment->payment_type, '{{DESCRIPTION}}' => $payment->description, '{{DATE}}' => format_date($payment->date_paid), '{{AMOUNT}}' => $payment->amount, '{{VIEW_LINK}}' => url("tenant/college/payment/receipt/" . $payment->college_payment_id)], $application_id);
        }
        return redirect()->route('tenant.application.college', $application_id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function createInvoice($application_id)
    {
        $data['application_id'] = $application_id;
        return view("Tenant::College/Invoice/add", $data);
    }

    public function printInvoice($invoice_id)
    {
        $data['agency'] = $this->agency->getAgencyDetails('33');
        $data['invoice_id'] = $invoice_id;
        return view("Tenant::College/Invoice/print_invoice", $data);
    }


    public function storeInvoice($application_id)
    {
        $rules = [
            'total_commission' => 'required|numeric',
            'invoice_date' => 'required'
        ];
        $this->validate($this->request, $rules);
        // if validates
        $created = $this->invoice->add($this->request->all(), $application_id);
        if ($created) {
            Flash::success('Invoice has created successfully.');
            $invoice = CollegeInvoice::find($created);
            $client_id = $this->invoice->getClientId($created);
            $this->client->addLog($client_id, 4, ['{{NAME}}' => get_tenant_name(), '{{DESCRIPTION}}' => 'College Invoice', '{{DATE}}' => format_date($invoice->invoice_date), '{{AMOUNT}}' => $invoice->total_commission, '{{VIEW_LINK}}' => route('tenant.college.invoice', $invoice->college_invoice_id)], $application_id);
        }
        return redirect()->route('tenant.application.college', $application_id);
    }


    /**
     * Get all the payments through ajax request.
     *
     * @return JSON response
     */
    function getPaymentsData($application_id)
    {
        $payments = CollegePayment::where('course_application_id', $application_id)
            ->leftJoin('college_invoice_payments', 'college_payments.college_payment_id', '=', 'college_invoice_payments.ci_payment_id')
            ->select(['college_payments.*', 'college_invoice_payments.college_invoice_id']);

        $datatable = \Datatables::of($payments)
            ->addColumn('action', function ($data) {
                return '<div class="btn-group">
                  <button class="btn btn-primary" type="button">Action</button>
                  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="http://localhost/condat/tenant/contact/2">View</a></li>
                    <li><a href="'.route("tenant.application.editPayment", $data->college_payment_id).'">Edit</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">Delete</a></li>
                  </ul>
                </div>';
            })
            ->addColumn('invoice_id', function ($data) {
                if ((empty($data->college_invoice_id) || $data->college_invoice_id == 0) && $data->payment_type == 'College to Agent')
                    return 'Uninvoiced <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="' . url('tenant/college/payment/' . $data->college_payment_id . '/' . $data->course_application_id . '/assign') . '"><i class="glyphicon glyphicon-plus-sign"></i> Assign to Invoice</a>';
                elseif ($data->payment_type == 'College to Agent')
                    return format_id($data->college_invoice_id, 'CI');
                else
                    return 'Cannot Be Assigned';
            })
            ->editColumn('date_paid', function ($data) {
                return format_date($data->date_paid);
            })
            ->editColumn('college_payment_id', function ($data) {
                return format_id($data->college_payment_id, 'CP');
            });
        return $datatable->make(true);
    }

    /**
     * Get all the invoices through ajax request.
     *
     * @return JSON response
     */
    function getInvoicesData($application_id)
    {
        /*$invoices = CollegeInvoice::join('course_application', 'course_application.course_application_id', '=', 'college_invoices.course_application_id')
            ->where('course_application.course_application_id', $application_id)
            ->select(['college_invoices.*'])
            ->orderBy('college_invoices.created_at', 'desc');*/

        $invoices = CollegeInvoice::where('course_application_id', $application_id)->select(['*'])->orderBy('created_at', 'desc');
        $datatable = \Datatables::of($invoices)
            ->addColumn('action', function ($data) {
                return '<div class="btn-group">
                  <button class="btn btn-primary" type="button">Action</button>
                  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="' . route("tenant.invoice.payments", [$data->college_invoice_id, 1]) . '">View payments</a></li>
                    <li><a href="' . route('tenant.college.invoice', $data->college_invoice_id) . '">View Invoice</a></li>
                    <li><a href="'.route("tenant.college.editInvoice", $data->college_invoice_id).'">Edit</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">Delete</a></li>
                  </ul>
                </div>';
            })
            ->addColumn('status', function ($data) {
                $outstanding = $this->invoice->getOutstandingAmount($data->college_invoice_id);
                return ($outstanding != 0) ? 'Outstanding' : 'Paid';
            })
            ->addColumn('outstanding_amount', function ($data) {
                $outstanding = $this->invoice->getOutstandingAmount($data->college_invoice_id);
                if ($outstanding != 0)
                    return $outstanding . ' <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="' . url('tenant/invoices/' . $data->college_invoice_id . '/payment/add/1') . '"><i class="glyphicon glyphicon-plus-sign"></i> Add Payment</a>';
                else
                    return 0;
            })
            ->editColumn('invoice_date', function ($data) {
                return format_date($data->invoice_date);
            })
            ->editColumn('college_invoice_id', function ($data) {
                return format_id($data->college_invoice_id, 'CI');
            });
        return $datatable->make(true);
    }

    /**
     * Get all the invoices through ajax request.
     *
     * @return JSON response
     */
    function getRecentData($application_id)
    {
        /*$invoices = CollegeInvoice::join('course_application', 'course_application.course_application_id', '=', 'college_invoices.course_application_id')
            ->where('course_application.course_application_id', $application_id)
            ->select(['college_invoices.*'])
            ->orderBy('college_invoices.created_at', 'desc');*/

        $invoices = CollegeInvoice::where('course_application_id', $application_id)->where('invoice_date', '>=', Carbon\Carbon::now())->select(['*'])->orderBy('created_at', 'desc');
        $datatable = \Datatables::of($invoices)
            ->addColumn('action', function ($data) {
                return '<div class="btn-group">
                  <button class="btn btn-primary" type="button">Action</button>
                  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="' . route("tenant.invoice.payments", [$data->college_invoice_id, 1]) . '">View payments</a></li>
                    <li><a href="' . route('tenant.college.invoice', $data->college_invoice_id) . '">View Invoice</a></li>
                    <li><a href="'.route("tenant.college.editInvoice", $data->college_invoice_id).'">Edit</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">Delete</a></li>
                  </ul>
                </div>';
            })
            ->addColumn('status', function ($data) {
                $outstanding = $this->invoice->getOutstandingAmount($data->college_invoice_id);
                return ($outstanding != 0) ? 'Outstanding' : 'Paid';
            })
            ->addColumn('outstanding_amount', function ($data) {
                $outstanding = $this->invoice->getOutstandingAmount($data->college_invoice_id);
                if ($outstanding != 0)
                    return $outstanding . ' <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="' . url('tenant/invoices/' . $data->college_invoice_id . '/payment/add/1') . '"><i class="glyphicon glyphicon-plus-sign"></i> Add Payment</a>';
                else
                    return 0;
            })
            ->editColumn('invoice_date', function ($data) {
                return format_date($data->invoice_date);
            })
            ->editColumn('college_invoice_id', function ($data) {
                return format_id($data->college_invoice_id, 'CI');
            });
        return $datatable->make(true);
    }

    public function show($invoice_id)
    {
        $data['agency'] = $this->agent->getAgentDetails();
        $data['bank'] = $this->setting->getBankDetails();
        $data['invoice'] = $invoice = $this->invoice->getDetails($invoice_id); //dd($data['invoice']->toArray());
        $data['client_name'] = $this->application->getClientName($invoice->course_application_id);
        $data['pay_details'] = $this->invoice->getPayDetails($invoice_id);
        $super_agent = CourseApplication::find($invoice->course_application_id)->super_agent_id;
        if($super_agent != null && $super_agent != 0)
            $data['invoice_to'] = get_agent_name($super_agent);
        else
            $data['invoice_to'] = 'Thom Zheng';
        return view("Tenant::College/Invoice/show", $data);
    }

    /**
     * Assign payment to invoice
     */
    function assignInvoice($payment_id, $application_id)
    {
        $data['invoice_array'] = $this->invoice->getList($application_id);
        $data['payment_id'] = $payment_id;
        $data['college'] = true;
        return view("Tenant::Client/Payment/assign", $data);
    }

    public function editInvoice($invoice_id)
    {
        $data['invoice'] = $this->invoice->getDetails($invoice_id);
        return view("Tenant::Student/Invoice/edit", $data);
    }

    public function updateInvoice($invoice_id)
    {
        $rules = [
            'invoice_amount' => 'required|numeric',
            'invoice_date' => 'required',
            'due_date' => 'required'
        ];
        $this->validate($this->request, $rules);

        $application_id = $this->invoice->editInvoice($this->request->all(), $invoice_id);
        Flash::success('Invoice has been updated successfully.');
        return redirect()->route('tenant.application.students', $application_id);
    }

}
