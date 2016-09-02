<?php namespace App\Modules\Tenant\Models\Company;

use Illuminate\Database\Eloquent\Model;
use DB;

class CompanyContact extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'company_contacts';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'company_contact_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'person_id', 'department', 'position'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Get the person associated with the company.
     */
    public function document()
    {
        return $this->belongsTo('App\Modules\Tenant\Models\Person\Person');
    }
}
