<?php namespace App\Modules\Tenant\Models\Course;

use App\Modules\Tenant\Models\Fee;
use App\Modules\Tenant\Models\Institute\InstituteCourse;
use Illuminate\Database\Eloquent\Model;
use DB;

class Course extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'course_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'broad_field', 'level', 'narrow_field', 'commission_percent'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;


    /*
     * Add course info
     * Output course id
     */
    function add(array $request, $institute_id)
    {
        DB::beginTransaction();

        try {
            $course = Course::create([
                'name' => $request['name'],
                'broad_field' => $request['broad_field'],
                'level' => $request['level'],
                'narrow_field' => $request['narrow_field'],
                'commission_percent' => $request['commission_percent']
            ]);

            InstituteCourse::create([
                'course_id' => $course->course_id,
                'institute_id' => $institute_id,
                'description' => $request['description'],
            ]);

            $fee = Fee::create([
                'total_tuition_fee' => $request['total_tuition_fee'],
                'coe_fee' => $request['coe_fee'],
            ]);

            CourseFee::create([
                'fees_id' => $fee->fee_id,
                'course_id' => $course->course_id
            ]);

            DB::commit();
            return $course->course_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }


    function getCourses($institute_id)
    {
        $courses = InstituteCourse::join('courses', 'institute_courses.course_id', '=', 'courses.course_id')
            ->where('institute_courses.institute_id', $institute_id)
            ->lists('courses.name', 'courses.course_id');
        return $courses;
    }

    /*
     * Edit course info
     * Output boolean
     */
    function edit(array $request, $course_id)
    {
        DB::beginTransaction();

        try {
            $course = Course::find($course_id);
            $course->name = $request['name'];
            $course->broad_field = $request['broad_field'];
            $course->level = $request['level'];
            $course->narrow_field = $request['narrow_field'];
            $course->commission_percent = $request['commission_percent'];
            $course->save();

            $institute_course = InstituteCourse::where('course_id', $course_id)->first();
            $institute_course->description = $request['description'];
            $institute_course->save();

            $course_fee = CourseFee::where('course_id', $course_id)->first();
            $fee = Fee::find($course_fee->fees_id);
            $fee->total_tuition_fee = $request['total_tuition_fee'];
            $fee->coe_fee = $request['coe_fee'];
            $fee->save();

            DB::commit();
            return $institute_course->institute_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    function getDetails($course_id)
    {
        $course = Course::join('institute_courses', 'institute_courses.course_id', '=', 'courses.course_id')
            ->leftJoin('course_fees', 'course_fees.course_id', '=', 'courses.course_id')
            ->leftJoin('fees', 'fees.fee_id', '=', 'course_fees.fees_id')
            ->select(['institute_courses.description', 'courses.*', 'fees.total_tuition_fee', 'fees.coe_fee'])
            ->find($course_id);
        return $course;
    }
}
