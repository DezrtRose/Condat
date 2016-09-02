<?php namespace App\Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Email extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'emails';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'email_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email'];


}
