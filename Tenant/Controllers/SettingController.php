<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Setting;
use App\Modules\Tenant\Models\Agent;
use Flash;

use Illuminate\Http\Request;

class SettingController extends BaseController {

	function __construct(Request $request, Agent $agent, Setting $setting)
	{
		$this->request = $request;
		$this->agent = $agent;
		$this->setting = $setting;
		parent::__construct();
	}

	/**
	 * Get Company Profile
	 */
	public function company()
	{
		$data['company'] = $this->agent->getAgentDetails();
		return view('Tenant::Settings/company', $data);
	}

	/**
	 * Get Bank Account Details
	 */
	public function bank()
	{
		$data['bank'] = $this->setting->getBankDetails();
		return view('Tenant::Settings/bank', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
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
	public function edit($id)
	{
		//
	}

	/**
	 * Update the company in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateCompany($agent_id)
	{
		$company_rules = [
			'number' => 'required',
			'email' => 'email|required',
			'name' => 'required',
		];

		$this->validate($this->request, $company_rules);
		// if validates
		$updated = $this->agent->edit($this->request->all(), $agent_id);
		if ($updated)
			Flash::success('Company details has been updated successfully!');
		return redirect()->route('tenant.company.edit');
	}

	/**
	 * Update the bank details in storage.
	 *
	 * @return Response
	 */
	public function updateBank()
	{
		$bank_rules = [
			'number' => 'required',
			'account_name' => 'required',
			'name' => 'required',
		];

		$this->validate($this->request, $bank_rules);
		// if validates
		$all = $this->request->except('_token');
		$this->setting->saveSetup('bank', @serialize($all));
		Flash::success('Bank details has been updated successfully!');
		return redirect()->route('tenant.bank.edit');
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

}
