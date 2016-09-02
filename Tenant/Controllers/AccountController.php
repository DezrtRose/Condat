<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Application\CourseApplication;
use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\Client\ClientPayment;
use App\Modules\Tenant\Models\Invoice\Invoice;
use App\Modules\Tenant\Models\Invoice\StudentInvoice;
use Flash;
use DB;

use Illuminate\Http\Request;
use Carbon;

class AccountController extends BaseController
{

    protected $request;/* Validation rules for user create and edit */
    protected $rules = [
        'amount' => 'required|numeric',
        'date_paid' => 'required',
        'payment_method' => 'required|min:2|max:45'
    ];

    function __construct(Client $client, Request $request, ClientPayment $payment, StudentInvoice $invoice, CourseApplication $application)
    {
        $this->client = $client;
        $this->request = $request;
        $this->payment = $payment;
        $this->invoice = $invoice;
        $this->application = $application;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        return view("Tenant::Client/account_summary", $data);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function createClientInvoice($client_id)
    {
        $data['client_id'] = $client_id;
        $data['applications'] = $this->application->getClientApplication($client_id);
        return view("Tenant::Client/Invoice/add", $data);
    }

    public function storeClientInvoice($client_id)
    {
        $rules = [
            'amount' => 'required|numeric',
            'invoice_amount' => 'required|numeric',
            'discount' => 'required|numeric',
            'invoice_date' => 'required',
            'due_date' => 'required'
        ];
        $this->validate($this->request, $rules);
        // if validates
        $created = $this->invoice->add($this->request->all(), $client_id);
        if ($created) {
            Flash::success('Invoice has been created successfully.');
            $invoice = StudentInvoice::join('invoices', 'invoices.invoice_id', '=', 'student_invoices.invoice_id')->find($created);
            $this->client->addLog($client_id, 4, ['{{NAME}}' => get_tenant_name(), '{{DESCRIPTION}}' => $invoice->description, '{{DATE}}' => format_date($invoice->invoice_date), '{{AMOUNT}}' => $invoice->amount, '{{VIEW_LINK}}' => route("tenant.student.invoice", $invoice->student_invoice_id)], $invoice->application_id);
        }
        return redirect()->route('tenant.accounts.index', $client_id);
    }

    public function createClientPayment($client_id)
    {
        $data['client_id'] = $client_id;
        return view("Tenant::Client/Payment/add", $data);
    }

    public function storeClientPayment($client_id)
    {
        $this->validate($this->request, $this->rules);
        // if validates
        $created = $this->payment->add($this->request->all(), $client_id);
        if ($created) {
            Flash::success('Payment has been added successfully.');
            $payment = ClientPayment::find($created);
            $this->client->addLog($client_id, 5, ['{{NAME}}' => get_tenant_name(), '{{TYPE}}' => $payment->payment_type, '{{DESCRIPTION}}' => $payment->description, '{{DATE}}' => format_date($payment->date_paid), '{{AMOUNT}}' => $payment->amount, '{{VIEW_LINK}}' => '']);
        }
        return redirect()->route('tenant.accounts.index', $client_id);
    }

    public function editClientPayment()
    {
        return view("Tenant::Client/index");
    }


    public function showClientInvoice()
    {
        return view("Tenant::Client/index");
    }


    public function showClientPayment()
    {
        return view("Tenant::Client/index");
    }


    /**
     * Get all the payments through ajax request.
     *
     * @return JSON response
     */
    function getPaymentsData($client_id)
    {
        $payments = ClientPayment::where('client_id', $client_id)->whereIn('payment_type', config('constants.payment_by'))->select(['*']);

        $datatable = \Datatables::of($payments)
            ->addColumn('action', '<div class="btn-group">
                  <button class="btn btn-primary" type="button">Action</button>
                  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="http://localhost/condat/tenant/contact/2">Add payment</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">View</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">Edit</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">Delete</a></li>
                  </ul>
                </div>')
            ->addColumn('invoice_id', 'Uninvoiced <button class="btn btn-success btn-xs"><i class="glyphicon glyphicon-plus-sign"></i> Assign to Invoice</button>')
            ->editColumn('date_paid', function ($data) {
                return format_date($data->date_paid);
            })
            ->editColumn('client_payment_id', function ($data) {
                return format_id($data->client_payment_id, 'P');
            });
        return $datatable->make(true);
    }

    /**
     * Get all the invoices through ajax request.
     *
     * @return JSON response
     */
    function getInvoicesData($client_id)
    {
        $invoices = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->leftJoin('course_application', 'course_application.course_application_id', '=', 'student_invoices.application_id')
            ->where('student_invoices.client_id', $client_id)
            ->select(['invoices.*', 'student_invoices.student_invoice_id'])
            ->orderBy('invoices.created_at', 'desc');

        $datatable = \Datatables::of($invoices)
            ->addColumn('action', function ($data) {
                return '<div class="btn-group">
                    <button class="btn btn-primary" type="button">Action</button>
                  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="http://localhost/condat/tenant/contact/2">Add payment</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">View</a></li>
                    <li><a href="' . route("tenant.invoice.edit", $data->student_invoice_id) . '">Edit</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">Delete</a></li>
                  </ul>
                </div>';
            })
            ->addColumn('status', function ($data) {
                $outstanding = $this->invoice->getOutstandingAmount($data->invoice_id);
                return ($outstanding != 0) ? 'Outstanding' : 'Paid';
            })
            ->addColumn('outstanding_amount', function ($data) {
                $outstanding = $this->invoice->getOutstandingAmount($data->invoice_id);
                if ($outstanding != 0)
                    return $outstanding . ' <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="' . url('tenant/invoices/' . $data->invoice_id . '/payment/add/2') . '"><i class="glyphicon glyphicon-plus-sign"></i> Add Payment</a>';
                else
                    return 0;
            })
            ->editColumn('invoice_date', function ($data) {
                return format_date($data->invoice_date);
            })
            ->editColumn('invoice_id', function ($data) {
                return format_id($data->invoice_id, 'I');
            });
        return $datatable->make(true);
    }

    /**
     * Get all the future invoices through ajax request.
     *
     * @return JSON response
     */
    function getFutureData($client_id)
    {
        $invoices = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->join('course_application', 'course_application.course_application_id', '=', 'student_invoices.application_id')
            ->where('course_application.client_id', $client_id)
            ->where('invoice_date', '>=', Carbon\Carbon::now())
            ->select(['invoices.*'])
            ->orderBy('invoices.created_at', 'desc');

        $datatable = \Datatables::of($invoices)
            ->addColumn('action', '<div class="btn-group">
                  <button class="btn btn-primary" type="button">Action</button>
                  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="http://localhost/condat/tenant/contact/2">Add payment</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">View</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">Edit</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">Delete</a></li>
                  </ul>
                </div>')
            ->addColumn('status', function ($data) {
                $outstanding = $this->invoice->getOutstandingAmount($data->invoice_id);
                return ($outstanding != 0) ? 'Outstanding' : 'Paid';
            })
            ->addColumn('outstanding_amount', function ($data) {
                $outstanding = $this->invoice->getOutstandingAmount($data->invoice_id);
                if ($outstanding != 0)
                    return $outstanding . ' <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="' . url('tenant/invoices/' . $data->invoice_id . '/payment/add/2') . '"><i class="glyphicon glyphicon-plus-sign"></i> Add Payment</a>';
                else
                    return 0;
            })
            ->editColumn('invoice_date', function ($data) {
                return format_date($data->invoice_date);
            })
            ->editColumn('invoice_id', function ($data) {
                return format_id($data->invoice_id, 'I');
            });
        return $datatable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('Tenant::Client/add');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        /* Additional validations for creating user */
        $this->rules['email'] = 'required|email|min:5|max:55|unique:users';

        $this->validate($this->request, $this->rules);
        // if validates
        $created = $this->client->add($this->request->all());
        if ($created)
            Flash::success('Client has been created successfully.');
        return redirect()->route('tenant.client.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $client_payment_id
     * @return Response
     */
    public function show($client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        return view("Tenant::Client/show", $data);
    }

    public function personal_details($client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        return view("Tenant::Client/personal_details", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($client_id)
    {
        /* Getting the client details*/
        $data['client'] = $this->client->getDetails($client_id);
        if ($data['client'] != null) {
            $data['client']->dob = format_date($data['client']->dob);
            return view('Tenant::Client/edit', $data);
        } else
            return show_404();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $client_id
     * @return Response
     */
    public function update($client_id)
    {
        $user_id = $this->request->get('user_id');
        /* Additional validation rules checking for uniqueness */
        $this->rules['email'] = 'required|email|min:5|max:55|unique:users,email,' . $user_id . ',user_id';

        $this->validate($this->request, $this->rules);
        // if validates
        $updated = $this->client->edit($this->request->all(), $client_id);
        if ($updated)
            Flash::success('Client has been updated successfully.');
        return redirect()->route('tenant.client.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function editInvoice($invoice_id)
    {
        $data['invoice'] = $invoice = $this->invoice->getDetails($invoice_id);
        $data['client_id'] = $invoice->client_id;
        $data['applications'] = $this->application->getClientApplication($data['client_id']);

        return view("Tenant::Client/Invoice/edit", $data);
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
