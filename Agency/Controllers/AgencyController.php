<?php namespace App\Modules\Agency\Controllers;

use App\Http\Requests;
use App\Http\Controllers\BaseController;
use App\Modules\Agency\Models\Agency;
use App\Modules\System\Models\Subscription;
use DB;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Response;

class AgencyController extends BaseController {

	protected $agency;
	protected $request;
	protected $subscription;
	/* Validation rules for agency create and edit */
	protected $rules = [
		'description' => 'min:2',
		'name' => 'required|min:2|max:145',
		'abn' => 'required|min:2|max:145',
		'phone_id' => 'required|min:2|max:145',
        'g-recaptcha-response' => 'required|recaptcha',
	];

	function __construct(Agency $agency, Subscription $subscription, Request $request)
	{
		$this->agency = $agency;
		$this->request = $request;
		$this->subscription = $subscription;
		parent::__construct();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view("Agency::index");
	}

	/**
	 * Get all the agencies through ajax request.
	 *
	 * @return JSON response
	 */
	function getData(Request $request)
	{
		$agencies = Agency::leftJoin('companies','agencies.agency_id','=','companies.agencies_agent_id')
			->select(['agency_id', 'agencies.created_at', 'company_database_name', 'companies.name', 'companies.email_id'])
            ->orderBy('agency_id', 'desc');

		$datatable = \Datatables::of($agencies)
			->editColumn('created_at', function($data){return format_datetime($data->created_at); })
			->addColumn('action', '<a data-toggle="tooltip" title="View Agency" class="btn btn-action-box" href ="{{ route( \'agency.show\', $agency_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Renew Agency Subscription" class="btn btn-action-box" href ="{{ route( \'agency.renew\', $agency_id) }}"><i class="fa fa-refresh"></i></a> <a data-toggle="tooltip" title="Edit Agency" class="btn btn-action-box" href ="{{ route( \'agency.edit\', $agency_id) }}"><i class="fa fa-edit"></i></a> <a data-toggle="tooltip" title="Delete Agency" class="delete-agency btn btn-action-box" href="{{ route( \'agency.destroy\', $agency_id) }}"><i class="fa fa-trash"></i></a>');
		return $datatable->make(true);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('Agency::add');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		/* Additional validations for creating user */
		$this->rules['email_id'] = 'required|email|min:5|max:145|unique:companies,email_id';

		$this->validate($this->request, $this->rules);
		// if validates
		$request = $this->request->all();
		$request['company_database_name'] = $this->createDomain($request['name']);
		$created = $this->agency->add($request);
		if($created)
			Flash::success('Agency has been created successfully.');
		return redirect()->route('agency.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$data['agency'] = $this->agency->getAgencyDetails($id);
		return view('Agency::show', $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$data['agency'] = $this->agency->getAgencyDetails($id);
		$data['subscriptions'] = Subscription::lists('name', 'subscription_id');
		return view('Agency::edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        /* Additional validations for creating user */
        $this->rules['email_id'] = 'required|email|min:5|max:145|unique:companies,email_id,' . $id . ',agencies_agent_id';

        $this->validate($this->request, $this->rules);
        // if validates
        $request = $this->request->all();
        $updated = $this->agency->edit($request, $id);
        if($updated)
            Flash::success('Agency has been updated successfully.');
        return redirect()->route('agency.index');
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

	/**
	 * get Subdomain suggestion
	 * @param string $company_name
	 * @return mixed
	 */
	public function getDomainSuggestion($company_name = '')
	{
		$domain = $this->createDomain($company_name);
		return Response::json($domain);
	}

	/**
	 * Create APP
	 * @param $string
	 * @return mixed|string
	 */
	function createDomain($string)
	{
		$string = explode(' ', $string);
		$string = strtolower($string[0]);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $string);
		$domain = preg_replace("/[\/_|+ -]+/", '', $clean);

		$domain = $this->checkDomainExists($domain);

		return $domain;
	}

	/**
	 * Check subdomain exist for not
	 * @param string $domain
	 * @return string
	 */
	private function checkDomainExists($domain = '')
	{
		$i = 1;
		$exists = Agency::where('company_database_name', $domain)->first();
		$new_domain = $domain;
		while ($exists) {
			$new_domain = $domain . $i;
			$exists = Agency::where('company_database_name', $new_domain)->first();
			$i++;
		}
		return $new_domain;
	}

	/**
	 * Renew agency subscription
	 *
	 * @param  int  $agency_id
	 * @return Response
	 */
	public function subscriptionRenew()
	{
		return view('Agency::renew');
	}

	/**
	 * Update agency subscription
	 *
	 * @param  int  $agency_id
	 * @return Response
	 */
	public function postSubscriptionRenew($agency_id)
	{
		$rules['payment_date'] = 'required';

		$this->validate($this->request, $rules);

		// if validates
		$updated = $this->subscription->renew($this->request->all(), $agency_id);
		if($updated)
			Flash::success('Subscription has been renewed successfully.');
		return redirect()->route('agency.index');
	}

	public function get_subscription_amount(Request $request)
    {
        $resp = false;
        $post = $request->all();
        if(isset($post['subscription_type']) && isset($post['subscription_years'])) {
            $subscription = new Subscription();
            $data = $subscription->find($post['subscription_type']);
            if($data) {
                $resp = ($data->amount * $post['subscription_years']) - (($post['subscription_years'] - 1) / 100) * (($data->amount * $post['subscription_years']) * 5);
            }
        }
        echo $resp;
    }

}
