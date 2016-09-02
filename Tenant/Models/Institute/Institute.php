<?php namespace App\Modules\Tenant\Models\Institute;

use App\Modules\Tenant\Models\Company\Company;
use App\Modules\Tenant\Models\Company\CompanyContact;
use App\Modules\Tenant\Models\Email;
use App\Modules\Tenant\Models\Person\PersonEmail;
use App\Modules\Tenant\Models\Person\PersonPhone;
use App\Modules\Tenant\Models\Phone;
use App\Modules\Tenant\Models\User;
use App\Modules\Tenant\Models\Address;
use App\Modules\Tenant\Models\Person\Person;
use App\Modules\Tenant\Models\Person\PersonAddress;
use Illuminate\Database\Eloquent\Model;
use DB;

class Institute extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'institutes';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'institution_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['name', 'added_by', 'short_name', 'company_id'];

    /**
     * Get the company record associated with the institute.
     */
    public function company()
    {
        return $this->belongsTo('App\Modules\Tenant\Models\Company\Company');
    }


    /*
     * Add institute info
     * Output institute id
     */
    function add(array $request)
    {
        DB::beginTransaction();

        try {
            // Saving phone number
            $phone = new Phone();
            $phone_id = $phone->add($request['number']);

            // Saving company
            $company = Company::create([
                'name' => $request['name'],
                'phone_id' => $phone_id,
                'website' => $request['website'],
                'invoice_to_name' => $request['invoice_to_name']
            ]);

            $institute = Institute::create([
                'short_name' => $request['short_name'],
                'company_id' => $company->company_id,
                'added_by' => current_tenant_id()
            ]);

            $this->addAddress($institute->institution_id, $request);

            DB::commit();
            return $institute->institution_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    /*
     * Update institute info
     * Output boolean
     */
    function edit(array $request, $institution_id)
    {
        DB::beginTransaction();

        try {

            $institute = Institute::find($institution_id);
            $institute->short_name = $request['short_name'];
            $institute->save();

            // Saving company
            $company = Company::find($institute->company_id);
            $company->name = $request['name'];
            $company->website = $request['website'];
            $company->invoice_to_name = $request['invoice_to_name'];
            $company->save();

            $phone = Phone::find($company->phone_id);
            $phone->number = $request['number'];
            $phone->save();

            DB::commit();
            return true;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            //return false;
            dd($e);
            // something went wrong
        }
    }

    /*
     * Get institute info
     * Output Response
     */
    function getDetails($institution_id)
    {
        $institute = Institute::leftJoin('companies', 'institutes.company_id', '=', 'companies.company_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'companies.phone_id')
            ->leftJoin('users', 'users.user_id', '=', 'institutes.added_by')
            ->select(['institutes.institution_id', 'institutes.short_name', 'institutes.created_at', 'users.email', 'companies.name', 'companies.website', 'companies.invoice_to_name', 'phones.number', 'institutes.added_by'])
            ->where('institutes.institution_id', $institution_id)
            ->first();
        return $institute;
    }

    /*
     * Add contact person
     * Output id
     */
    function addContact($institution_id, array $request)
    {
        DB::beginTransaction();

        try {
            $institute = Institute::find($institution_id);
            $company_id = $institute->company_id;

            $person_id = $this->addPersonDetails($request);

            CompanyContact::create([
                'company_id' => $company_id,
                'person_id' => $person_id,
                'position' => $request['position']
            ]);
            DB::commit();
            return true;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /*
     * Add address for Institute
     * Output id
     */
    function addAddress($institution_id, array $request)
    {
        $address = Address::create([
            'street' => $request['street'],
            'suburb' => $request['suburb'],
            'state' => $request['state'],
            'postcode' => $request['postcode'],
            'country_id' => $request['country_id'], //263, //Australia
            'type' => 'Institute'
        ]);

        InstituteAddress::create([
            'address_id' => $address->address_id,
            'institute_id' => $institution_id,
            'email' => $request['email']
        ]);

        $phone = new Phone();
        $phone_id = $phone->add($request['number']);

        InstitutePhone::create([
            'address_id' => $address->address_id,
            'phone_id' => $phone_id
        ]);

        return $address->address_id;

    }

    function addPersonDetails($request)
    {
        // Saving contact profile
        $person = Person::create([
            'first_name' => $request['first_name'],
            'middle_name' => $request['middle_name'],
            'last_name' => $request['last_name'],
            'sex' => $request['sex']
        ]);

        $email = Email::create([
            'email' => $request['email']
        ]);

        PersonEmail::create([
            'person_id' => $person->person_id,
            'email_id' => $email->email_id,
            'is_primary' => 1
        ]);

        // Add Phone Number
        $phone = new Phone();
        $phone_id = $phone->add($request['number']);
        PersonPhone::create([
            'phone_id' => $phone_id,
            'person_id' => $person->person_id,
            'is_primary' => 1
        ]);

        return $person->person_id;
    }

    /*
     * Get institutes list
     * Output Response
     */
    function getList()
    {
        $institutes = Institute::leftJoin('companies', 'institutes.company_id', '=', 'companies.company_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'companies.phone_id')
            ->lists('companies.name', 'institutes.institution_id');
        return $institutes;
    }

    /*
     * Get address details
     * Param int $address_id
     * */
    function getAddressDetails($address_id)
    {
        $address = Address::leftJoin('institute_addresses', 'addresses.address_id', '=', 'institute_addresses.address_id')
            ->leftJoin('institute_phones', 'addresses.address_id', '=', 'institute_phones.address_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'institute_phones.phone_id')
            ->select(['addresses.*', 'institute_addresses.email', 'phones.number'])
            ->find($address_id);

        return $address;
    }

    /*
     * Get contact details
     * Param int $contact_id
     * */
    function getContactDetails($contact_id)
    {
        $contact = CompanyContact::leftJoin('persons', 'persons.person_id', '=', 'company_contacts.person_id')
            ->leftJoin('person_emails', 'person_emails.person_id', '=', 'persons.person_id')
            ->leftJoin('emails', 'emails.email_id', '=', 'person_emails.email_id')
            ->leftJoin('person_phones', 'person_phones.person_id', '=', 'persons.person_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'person_phones.phone_id')
            ->select(['company_contacts.*', 'phones.number', 'emails.email', 'persons.first_name', 'persons.last_name'])
            ->find($contact_id);
        return $contact;
    }

    /*
     * Edit address for Institute
     * Output boolean
     */
    function editAddress($address_id, array $request)
    {
        DB::beginTransaction();

        try {
            $address = Address::find($address_id);
            $address->street = $request['street'];
            $address->suburb = $request['suburb'];
            $address->state = $request['state'];
            $address->postcode = $request['postcode'];
            $address->country_id = $request['country_id'];
            $address->save();

            $institute_address = InstituteAddress::where('address_id', $address_id)->first();
            $institute_address->email = $request['email'];
            $institute_address->save();

            $institute_phone = InstitutePhone::where('address_id', $address_id)->first();
            $phone = Phone::find($institute_phone->phone_id);
            $phone->number = $request['number'];
            $phone->save();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }

    }

    /*
     * Edit contact person
     * Output boolean
     */
    function editContact($contact_id, array $request)
    {
        DB::beginTransaction();

        try {
            $contact = CompanyContact::find($contact_id);
            $contact->position = $request['position'];
            $contact->save();

            $person = Person::find($contact->person_id);
            $person->first_name = $request['first_name'];
            $person->middle_name = $request['middle_name'];
            $person->last_name = $request['last_name'];
            $person->sex = $request['sex'];
            $person->save();

            $person_email = PersonEmail::where('person_id', $contact->person_id)->first();
            $email = Email::find($person_email->email_id);

            $email->email = $request['email'];
            $email->save();

            $person_phone = PersonPhone::where('person_id', $person->person_id)->first();
            $phone = Phone::find($person_phone->phone_id);
            $phone->number = $request['number'];
            $phone->save();

            DB::commit();
            return true;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}
