<?php namespace App\Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;


class Photo extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'photos';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'photo_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['filename', 'title', 'shelf_location', 'user_id'];

    public $timestamps = false;
}
