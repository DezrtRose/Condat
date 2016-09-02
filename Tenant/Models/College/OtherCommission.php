<?php namespace App\Modules\Tenant\Models\College;

use Illuminate\Database\Eloquent\Model;
use DB;

class OtherCommission extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ci_other_commissions';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'other_commission_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['amount', 'gst', 'description', 'college_invoice_id'];

    public $timestamps = false;
}
