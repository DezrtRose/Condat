<?php namespace App\Modules\Tenant\Models\College;

use Illuminate\Database\Eloquent\Model;
use DB;

class TuitionCommission extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ci_tuition_commissions';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'tuition_commission_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tuition_fee', 'enrollment_fee', 'material_fee', 'coe_fee', 'other_fee', 'sub_total', 'description', 'commission_percent', 'commission_amount', 'commission_gst', 'college_invoice_id'];

    public $timestamps = false;
}
