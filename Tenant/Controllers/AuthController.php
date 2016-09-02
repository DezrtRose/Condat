<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController {

	protected $auth;

	function __construct(Guard $auth)
	{
		parent::__construct();
		$this->auth = $auth;
	}

	public function getLogin()
	{
		return view('Auth::login');
	}

	public function postLogin(Request $request, User $tenantUser)
	{
		$rules = array('email' => 'required', 'password' => 'required');
		$this->validate($request, $rules);
		

		$credentials = $request->only('email', 'password');
		if (auth()->guard('tenants')->attempt($credentials, $request->has('remember'))) {
			return $tenantUser->redirectIfValid($this->auth->user());
			//return tenant()->route('tenant.client.index'); //change this to index later
		}
		return redirect()->route('tenant.login')->with('message', 'These credentials do not match our records.')->withInput($request->only('email', 'remember'));
	}

	public function logout()
	{
		$this->auth->logout();
		return redirect('login');
	}

	/**
	 * Show the application registration form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getRegister()
	{
		return view('Auth::register');
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
		$validator = $this->validator($request->all());

		if ($validator->fails()) {
			$this->throwValidationException(
				$request, $validator
			);
		}

		$created = Auth::login($this->create($request->all()));
		if($created) {

		}

		return redirect('dashboard');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'given_name' => 'required|max:255',
			'surname' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data)
	{
		return User::create([
			'given_name' => $data['given_name'],
			'surname' => $data['surname'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'status' => 0 //pending
		]);
	}

}
