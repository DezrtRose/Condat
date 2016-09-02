<?php
namespace App\Modules\Tenant\Models;

use App\Modules\Tenant\Models\Institute\SuperAgentInstitute;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Tenant\Models\Company\Company;

Class Agent extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agents';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'agent_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['agent_id', 'description', 'company_id', 'added_by', 'email', 'address_id'];


    /*
     * Add agent info
     * Output agent id
     */
    function add(array $request)
    {
        DB::beginTransaction();

        try {
            // Saving phone number
            $phone = new Phone();
            $phone_id = $phone->add($request['number']);

            $address = Address::create([
                'street' => $request['street'],
                'suburb' => $request['suburb'],
                'postcode' => $request['postcode'],
                'state' => $request['state'],
                'country_id' => $request['country_id'],
            ]);

            // Saving company
            $company = Company::create([
                'name' => $request['name'],
                'phone_id' => $phone_id,
                'website' => $request['website'],
                'invoice_to_name' => $request['invoice_to_name']
            ]);


            $agent = Agent::create([
                'description' => $request['description'],
                'email' => $request['email'],
                'added_by' => current_tenant_id(),
                'company_id' => $company->company_id,
                'address_id' => $address->address_id
            ]);


            // Add address
            /*$address = Address::create([
                'street' => $request['street'],
                'suburb' => $request['suburb'],
                'postcode' => $request['postcode'],
                'state' => $request['state'],
                'country_id' => $request['country_id'],
            ]);

            PersonAddress::create([
                'address_id' => $address->address_id,
                'person_id' => $person->person_id,
                'is_current' => 1
            ]);*/

            DB::commit();
            return $agent->agent_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    /*
     * Edit agent info
     * Output agent id
     */
    function edit(array $request, $agent_id)
    {
        DB::beginTransaction();

        try {

            $agent = Agent::find($agent_id);

            $address = Address::firstOrNew(['address_id' => $agent->address_id]);
            $address->street = $request['street'];
            $address->suburb = $request['suburb'];
            $address->postcode = $request['postcode'];
            $address->state = $request['state'];
            $address->country_id = $request['country_id'];
            $address->save();

            $company = Company::find($agent->company_id);
            $company->name = $request['name'];
            $company->website = $request['website'];
            $company->invoice_to_name = $request['invoice_to_name'];
            $company->save();

            $phone = Phone::find($company->phone_id);
            $phone->number = $request['number'];
            $phone->save();

            $agent->description = $request['description'];
            $agent->email = $request['email'];
            if ($agent->address_id == null) $agent->address_id = $address->address_id;
            $agent->save();

            DB::commit();
            return $agent->agent_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    function getRemaining($institute_id)
    {
        $agents = $this->getAll();

        foreach ($agents as $key => $agent) {
            $existing = SuperAgentInstitute::where('institute_id', $institute_id)->where('agents_id', $key)->first();
            if ($existing)
                unset($agents[$key]);
        }
        return $agents;
    }

    function getAll()
    {
        $agents = Agent::leftJoin('companies', 'companies.company_id', '=', 'agents.company_id')
            ->orderBy('agents.agent_id', 'desc')
            ->lists('companies.name', 'agents.agent_id');
        return $agents;
    }

    function getName($agent_id)
    {
        $agent = Agent::leftJoin('companies', 'companies.company_id', '=', 'agents.company_id')
            ->select(['companies.name'])
            ->where('agents.agent_id', $agent_id)
            ->first();

        if (!empty($agent))
            return $agent->name;
        else
            return 'Undefined';
    }

    function getAgents()
    {
        $arr[0] = 'No Agents';
        $agents = Agent::join('companies', 'companies.company_id', '=', 'agents.company_id')
            ->select(['companies.name', 'agents.agent_id'])
            ->lists('companies.name', 'agents.agent_id')
            ->toArray();
        $agents = $arr + $agents;
        //array_unshift($agents, "No Agent"); This re-indexes numeric keys
        return $agents;
    }

    function getDetails($agent_id)
    {
        $agent = Agent::leftJoin('companies', 'companies.company_id', '=', 'agents.company_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'companies.phone_id')
            ->leftJoin('addresses', 'addresses.address_id', '=', 'agents.address_id')
            ->select(['companies.name', 'companies.website', 'companies.invoice_to_name', 'agents.*', 'addresses.*', 'phones.number'])
            ->find($agent_id);
        return $agent;
    }

    function getAgentDetails()
    {
        $agent = Agent::leftJoin('companies', 'companies.company_id', '=', 'agents.company_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'companies.phone_id')
            ->leftJoin('addresses', 'addresses.address_id', '=', 'agents.address_id')
            ->select(['companies.name', 'companies.website', 'companies.invoice_to_name', 'agents.*', 'addresses.*', 'phones.number'])
            ->orderBy('companies.company_id', 'desc')
            ->first(); //get agent details
        return $agent;
    }
}