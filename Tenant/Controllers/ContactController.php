<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Company\CompanyContact;
use App\Modules\Tenant\Models\Institute\Institute;
use Flash;
use DB;

use Illuminate\Http\Request;

class ContactController extends BaseController
{

    protected $request;

    function __construct(Request $request, Institute $institute)
    {
        $this->request = $request;
        $this->institute = $institute;
        parent::__construct();
    }

    /**
     * Get all the contacts through ajax request.
     *
     * @return JSON response
     */
    function getData($institute_id)
    {
        $institutes = Institute::join('company_contacts', 'institutes.company_id', '=', 'company_contacts.company_id')
            ->leftJoin('persons', 'persons.person_id', '=', 'company_contacts.person_id')
            ->leftJoin('users', 'users.person_id', '=', 'persons.person_id')
            ->leftJoin('person_phones', 'person_phones.person_id', '=', 'persons.person_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'person_phones.phone_id')
            ->select(['company_contacts.company_contact_id', 'company_contacts.position', 'phones.number', 'users.email', DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS name')])
            ->where('institutes.institution_id', $institute_id);

        $datatable = \Datatables::of($institutes)
            ->addColumn('action', function ($data) {
                return '<div class="btn-group">
                  <button type="button" class="btn btn-primary">Action</button>
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                  <li><a data-toggle="modal" data-target="#condat-modal" data-url="' . route('tenant.contact.edit', $data->company_contact_id) . '">Edit</a></li>
                    <li><a href="{{ route( \'tenant.contact.destroy\', $company_contact_id) }}">Delete</a></li>
                  </ul>
                </div>';
            });
        return $datatable->make(true);
    }

    /*
     * Edit contact
     */
    function edit($contact_id)
    {
        // check if from institute...
        if($this->request->ajax())
        {
            $data['contact'] = $this->institute->getContactDetails($contact_id);
            return view("Tenant::Contact/edit", $data);
        }
    }

    function update($contact_id)
    {
        $data['contact'] = $this->institute->editContact($contact_id, $this->request->all());
        \Flash::success('Contact Updated Successfully!');
        return redirect()->back();
    }
}
