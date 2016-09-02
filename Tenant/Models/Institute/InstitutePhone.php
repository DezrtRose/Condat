<?php namespace App\Modules\Tenant\Models\Institute;

use Illuminate\Database\Eloquent\Model;
use DB;

class InstitutePhone extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'institute_phones';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'institute_phone_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['address_id', 'phone_id'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;

}
