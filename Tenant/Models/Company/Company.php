<?php namespace App\Modules\Tenant\Models\Company;

use Illuminate\Database\Eloquent\Model;
use DB;

class Company extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'company_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'phone_id', 'abn', 'acn', 'website', 'invoice_to_name'];

}
