<?php namespace App\Modules\Tenant\Models\Institute;

use Illuminate\Database\Eloquent\Model;
use DB;

class InstituteCourse extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'institute_courses';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'institute_course_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['institute_course_id', 'course_id', 'institute_id', 'description'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Get the course associated with the institute course.
     */
    public function course()
    {
        return $this->belongsTo('App\Modules\Tenant\Models\Course\Course');
    }

    /**
     * Get courses attached to institute.
     *
     * @return Collection
     */
    public function getInstituteCourses($institution_id)
    {
        $courses = InstituteCourse::with('course')->where('institution_id', $institution_id)->orderBy('institute_course_id', 'desc')->get();
        return $courses;
    }
}
