<?php namespace App\Modules\Agency\Models;

use App\Models\Address;
use App\Modules\System\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use DB;
use Mail;

class Agency extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agencies';
    protected $primaryKey = 'agency_id';

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
        $subscription = new Subscription();
        DB::beginTransaction();

        try {

            /* Agency Address Details */
            $address = Address::create([
                'line1' => isset($request['line1']) ? $request['line1'] : '',
                'line2' => isset($request['line2']) ? $request['line2'] : '',
                'suburb' => isset($request['suburb']) ? $request['suburb'] : '',
                'state' => isset($request['state']) ? $request['state'] : '',
                'postcode' => isset($request['postcode']) ? $request['postcode'] : '',
                'country_id' => isset($request['country']) ? $request['country'] : ''
            ]);

            $agency = Agency::create([
                'description' => isset($request['description']) ? $request['description'] : '',
                'company_database_name' => $request['company_database_name'],
                //'company_database_name' => 'test',
                'guid' => \Condat::uniqueKey(10, 'agencies', 'guid')
            ]);

            $subscription->activateTrail($request, $agency->agency_id);

            Company::create([
                'name' => $request['name'],
                'phone_id' => $request['phone'],
                'abn' => $request['abn'],
                'acn' => isset($request['acn']) ? $request['acn'] : '',
                'website' => isset($request['website']) ? $request['website'] : '',
                'invoice_to_name' => isset($request['invoice_to_name']) ? $request['invoice_to_name'] : '',
                'email_id' => $request['email_id'],
                'agencies_agent_id' => $agency->agency_id,
                'addresses_address_id' => $address->address_id
            ]);

            //create independent database
            $tenant = app('App\Condat\Libraries\Tenant');
            $unique_auth_code = $request['unique_auth_code'] = md5(uniqid($agency->agency_id, true));
            //$tenant->authenticateTenant();
            $tenant->newTenant($request);

            // sending email to agency
            $agency_message = <<<EOD
<strong>Respected {$request['name']}, </srtong>
<p>Your agency account has been created successfully on Condat Solutions. Please <a href="">click here</a> or follow the link below to complete the registration process.</p>
<a href="">$unique_auth_code</a>
EOD;

            $param = ['content'    => $agency_message,
                'subject'    => 'Agency Created Successfully',
                'heading'    => 'Condat Solutions',
                'subheading' => 'All your business in one space',
            ];
            $data = ['to_email'   => $request['email_id'],
                'to_name'    => $request['name'],
                'subject'    => 'Agency Created Successfully',
                'from_email' => 'krita@condat.com', //change this later
                'from_name'  => 'Condat Solutions', //change this later
            ];

            Mail::send('template.master', $param, function ($message) use ($data) {
                $message->to($data['to_email'], $data['to_name'])
                    ->subject($data['subject'])
                    ->from($data['from_email'], $data['from_name']);
            });

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
            $company->phone_id = $request['phone'];
            $company->abn = $request['abn'];
            $company->acn = $request['acn'];
            $company->website = $request['website'];
            $company->invoice_to_name = $request['invoice_to_name'];
            $company->email_id = $request['email_id'];
            $company->agencies_agent_id = $agency->agency_id;
            $company->save();

            $address = Address::find($company->addresses_address_id);
            $address->line1 = $request['line1'];
            $address->line2 = $request['line2'];
            $address->suburb = $request['suburb'];
            $address->state = $request['state'];
            $address->postcode = $request['postcode'];
            $address->country_id = $request['country'];
            $address->save();

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
