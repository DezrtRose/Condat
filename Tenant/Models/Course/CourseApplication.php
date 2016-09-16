<?php namespace App\Modules\Tenant\Models\Course;

use Illuminate\Database\Eloquent\Model;
use DB;

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
    protected $fillable = ['institution_course_id', 'intake_id', 'end_date', 'super_agent_id', 'sub_agent_id', 'user_id', 'tuition_fee', 'student_id', 'client_id', 'total_discount', 'institute_id', 'location_id', 'sub_agent_commission'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;
}
