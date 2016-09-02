<?php namespace App\Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;

Class Country extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'country_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'code'];

    /**
     * Disable default timestamp
     *
     * @var boolean
     */
    public $timestamps = false;

}