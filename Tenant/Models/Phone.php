<?php
namespace App\Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;

Class Phone extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'phones';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'phone_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['number', 'type', 'area_code', 'country_code'];

    /*
     * Add phone number
     * Output phone id
     * return int
     */
    public function add($number, $type = 1, $area_code='')
    {
        $phone = Phone::create([
            'number' => $number,
            'type' => $type,
            'area_code' => $area_code
        ]);

        return $phone->phone_id;
    }

}