<?php
namespace App\Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;

Class Commission extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'commissions';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'commission_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['commission_percent', 'description'];

}