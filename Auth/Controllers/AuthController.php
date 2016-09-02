<?php namespace App\Modules\Auth\Controllers;

use App\Http\Requests;
use App\Http\Controllers\BaseController;
use App\Modules\User\Models\User;
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

	public function postLogin(Request $request, User $systemUser)
	{
		$validator = Validator::make($request->all(), array('email' => 'required', 'password' => 'required'));
		if ($validator->fails())
			return redirect()->to('login')->withErrors($validator)->withInput();

		$credentials = $request->only('email', 'password');
		if ($this->auth->attempt($credentials, $request->has('remember'))) {
			return $systemUser->redirectIfValid($this->auth->user());
		}
		return redirect('login')->with('message', 'These credentials do not match our records.')->withInput($request->only('email', 'remember'));
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
