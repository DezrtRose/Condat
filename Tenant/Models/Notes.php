<?php namespace App\Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;

//use DB;


class Notes extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notes';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'notes_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['added_by_user_id', 'description', 'remind', 'reminder_date'];

    public $timestamps = false;
}
