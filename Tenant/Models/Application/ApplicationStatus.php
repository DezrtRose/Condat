<?php namespace App\Modules\Tenant\Models\Application;

use App\Modules\Tenant\Models\Client\ApplicationNotes;
use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\Document;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use App\Modules\Tenant\Models\Application\CourseApplication;
use Illuminate\Http\Request;

class ApplicationStatus extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'application_status';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'application_status_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['course_application_id', 'status_id', 'date_applied', 'date_removed', 'active'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;

    function getApplications($status = 1)
    {
        $applications = CourseApplication::join('clients', 'clients.client_id', '=', 'course_application.client_id')
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
            ->select([DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname'), 'companies.name as company', 'companies.invoice_to_name as invoice_to', 'courses.name', 'intakes.intake_date', 'course_application.course_application_id', 'phones.number', 'emails.email'])
            ->where('application_status.active', 1)
            ->where('application_status.status_id', $status)
            ->orderBy('course_application.course_application_id', 'desc')
            ->get();
        return $applications;
    }

    function offer_create(array $request, $course_application_id)
    {
        DB::beginTransaction();

        try {

            $status = ApplicationStatus::where('course_application_id', $course_application_id)
                ->where('status_id', 3)
                ->first();
            if (!$status) {
                $status = ApplicationStatus::create([
                    'course_application_id' => $course_application_id,
                    'status_id' => 3,
                    'date_applied' => Carbon::now()
                ]);
            }


            DB::commit();
            return true;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            //return false;
            dd($e);
            // something went wrong
        }
    }

    function coe_create(array $request, $course_application_id)
    {
        DB::beginTransaction();

        try {

            $status = ApplicationStatus::where('course_application_id', $course_application_id)
                ->where('status_id', 4)
                ->first();
            if (!$status) {
                $status = ApplicationStatus::create([
                    'course_application_id' => $course_application_id,
                    'status_id' => 4,
                    'date_applied' => Carbon::now()
                ]);
            }


            DB::commit();
            return true;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            //return false;
            dd($e);
            // something went wrong
        }
    }

    function coe_issued_create(array $request, $course_application_id)
    {
        DB::beginTransaction();

        try {

            $status = ApplicationStatus::where('course_application_id', $course_application_id)
                ->where('status_id', 5)
                ->first();
            if (!$status) {
                $status = ApplicationStatus::create([
                    'course_application_id' => $course_application_id,
                    'status_id' => 5,
                    'date_applied' => Carbon::now()
                ]);
            }


            DB::commit();
            return true;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            //return false;
            dd($e);
            // something went wrong
        }
    }

    function apply_offer(array $request, $course_application_id)
    {
        DB::beginTransaction();

        try {
            $applications = CourseApplication::find($course_application_id);
            $applications->tuition_fee = $request['tuition_fee'];
            $applications->intake_id = $request['intake_id'];
            $applications->save();

            $this->change_status($course_application_id, 2);

            $this->add_timeline($course_application_id, 2);

            DB::commit();
            return true;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            //return false;
            dd($e);
            // something went wrong
        }
    }

    function change_status($application_id, $status_id)
    {
        $previous_status = ApplicationStatus::where('course_application_id', $application_id)->where('active', 1)->first();
        $previous_status->active = 0;
        $previous_status->date_removed = get_today_datetime();
        $previous_status->save();

        ApplicationStatus::create([
            'course_application_id' => $application_id,
            'status_id' => $status_id,
            'date_applied' => Carbon::now(),
            'active' => 1
        ]);
    }

    function add_timeline($application_id, $status_id)
    {
        $client = new Client();
        $client_id = CourseApplication::find($application_id)->client_id;
        $status1 = Status::find($status_id - 1)->decription;
        $status2 = Status::find($status_id)->decription;

        $client->addLog($client_id, 7, ['{{NAME}}' => get_tenant_name(), '{{STATUS1}}' => $status1, '{{STATUS2}}' => $status2, '{{VIEW_LINK}}' => route('tenant.application.show', $application_id)], $application_id);
    }

    function offer_received(array $request, $course_application_id)
    {
        DB::beginTransaction();

        try {
            $applications = CourseApplication::find($course_application_id);
            $applications->tuition_fee = $request['tuition_fee'];
            $applications->intake_id = $request['intake_id'];
            $applications->student_id = $request['student_id'];
            $applications->fee_for_coe = $request['fee_for_coe'];
            $applications->save();

            //Add Note
            $note = new ApplicationNotes();
            $note->add($request, $course_application_id);
            $client = new Client();
            $client->addLog($applications->client_id, 2, ['{{DESCRIPTION}}' => $request['description'], '{{NAME}}' => get_tenant_name()], $course_application_id);

            //Upload Document
            $this->uploadDocument($course_application_id, 2, $request);

            $this->change_status($course_application_id, 3);

            DB::commit();
            return true;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            //return false;
            dd($e);
            // something went wrong
        }
    }

    function coe_update(array $request, $course_application_id)
    {
        DB::beginTransaction();

        try {
            $applications = CourseApplication::find($course_application_id);
            $applications->fee_for_coe = $request['fee_for_coe'];
            $applications->save();

            $this->change_status($course_application_id, 4);

            DB::commit();
            return true;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            //return false;
            dd($e);
            // something went wrong
        }
    }

    function coe_issued_update(array $request, $course_application_id)
    {
        DB::beginTransaction();

        try {

            $applications = CourseApplication::find($course_application_id);
            $applications->fee_for_coe = $request['total_tuition_fee'];
            $applications->end_date = $request['finish_date'];
            $applications->student_id = $request['student_id'];
            $applications->save();


            DB::commit();
            return true;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            //return false;
            dd($e);
            // something went wrong
        }
    }

    public function statusRecord($status_id)
    {
        $statusRecord = DB::table('application_status')
            ->select('status_id', DB::raw('count(*) as application_no'))
            ->where('status_id', $status_id)
            ->get();
        return $statusRecord;
    }

    function uploadDocument($application_id, $status_id, $request, $file = '')
    {
        $folder = 'document';
        $file = ($file == '') ? 'document' : $file;

        $client_id = CourseApplication::find($application_id)->client_id;
        if ($file_info = tenant()->folder($folder, true)->upload($file)) {
            $document = new ApplicationStatusDocument();
            $document_id = $document->uploadDocument($application_id, $file_info, $request, $status_id);
            $document = Document::find($document_id);
            $client = new Client();
            $client->addLog($client_id, 3, ['{{NAME}}' => get_tenant_name(), '{{DESCRIPTION}}' => $document->description, '{{TYPE}}' => $document->type, '{{FILE_NAME}}' => $document->name, '{{VIEW_LINK}}' => $document->shelf_location, '{{DOWNLOAD_LINK}}' => route('tenant.client.document.download', $document_id)], $application_id);
            return true;
        } else {
            return false;
        }
    }

    function getStatusDetails($application_id)
    {
        $status = ApplicationStatus::join('status', 'application_status.status_id', '=', 'status.status_id')
            ->where('application_status.course_application_id', $application_id)
            ->where('application_status.active', 1)
            ->select('application_status.*', 'status.name')
            ->first();

        $status->action_link = $this->getActionLink($status->status_id, $application_id);

        return $status;
    }

    function getActionLink($status_id, $application_id)
    {
        switch ($status_id) {
            case 1:
                $link = route('applications.apply.offer', $application_id);
                break;
            case 2:
                $link = route('applications.offer.received', $application_id);
                break;
            case 3:
                $link = route('applications.apply.coe', $application_id);
                break;
            case 4:
                $link = route('applications.action.coe.issued', $application_id);
                break;
            case 5:
                $link = route('applications.apply.offer', $application_id);
                break;
            case 6:
                $link = route('applications.apply.offer', $application_id);
                break;
            case 7:
                $link = route('applications.apply.offer', $application_id);
                break;
            default: // For Cancelled Application
                $link = '';
                break;
        }

        return $link;
    }

    function getStats()
    {
        $status = Status::leftJoin('application_status', function ($join) {
            $join->on('application_status.status_id', '=', 'status.status_id');
            $join->where('application_status.active', '=', 1);
            })
            ->select(DB::raw('count(application_status.status_id) as total'), 'status.name')
            ->groupBy('status.name')
            ->orderBy('status.status_id', 'asc')
            ->get();
        return $status;

    }
}