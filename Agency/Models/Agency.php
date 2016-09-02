<?php namespace App\Modules\Agency\Models;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use DB;

class Agency extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['agency_id', 'guid', 'description', 'company_database_name'];


    /* Connecting to the master database */
    protected $connection = 'master';

    /*
     * Add agency info
     * Output agency id
     */
    function add(array $request)
    {
        DB::beginTransaction();

        try {

            /* Agency Address Details */
            $address = Address::create([
                'line1' => $request['line1'],
                'line2' => $request['line2'],
                'suburb' => $request['suburb'],
                'state' => $request['state'],
                'postcode' => $request['postcode'],
                'country_id' => $request['country']
            ]);

            $agency = Agency::create([
                'description' => $request['description'],
                'company_database_name' => $request['company_database_name'],
                //'company_database_name' => 'test',
                'guid' => \Condat::uniqueKey(10, 'agencies', 'guid')
            ]);

            Company::create([
                'name' => $request['name'],
                //'phone_id' => $request['phone_id'],
                'abn' => $request['abn'],
                'acn' => $request['acn'],
                'website' => $request['website'],
                'invoice_to_name' => $request['invoice_to_name'],
                'email_id' => $request['email_id'],
                'agencies_agent_id' => $agency->id,
                'addresses_address_id' => $address->id
            ]);

            //create independent database
            $tenant = app('App\Condat\Libraries\Tenant');
            //$tenant->authenticateTenant();
            $tenant->newTenant($request);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }

        if ($agency) return $agency->id;
        else return false;
    }

    /*
     * Get agency info
     * Output object
     */
    function getAgencyDetails($agency_id)
    {
        $agency = $this->leftJoin('companies', 'agencies.agency_id', '=', 'companies.agencies_agent_id')
            ->leftJoin('addresses', 'addresses.address_id', '=', 'companies.addresses_address_id')
            ->select(['agencies.agency_id', 'agencies.description', 'agencies.company_database_name', 'companies.*', 'addresses.*'])
            ->where('agencies.agency_id', $agency_id)
            ->first();
        return $agency;
    }

    /*
     * Update agency info
     * Output boolean
     */
    function edit(array $request, $agency_id)
    {

        DB::beginTransaction();

        try {

            $agency = Agency::find($agency_id);
            $agency->description = $request['description'];
            // Database name cannot be changed once added $agency->company_database_name = $request['company_database_name'];
            $agency->save();


            $company = Company::where('agencies_agent_id', $agency_id)->first();
            $company->name = $request['name'];
            //$company->phone_id = $request['phone_id'];
            $company->abn = $request['abn'];
            $company->acn = $request['acn'];
            $company->website = $request['website'];
            $company->invoice_to_name = $request['invoice_to_name'];
            $company->email_id = $request['email_id'];
            $company->agencies_agent_id = $agency->id;
            $company->save();

            $address = Address::find($company->addresses_address_id);
            $address->line1 = $request['line1'];
            $address->line2 = $request['line2'];
            $address->suburb = $request['suburb'];
            $address->state = $request['state'];
            $address->postcode = $request['postcode'];
            $address->country_id = $request['country'];

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }

        if ($agency) return $agency->id;
        else return false;
    }

}
