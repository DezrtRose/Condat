<?php namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Condat;
use Hash;

//use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends BaseController {

	/*
   |--------------------------------------------------------------------------
   | Password Reset Controller
   |--------------------------------------------------------------------------
   |
   | This controller is responsible for handling password reset requests
   | and uses a simple trait to include this behavior.
   |
   */

	/**
	 * Create a new password controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		//$this->middleware('guest');
	}

	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function getForgotPassword()
	{
		return view('Auth::password');
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postForgotPassword()
	{
		$user = User::where('email', '=', Input::only('email'))->first();
		if (!empty($user)) {
			$this->sendResetEmail($user);
			return redirect('login')->with('message_success', 'Reset Email sent to your email successfully.');
		} else
			return redirect('forgot-password')->with('message', 'These credentials do not match our records.');

	}

	function sendResetEmail($user)
	{
		$confirmation_code = str_random(30);
		DB::table('password_resets')->insert(array('email' => $user->email, 'token' => $confirmation_code, 'created_at' => date('Y-m-d h:i:s')));

		$link = url('reset-password/'.$confirmation_code)."  ";
		Condat::sendEmail($user->email, $user->fullname, 'forgot_password', ['{{RESET_URL}}' => $link, '{{ USERNAME }}' => $user->fullname, '{{ NAME }}' => $user->fullname]);
	}


	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		if (is_null($token)) App::abort(404);
		return view('Auth::passwordReset')->with('token', $token);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset()
	{
		$rules = array('email' => 'required', 'new_password' => 'required|min:6', 'new_password_confirmation' => 'required|same:new_password|min:6');
		$user_reset = DB::table('password_resets')->where('token', Input::only('confirmed_code'))->first();

		if (!empty($user_reset)) {
			$user = DB::table('password_resets')->where('email', Input::only('email'))->first();
			$validator = Validator::make(Input::all(), $rules);

			//Is the input valid? new_password confirmed and meets requirements
			if ($validator->fails())
				return Redirect::back()->withErrors($validator)->withInput();


			$newpassword = Hash::make(Input::get('new_password'));
			DB::table('users')->where('email', Input::only('email'))->update(['password' => $newpassword]);
			DB::table('password_resets')->where('email', '=', Input::only('email'))->delete();

			return redirect('login')->with('message_success', 'Password Reset successfully.');

		} else
			return redirect('login')->with('message', 'Invalid link.');
	}
}
