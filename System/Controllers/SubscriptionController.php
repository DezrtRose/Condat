<?php namespace App\Modules\System\Controllers;

use App\Http\Requests;
use App\Http\Controllers\BaseController;

use App\Modules\System\Models\Subscription;
use Illuminate\Http\Request;
use Flash;

class SubscriptionController extends BaseController {

	protected $subscription;
	function __construct(Subscription $subscription)
	{
		parent::__construct();
		$this->subscription = $subscription;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$subscriptions = $this->subscription->getAll();
		return view("System::subscription", $subscriptions);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		$name = $request->input('name');
		$rules[$name.'_amount'] = 'numeric|min:1|required';
		$this->validate($request, $rules);

		$subscription = Subscription::firstOrNew(['name'=>$name]);
		$subscription->amount = $request->input($name.'_amount');
		$subscription->save();
		Flash::success('Subscription fee has been updated successfully.');
		return redirect()->to('settings/subscription');
	}

}
