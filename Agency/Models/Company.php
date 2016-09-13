<?php namespace App\Modules\Agency\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Company extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'companies';
    protected $primaryKey = 'company_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'name', 'phone_id', 'abn', 'acn', 'website', 'invoice_to_name', 'email_id', 'agencies_agent_id', 'addresses_address_id'];

}
