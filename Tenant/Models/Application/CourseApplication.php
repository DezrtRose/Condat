<?php namespace App\Modules\Tenant\Models\Application;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon;

class CourseApplication extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'course_application';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'course_application_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['institution_course_id', 'intake_id', 'end_date', 'super_agent_id', 'sub_agent_id', 'user_id', 'tuition_fee', 'student_id', 'client_id', 'fee_for_coe', 'total_discount', 'institute_id', 'location_id', 'sub_agent_commission'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;


    /*
     * Add application info
     * Output application id
     */
    function add(array $request, $client_id)
    {
        DB::beginTransaction();

        try {
            $application = CourseApplication::create([
                'institution_course_id' => $request['institution_course_id'],
                'intake_id' => $request['intake_id'],
                //'end_date' => insert_dateformat($request['end_date']), check this later
                'tuition_fee' => $request['tuition_fee'],
                'super_agent_id' => $request['super_agent_id'],
                'sub_agent_id' => $request['sub_agent_id'],
                'user_id' => current_tenant_id(),
                'student_id' => $request['student_id'],
                'client_id' => $client_id,
                //'total_discount' => $request['total_discount'],
                'institute_id' => $request['institute_id'],
                //'location_id' => $request['location_id'],
                //'sub_agent_commission' => $request['sub_agent_commission'],
            ]);

            ApplicationStatus::create([
                'course_application_id' => $application->course_application_id,
                'status_id' => 1, //enquiry
                'date_applied' => Carbon\Carbon::now(),
                'active' => 1
            ]);

            DB::commit();
            return $application->course_application_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    function getDetails($application_id)
    {
        $application = CourseApplication::leftJoin('institutes', 'course_application.institute_id', '=', 'institutes.institution_id')
            ->leftJoin('companies', 'institutes.company_id', '=', 'companies.company_id')
            ->leftJoin('courses', 'course_application.institution_course_id', '=', 'courses.course_id')
            ->leftJoin('institute_courses', 'institute_courses.course_id', '=', 'courses.course_id')
            ->leftJoin('intakes', 'course_application.intake_id', '=', 'intakes.intake_id')
            ->where('course_application.course_application_id', $application_id)
            //->select(['*'])
            ->select(['companies.name', 'courses.name as course_name', 'companies.name as company_name', 'course_application.end_date', 'course_application.client_id', 'intakes.orientation_date', 'intakes.intake_date', 'intakes.intake_id', 'course_application.institute_id', 'course_application.student_id', 'course_application.course_application_id as application_id', 'course_application.tuition_fee', 'course_application.fee_for_coe', 'course_application.sub_agent_id', 'course_application.super_agent_id', 'course_application.user_id as added_by'])
            ->first();

        return $application;
    }

    function getClientApplication($client_id)
    {
        $applications = CourseApplication::leftJoin('institutes', 'course_application.institute_id', '=', 'institutes.institution_id')
            ->leftJoin('companies', 'institutes.company_id', '=', 'companies.company_id')
            ->leftJoin('courses', 'course_application.institution_course_id', '=', 'courses.course_id')
            ->where('client_id', $client_id)
            ->select([DB::raw('CONCAT(companies.name, ", ", courses.name) AS info'), 'course_application.course_application_id'])
            ->lists('info', 'courses.course_application_id')
            ->all();

        $applications = array("0" => "No Applications") + $applications;
        return $applications;
    }

    function getStats($application_id)
    {
        $application = CourseApplication::leftJoin('institutes', 'course_application.institute_id', '=', 'institutes.institution_id')
            ->leftJoin('companies', 'institutes.company_id', '=', 'companies.company_id')
            ->leftJoin('courses', 'course_application.institution_course_id', '=', 'courses.course_id')
            ->leftJoin('institute_courses', 'institute_courses.course_id', '=', 'courses.course_id')
            ->leftJoin('intakes', 'course_application.intake_id', '=', 'intakes.intake_id')
            ->where('course_application.course_application_id', $application_id)
            //->select(['*'])
            ->select(['companies.name', 'courses.name as course_name', 'companies.name as company_name', 'course_application.end_date', 'course_application.client_id', 'intakes.orientation_date', 'intakes.intake_date', 'course_application.student_id', 'course_application.course_application_id as application_id', 'course_application.tuition_fee', 'course_application.sub_agent_id', 'course_application.super_agent_id', 'course_application.user_id as added_by'])
            ->first();

        return $application;
    }

    function getClientName($application_id)
    {
        $client = CourseApplication::join('clients', 'clients.client_id', '=', 'course_application.client_id')
        ->leftJoin('persons', 'persons.person_id', '=', 'clients.person_id')
        ->select(DB::raw('CONCAT(first_name, " ", last_name) AS full_name'))
        ->find($application_id);
        return $client->full_name;
    }

    function getFilterResults($request)
    {
        //dd($request);
        $applications_query = CourseApplication::join('clients', 'clients.client_id', '=', 'course_application.client_id')
            ->leftJoin('persons', 'clients.person_id', '=', 'persons.person_id')
            ->leftJoin('person_emails', 'person_emails.person_id', '=', 'persons.person_id')
            ->leftJoin('emails', 'emails.email_id', '=', 'person_emails.email_id')
            ->leftjoin('person_phones', 'persons.person_id', '=', 'person_phones.person_id')
            ->leftjoin('phones', 'person_phones.phone_id', '=', 'phones.phone_id')
            ->leftJoin('courses', 'course_application.institution_course_id', '=', 'courses.course_id')
            ->leftJoin('institutes', 'course_application.institute_id', '=', 'institutes.institution_id')
            ->leftJoin('companies', 'institutes.company_id', '=', 'companies.company_id')
            ->leftjoin('intakes', 'intakes.intake_id', '=', 'course_application.intake_id')
            ->join('application_status', 'application_status.course_application_id', '=', 'course_application.course_application_id')
            ->select([DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname'), 'companies.name as company', 'companies.invoice_to_name as invoice_to', 'courses.name', 'intakes.intake_date', 'course_application.course_application_id', 'phones.number', 'emails.email', 'course_application.user_id as added_by'])
            ->where('application_status.active', 1)
            ->orderBy('course_application.course_application_id', 'desc');

        if($request['status'] != 0)
            $applications_query = $applications_query->where('application_status.status_id', $request['status']);

        if($request['added_by'] != 0)
            $applications_query = $applications_query->where('course_application.user_id', $request['added_by']);

        if($request['intake_date'] != '') {
            $dates = explode(' - ', $request['intake_date']);
            $applications_query = $applications_query->whereBetween('intakes.intake_date', array(insert_dateformat($dates[0]), insert_dateformat($dates[1])));
        }

        if($request['course_name'] != '')
            $applications_query = $applications_query->where('courses.name', 'LIKE', '%'.$request['course_name'].'%');

        if($request['client_name'] != '')
            $applications_query = $applications_query->where(DB::raw('CONCAT(persons.first_name, " ", persons.last_name)'), 'LIKE', '%'.$request['client_name'].'%');

        if($request['invoice_to'] != '')
            $applications_query = $applications_query->where('companies.invoice_to_name', 'LIKE', '%'.$request['invoice_to'].'%');

        if(isset($request['super_agent']) && !empty($request['super_agent']))
            $applications_query = $applications_query->whereIn('course_application.super_agent_id', $request['super_agent']);

        if(isset($request['college_name']) && !empty($request['college_name']))
            $applications_query = $applications_query->whereIn('course_application.institute_id', $request['college_name']);

        if(isset($request['sub_agent']) && !empty($request['sub_agent']))
            $applications_query = $applications_query->whereIn('course_application.sub_agent_id', $request['sub_agent']); //invoice to

        $applications = $applications_query->get();

        return $applications;
    }
}
