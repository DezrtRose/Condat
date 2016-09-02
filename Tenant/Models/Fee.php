<?php
namespace App\Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;

Class Fee extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fees';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'fee_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['total_tuition_fee', 'enrollment_fee', 'material_fee', 'coe_fee', 'other_fee', 'coe_initial_deposit', 'description'];

    /**
     * Disable default timestamp
     *
     * @var boolean
     */
    public $timestamps = false;

}