<?php namespace App\Modules\Dashboard\Controllers;

use App\Http\Requests;
use App\Http\Controllers\BaseController;

use App\Modules\Agency\Models\Agency;
use Illuminate\Http\Request;
use DB;

class DashboardController extends BaseController {

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view("Dashboard::index");
	}

	/**
	 * Get new agencies registered within a month through ajax request.
	 *
	 * @return JSON response
	 */
	function getNewAgencyData(Request $request)
	{
		$agencies = Agency::leftJoin('companies','agencies.agency_id','=','companies.agencies_agent_id')
			->select(['agency_id', 'agencies.created_at', 'company_database_name', 'companies.name', 'companies.email_id'])
			->where(DB::raw('MONTH(agencies.created_at)'), '=', date('n'));

		$datatable = \Datatables::of($agencies)
			->editColumn('created_at', function($data){return format_datetime($data->created_at); })
			->addColumn('action', '<a data-toggle="tooltip" title="View Agency" class="btn btn-action-box" href ="{{ route( \'agency.show\', $agency_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Renew Agency Subscription" class="btn btn-action-box" href ="{{ route( \'agency.renew\', $agency_id) }}"><i class="fa fa-refresh"></i></a> <a data-toggle="tooltip" title="Edit Agency" class="btn btn-action-box" href ="{{ route( \'agency.edit\', $agency_id) }}"><i class="fa fa-edit"></i></a> <a data-toggle="tooltip" title="Delete Agency" class="delete-agency btn btn-action-box" href="{{ route( \'agency.destroy\', $agency_id) }}"><i class="fa fa-trash"></i></a>');
		return $datatable->make(true);
	}

	/**
	 * Get expiring agencies through ajax request.
	 *
	 * @return JSON response
	 */
	function getExpiringAgencyData(Request $request)
	{
		$agencies = Agency::leftJoin('companies','agencies.agency_id','=','companies.agencies_agent_id')
			->select(['agency_id', 'agencies.created_at', 'company_database_name', 'companies.name', 'companies.email_id'])
			->where(DB::raw('MONTH(agencies.created_at)'), '!=', date('n')); //remove this later and add expiring condition

		$datatable = \Datatables::of($agencies)
			->editColumn('created_at', function($data){return format_datetime($data->created_at); })
			->addColumn('action', '<a data-toggle="tooltip" title="View Agency" class="btn btn-action-box" href ="{{ route( \'agency.show\', $agency_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Edit Agency" class="btn btn-action-box" href ="{{ route( \'agency.edit\', $agency_id) }}"><i class="fa fa-edit"></i></a> <a data-toggle="tooltip" title="Delete Agency" class="delete-agency btn btn-action-box" href="{{ route( \'agency.destroy\', $agency_id) }}"><i class="fa fa-trash"></i></a>');
		return $datatable->make(true);
	}
}
