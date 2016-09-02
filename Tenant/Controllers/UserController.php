<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\User;
use DB;
use Illuminate\Http\Request;
use Flash;
use App\Modules\Tenant\Models\Application\ApplicationStatus;

class UserController extends BaseController {

	protected $user;
	/* Validation rules for user create and edit */
	protected $rules = [
		'first_name' => 'required|min:2|max:55',
		'last_name' => 'required|alpha|min:2|max:55',
		'middle_name' => 'alpha|min:2|max:55',
		'dob' => 'required',
		'number' => 'required'
	];

	function __construct(User $user,ApplicationStatus $applicationStatus)
	{
		$this->user = $user;
		$this->applicationStatus=$applicationStatus;
		parent::__construct();
	}

	// user dashboard
	public function dashboard(){
		$data['active_clients']=$this->user->activeClient();
		for($record=1;$record<=7;$record++){
			$data['status'][$record]=$this->applicationStatus->statusRecord($record);
		}	

		return view("Tenant::User/dashboard",$data);
	}

	/**
	 * Display a listing of the users.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view("Tenant::User/index");
	}

	/**
	 * Get all the users through ajax request.
	 *
	 * @return JSON response
	 */
	function getData(Request $request)
	{
		$users = User::join('persons', 'persons.person_id', '=', 'users.person_id')
			->select(['users.user_id', 'persons.first_name', 'persons.last_name', 'users.email', 'users.status', 'users.created_at', DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname')]);

		$datatable = \Datatables::of($users)
			->addColumn('action', '<a data-toggle="tooltip" title="View User" class="btn btn-action-box" href ="{{ route( \'tenant.user.show\', $user_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Edit User" class="btn btn-action-box" href ="{{ route( \'tenant.user.edit\', $user_id) }}"><i class="fa fa-edit"></i></a> <a data-toggle="tooltip" title="Delete User" class="delete-user btn btn-action-box" href="{{ route( \'tenant.user.destroy\', $user_id) }}"><i class="fa fa-trash"></i></a>')
			->editColumn('status','@if($status == 0)
                                <span class="label label-warning">Pending</span>
                            @elseif($status == 1)
                                <span class="label label-success">Activated</span>
                            @elseif($status == 2)
                                <span class="label label-info">Suspended</span>
                            @else
                                <span class="label label-danger">Trashed</span>
                            @endif')
			->editColumn('user_id', function($data){return format_id($data->user_id, 'U'); })
			->editColumn('created_at', function($data){return format_datetime($data->created_at); });
		// Global search function
		if ($keyword = $request->get('search')['value']) {
			// override users.id global search - demo for concat
			$datatable->filterColumn('fullname', 'whereRaw', "CONCAT(first_name,' ',last_name) like ?", ["%$keyword%"]);
		}
		return $datatable->make(true);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('Tenant::User/add');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		/* Additional validations for creating user */
		$this->rules['email'] = 'required|email|min:5|max:55|unique:users';

		$this->validate($request, $this->rules);
		// if validates
		$created = $this->user->add($request->all());
		if($created)
			Flash::success('User has been created successfully.');
		return redirect()->route('tenant.user.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $user_id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($user_id = null)
	{
		// View Own Profile
		if($user_id == null)
			$user_id = current_user_id();

		/* Getting the user details*/
		//$data['user'] = User::join('persons', 'persons.person_id', '=', 'users.person_id')->where('users.user_id', $user_id)->first();
		$data['user'] = $this->user->getDetails($user_id);

		if($data['user'] != null)
			return view('Tenant::User/edit', $data);
		else
			return show_404();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($user_id = null, Request $request)
	{
		// Update Own Profile
		if($user_id == null)
			$user_id = current_user_id();

		/* Additional validation rules checking for uniqueness */
		$this->rules['email'] = 'required|email|min:5|max:55|unique:users,email,'.$user_id;

		$this->validate($request, $this->rules);
		// if validates
		$updated = $this->user->edit($request->all(), $user_id);
		if($updated)
			Flash::success('User has been updated successfully.');
		return redirect()->route('tenant.user.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function profile()
	{

	}

}
