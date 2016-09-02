<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Agent;
use App\Modules\Tenant\Models\Application\ApplicationStatus;
use App\Modules\Tenant\Models\Client\ApplicationNotes;
use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\Application\CourseApplication;
use App\Modules\Tenant\Models\Course\BroadField;
use App\Modules\Tenant\Models\Course\NarrowField;
use App\Modules\Tenant\Models\Institute\Institute;
use App\Modules\Tenant\Models\Invoice\CollegeInvoice;
use App\Modules\Tenant\Models\Invoice\StudentInvoice;
use App\Modules\Tenant\Models\Payment\CollegePayment;
use App\Modules\Tenant\Models\Timeline\ClientTimeline;
use Flash;
use DB;

use Illuminate\Http\Request;

class ApplicationController extends BaseController
{

    protected $request;/* Validation rules for user create and edit */
    protected $rules = [
        'amount' => 'required|numeric',
        'date_paid' => 'required',
        'payment_method' => 'required|min:2|max:45'
    ];

    function __construct(Client $client, Request $request, CourseApplication $application, Institute $institute, Agent $agent, CollegePayment $payment, CollegeInvoice $invoice, StudentInvoice $student_invoice, ApplicationNotes $notes, ClientTimeline $timeline, ApplicationStatus $status)
    {
        $this->client = $client;
        $this->request = $request;
        $this->application = $application;
        $this->institute = $institute;
        $this->agent = $agent;
        $this->payment = $payment;
        $this->invoice = $invoice;
        $this->notes = $notes;
        $this->timeline = $timeline;
        $this->student_invoice = $student_invoice;
        $this->status = $status;
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
        return view("Tenant::Client/Application/index", $data);
    }

    /**
     * Get all the payments through ajax request.
     *
     * @return JSON response
     */
    function getApplicationsData($client_id)
    {
        $clients = CourseApplication::leftJoin('institutes', 'course_application.institute_id', '=', 'institutes.institution_id')
            ->leftJoin('companies', 'institutes.company_id', '=', 'companies.company_id')
            ->leftJoin('courses', 'course_application.institution_course_id', '=', 'courses.course_id')
            ->leftJoin('intakes', 'course_application.intake_id', '=', 'intakes.intake_id')
            ->where('course_application.client_id', $client_id)
            ->select(['companies.name', 'courses.name as course_name', 'course_application.end_date', 'intakes.orientation_date', 'course_application.student_id', 'course_application.course_application_id as application_id', 'course_application.tuition_fee', 'course_application.user_id as added_by']);

        $datatable = \Datatables::of($clients)
            ->addColumn('action', '<a data-toggle="tooltip" title="View Application" class="btn btn-action-box" href ="{{ route( \'tenant.application.show\', $application_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Application Documents" class="btn btn-action-box" href ="{{ route( \'tenant.application.document\', $application_id) }}"><i class="fa fa-file"></i></a> <a data-toggle="tooltip" title="Edit Application" class="btn btn-action-box" href ="{{ route( \'tenant.application.edit\', $application_id) }}"><i class="fa fa-edit"></i></a> <a data-toggle="tooltip" title="Delete Application" class="delete-user btn btn-action-box" href="{{ route( \'tenant.application.destroy\', $application_id) }}"><i class="fa fa-trash"></i></a>')
            ->editColumn('application_id', function ($data) {
                return format_id($data->application_id, 'App');
            })
            ->editColumn('added_by', function ($data) {
                return get_tenant_name($data->added_by);
            })
            ->addColumn('status', 'COE Processing'); //change this later
        // Global search function
        return $datatable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($client_id)
    {
        $data['institutes'] = $this->institute->getList();
        $data['courses'] = ['' => 'Select Course'];
        $data['intakes'] = ['' => 'Select Intake'];
        $data['agents'] = $this->agent->getAgents();
        $data['client'] = $this->client->getDetails($client_id);
        return view('Tenant::Client/Application/add', $data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($client_id)
    {
        /* Additional validations for creating user */
        /*$this->rules['email'] = 'required|email|min:5|max:55|unique:users';

        $this->validate($this->request, $this->rules);*/
        // if validates
        $created = $this->application->add($this->request->all(), $client_id);
        if ($created) {
            Flash::success('Application has been created successfully.');

            $app = $this->application->getDetails($created);
            $this->client->addLog($client_id, 6, ['{{NAME}}' => get_tenant_name(), '{{INSTITUTE}}' => $app->company_name, '{{COURSE}}' => $app->course_name, '{{INTAKE_DATE}}' => format_date($app->intake_date), '{{TUITION_FEE}}' => $app->tuition_fee, '{{VIEW_LINK}}' => route('tenant.application.show', $created)], $created);
        }
        return redirect()->route('tenant.client.application', $client_id);
    }

    /**
     * Get Institute Add form
     */
    function createInstitute()
    {
        return view("Tenant::Client/Application/institute");
    }

    /**
     * Get Course Add form
     */
    function createCourse()
    {
        $data['broad_fields'] = BroadField::lists('name', 'id');
        $data['narrow_fields'] = NarrowField::where('broad_field_id', 1)->lists('name', 'id');
        return view("Tenant::Client/Application/course", $data);
    }

    /**
     * Get Intake Add form
     */
    function createIntake()
    {
        return view("Tenant::Client/Application/intake");
    }

    /**
     * Get Sub Agent Add form
     */
    function createAgent()
    {
        return view("Tenant::Client/Application/subagent");
    }

    /**
     * Get Sub Agent Add form
     */
    function createSuperAgent()
    {
        return view("Tenant::Client/Application/superagent");
    }

    /**
     * Display the specified resource.
     *
     * @param  int $client_id
     * @return Response
     */
    public function show($application_id)
    {
        $data['stats']=null;
        $data['agents'] = $this->agent->getAll();
        $data['application'] = $application = $this->application->getDetails($application_id); //dd($data['application']->toArray());
        $data['paid_to_college'] = $this->payment->paymentToCollege($application_id);
        $remaining = $application->tuition_fee - $data['paid_to_college'];
        $data['remaining'] = ($remaining < 0)? 0 : $remaining;

        $data['total_commission_amount'] = $this->invoice->getTotalAmount($application_id);
        $data['commission_claimed'] = $this->payment->commissionClaimed($application_id);
        $remaining_commission = $data['total_commission_amount'] - $data['commission_claimed'];
        $data['remaining_commission'] = ($remaining_commission < 0)? 0 : $remaining_commission;

        $data['status'] = $this->status->getStatusDetails($application_id);

        $student_stats = $this->student_invoice->getStats($application_id);
        $data['student_outstanding'] = $student_stats['due_amount'];
        $college_stats = $data['college_stats'] = $this->invoice->getStats($application_id);
        $data['college_outstanding'] = $college_stats['due_amount'];
        $data['uninvoiced_amount'] = $this->payment->getUninvoicedAmount($application_id);
        $data['client'] = $this->client->getDetails($application->client_id);
        return view("Tenant::Client/Application/show", $data);
    }

    public function details($application_id)
    {
        $client_id = CourseApplication::find($application_id)->client_id;
        $app = new \stdClass();
        $app->application_id = $application_id;
        $data['application'] = $app;
        $data['client'] = $this->client->getDetails($client_id);
        $data['timelines'] = $this->timeline->getDetails($application_id, true);
        return view("Tenant::Client/Application/details", $data);
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

    // Directly From Application Dashboard
    public function createSubAgent($application_id, Request $request)
    {
        $application = CourseApplication::find($application_id);
        $application->sub_agent_id = $request->agent_id;
        $application->save();

        Flash::success('Sub Agent has been added successfully.');
        return redirect()->route('tenant.application.show', $application_id);
    }

    public function addSuperAgent($application_id, Request $request)
    {
        $application = CourseApplication::find($application_id);
        $application->super_agent_id = $request->agent_id;
        $application->save();

        Flash::success('Super Agent has been added successfully.');
        return redirect()->route('tenant.application.show', $application_id);
    }

    function notes($application_id)
    {
        $client_id = CourseApplication::find($application_id)->client_id;
        $app = new \stdClass();
        $app->application_id = $application_id;
        $data['application'] = $app;
        $data['client'] = $this->client->getDetails($client_id);
        $data['notes'] = $this->notes->getAll($application_id);
        return view("Tenant::Application/notes", $data);
    }

    function saveNote($application_id)
    {
        $created = $this->notes->add($this->request->all(), $application_id);
        if($created)
            Flash::success('Note has been added successfully.');
        return redirect()->route('tenant.application.notes', $application_id);
    }

}
