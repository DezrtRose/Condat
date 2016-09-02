<?php namespace App\Modules\Tenant\Models\Client;

use Illuminate\Database\Eloquent\Model;
use DB;


class ActiveClient extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'active_clients';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'client_id', 'created'];

    public $timestamps = false;

}

