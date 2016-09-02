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

    function totalInvoiceAmount($application_id)
    {

    }

    function getClientName($application_id)
    {
        $client = CourseApplication::join('clients', 'clients.client_id', '=', 'course_application.client_id')
        ->leftJoin('persons', 'persons.person_id', '=', 'clients.person_id')
        ->select(DB::raw('CONCAT(first_name, " ", last_name) AS full_name'))
        ->find($application_id);
        return $client->full_name;
    }
}
