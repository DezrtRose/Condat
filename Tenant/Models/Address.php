<?php

namespace App\Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;

Class Address extends Model{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'addresses';
	protected $primaryKey = 'address_id';
	protected $fillable = ['street', 'suburb', 'state', 'postcode','country_id', 'google_map','type'];
	public $timestamps = false;

	public function getDetails($address_id)
	{

	}
}