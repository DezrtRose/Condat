<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Course\BroadField;
use App\Modules\Tenant\Models\Course\Course;
use App\Modules\Tenant\Models\Course\NarrowField;
use App\Modules\Tenant\Models\Document;
use App\Modules\Tenant\Models\Institute\Institute;
use App\Modules\Tenant\Models\Institute\InstituteCourse;
use Flash;
use DB;

use Illuminate\Http\Request;

class CourseController extends BaseController
{

    protected $request;/* Validation rules for user create and edit */
    protected $course;
    protected $rules = [
        'name'=>'required|min:2|max:255',
        'level'=>'required|min:2|max:155',
        'coe_fee' => 'required|numeric',
        'total_tuition_fee' => 'required|numeric',
    ];

    function __construct(Course $course, Institute $institute, Request $request)
    {
        $this->course = $course;
        $this->institute = $institute;
        $this->request = $request;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($institution_id)
    {
        $data['institute'] = $this->institute->getDetails($institution_id);
        $data['institution_id'] = $institution_id;
        return view("Tenant::Course/index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($institution_id)
    {
        $courses = InstituteCourse::join('courses', 'institute_courses.course_id', '=', 'courses.course_id')
        ->where('institute_courses.institute_id', $institution_id)
        ->select('courses.commission_percent')
        ->orderBy('courses.course_id', 'desc')
        ->first();
        $data['commission_percent']= $courses['commission_percent'];

        $data['institution_id'] = $institution_id;
        $data['broad_fields'] = BroadField::lists('name', 'id');
        $data['narrow_fields'] = NarrowField::where('broad_field_id', 1)->lists('name', 'id');
        /* send in data for dropdowns : fields and level */
        return view('Tenant::Course/add', $data);
    }

    /**
     * Get narrow fields based on broad field selected
     *
     * @return JSON Array
     */
    public function getNarrowField($broad_id)
    {
        if ($this->request->ajax()) {
            $fields = NarrowField::where('broad_field_id', $broad_id)->lists('name', 'id');
            $options = '';
            foreach ($fields as $key => $field) {
                $options .= "<option value =" . $key . ">" . $field . "</option>";
            }
            return $this->success(['options' => $options]);
        } else {
            return $this->fail(['error' => 'The method is not authorized.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($institution_id)
    {
        if($this->request->ajax()) {
            $validator = \Validator::make($this->request->all(), $this->rules);
            if ($validator->fails())
                return $this->fail(['errors' => $validator->getMessageBag()->toArray()]);
            // if validates
            $course_id = $this->course->add($this->request->all(), $institution_id);
            return $this->success(['course_id' => $course_id, 'name' => $this->request->get('name')]);
        }
        else {
            $this->validate($this->request, $this->rules);
            // if validates
            $course_id = $this->course->add($this->request->all(), $institution_id);
            if ($course_id)
                Flash::success('Course has been created successfully.');
            return redirect()->route('tenant.institute.show', $institution_id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $course_id
     * @return Response
     */
    public function show($course_id)
    {
        $data['course'] = $this->course->getDetails($course_id);
        return view("Tenant::Course/show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($course_id)
    {
        /* Getting the course details*/
        $data['course'] = $course = $this->course->getDetails($course_id);
        $data['broad_fields'] = BroadField::lists('name', 'id');
        $data['narrow_fields'] = NarrowField::where('broad_field_id', $course->broad_field)->lists('name', 'id');
        return view('Tenant::Course/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $institution_id
     * @return Response
     */
    public function update($course_id)
    {
        $this->validate($this->request, $this->rules);
        // if validates
        $institution_id = $this->course->edit($this->request->all(), $course_id);
        if ($institution_id)
            Flash::success('Course has been updated successfully.');
        return redirect()->route('tenant.course.index', $institution_id);
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

    /**
     * Get courses based on institute selected
     *
     * @return JSON Array
     */
    public function getCourses($institute_id)
    {
        if ($this->request->ajax()) {
            $courses = $this->course->getCourses($institute_id);
            $options = '';
            foreach ($courses as $key => $course) {
                $options .= "<option value =" . $key . ">" . $course . "</option>";
            }
            return $this->success(['options' => $options]);
        } else {
            return $this->fail(['error' => 'The method is not authorized.']);
        }
    }
}
