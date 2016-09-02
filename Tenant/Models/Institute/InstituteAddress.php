<?php namespace App\Modules\Tenant\Models\Institute;

use Illuminate\Database\Eloquent\Model;
use DB;

class InstituteAddress extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'institute_addresses';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'institute_address_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['institute_id', 'address_id', 'email'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;

}
