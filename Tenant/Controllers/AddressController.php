<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Address;
use App\Modules\Tenant\Models\Institute\Institute;
use Flash;
use DB;

use Illuminate\Http\Request;

class AddressController extends BaseController
{

    protected $request;

    function __construct(Request $request, Address $address, Institute $institute)
    {
        $this->request = $request;
        $this->address = $address;
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
        $institutes = Institute::join('institute_addresses', 'institutes.institution_id', '=', 'institute_addresses.institute_id')
            ->leftJoin('addresses', 'addresses.address_id', '=', 'institute_addresses.address_id')
            ->leftJoin('institute_phones', 'addresses.address_id', '=', 'institute_phones.address_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'institute_phones.phone_id')
            ->select(['institute_addresses.institute_address_id as institue_address_id', 'addresses.address_id', 'addresses.state', 'institute_addresses.email', 'phones.number', DB::raw('CONCAT(addresses.street, ", ", addresses.suburb) AS address')])
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
                        <li><a data-toggle="modal" data-target="#condat-modal" data-url="' . route('tenant.address.edit', $data->address_id) . '">Edit</a></li>
                        <li><a href="{{ route( \'tenant.address.destroy\', $address_id) }}">Delete</a></li>
                    </ul>
                </div>
                </div>';
            });
        return $datatable->make(true);
    }

    /**
     * Edit address
     */
    function edit($address_id)
    {
        // check if from institute...
        if($this->request->ajax())
        {
            $data['address'] = $this->institute->getAddressDetails($address_id); //dd($data['address']);
            return view("Tenant::Address/edit", $data);
        }
    }

    function update($address_id)
    {
        $data['address'] = $this->institute->editAddress($address_id, $this->request->all());
        \Flash::success('Address Updated Successfully!');
        return redirect()->back();
    }
}
