<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Agent;
use App\Modules\Tenant\Models\Institute\SuperAgentInstitute;
use Flash;
use DB;

use Illuminate\Http\Request;

class AgentController extends BaseController
{

    protected $request;

    protected $rules = [
        'number' => 'required',
        'email' => 'email|required',
        'name' => 'required',
    ];

    function __construct(Request $request, Agent $agent, SuperAgentInstitute $superagent)
    {
        $this->request = $request;
        $this->superagent = $superagent;
        $this->agent = $agent;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("Tenant::Agent/index");
    }

    /**
     * Get all the users through ajax request.
     *
     * @return JSON response
     */
    function getData()
    {
        $agents = Agent::join('companies', 'companies.company_id', '=', 'agents.company_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'companies.phone_id')
            //->leftJoin('superagent_institutes', 'agents.agent_id', '=', 'superagent_institutes.agents_id')
            ->leftJoin('users', 'users.user_id', '=', 'agents.added_by')
            ->select(['companies.name', 'companies.website', 'agents.description', 'agents.agent_id', 'agents.email', 'agents.added_by', 'agents.created_at', 'phones.number', 'users.email as user_email']);

        $datatable = \Datatables::of($agents)
            ->addColumn('action', '<a data-toggle="tooltip" title="View Agent" class="btn btn-action-box" href ="{{ route( \'tenant.agents.show\', $agent_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Edit Agent" class="btn btn-action-box" href ="{{ route( \'tenant.agents.edit\', $agent_id) }}"><i class="fa fa-edit"></i></a> <a data-toggle="tooltip" title="Delete Agent" class="delete-user btn btn-action-box" href="{{ route( \'tenant.agents.destroy\', $agent_id) }}"><i class="fa fa-trash"></i></a>')
            ->editColumn('created_at', function ($data) {
                return format_datetime($data->created_at);
            })
            ->editColumn('agent_id', function ($data) {
                return format_id($data->agent_id, 'Ag');
            });
        return $datatable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('Tenant::Agent/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        /* Additional validations for creating institution */
        $this->rules['name'] = 'required|min:2|max:255|unique:companies';
        $this->rules['email'] = 'email|required|min:2|max:155';

        if ($this->request->ajax()) {
            $validator = \Validator::make($this->request->all(), $this->rules);
            if ($validator->fails())
                return $this->fail(['errors' => $validator->getMessageBag()->toArray()]);
            // if validates
            $agent_id = $this->agent->add($this->request->all());
            return $this->success(['$gent_id' => $agent_id, 'name' => $this->request->get('name')]);
        } else {
            $this->validate($this->request, $this->rules);
            // if validates
            $agent_id = $this->agent->add($this->request->all());
            if ($agent_id)
                Flash::success('Agent has been created successfully.');
            return redirect()->route('tenant.agents.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $agent_id
     * @return Response
     */
    public function show($agent_id)
    {
        $data['agent'] = $this->agent->getDetails($agent_id);
        return view("Tenant::Agent/show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($agent_id)
    {
        /* Getting the agent details*/
        $data['agent'] = $this->agent->getDetails($agent_id);
        return view('Tenant::Agent/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $agent_id
     * @return Response
     */
    public function update($agent_id)
    {
        $user_id = $this->request->get('user_id');
        /* Additional validation rules checking for uniqueness */
        $this->rules['email'] = 'required|email|min:5|max:55|unique:users,email,' . $user_id . ',user_id';

        $this->validate($this->request, $this->rules);
        // if validates
        $updated = $this->agent->edit($this->request->all(), $agent_id);
        if ($updated)
            Flash::success('Agent has been updated successfully.');
        return redirect()->route('tenant.agents.index');
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
     * Add super agents to institute.
     *
     * @param  int $agent_id
     * @return Response
     */
    function storeSuperAgent($institution_id)
    {
        $agent_id = $this->superagent->add($institution_id, $this->request->all());
        if ($agent_id) {
            \Flash::success('Super agent added successfully!');
            return redirect()->route('tenant.institute.show', $institution_id);
        }
    }


    /**
     * Remove super agents from institute.
     *
     * @param  int $institute_id
     * @return Response
     */
    function removeSuperAgent($institute_id, $agent_id)
    {
        $agent = SuperAgentInstitute::where('institute_id', $institute_id)->where('agents_id', $agent_id)->first();
        if ($agent) {
            $agent->delete();
            \Flash::success('Super agent added successfully!');
            return redirect()->route('tenant.institute.show', $institute_id);
        }
    }

    /**
     * Get agents based on institute selected
     *
     * @return JSON Array
     */
    public function getAgents()
    {
        if ($this->request->ajax()) {
            $agents = $this->agent->getAgents();
            $options = '';
            foreach ($agents as $key => $agent) {
                $options .= "<option value =" . $key . ">" . $agent . "</option>";
            }
            return $this->success(['options' => $options]);
        } else {
            return $this->fail(['error' => 'The method is not authorized.']);
        }
    }
}
