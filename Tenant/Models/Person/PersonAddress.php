<?php namespace App\Modules\Tenant\Models\Person;

use App\Modules\Tenant\Models\Address;
use Illuminate\Database\Eloquent\Model;
use DB;

class PersonAddress extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'person_addresses';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'person_address_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['address_id', 'person_id', 'is_current'];


    /**
     * Disable the default time stamp feature
     *
     * @var boolean
     */
    public $timestamps = false;

}
