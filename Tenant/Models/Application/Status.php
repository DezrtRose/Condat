<?php namespace App\Modules\Tenant\Models\Application;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'status';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'status_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;

}