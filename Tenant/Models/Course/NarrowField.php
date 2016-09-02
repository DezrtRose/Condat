<?php namespace App\Modules\Tenant\Models\Course;

use Illuminate\Database\Eloquent\Model;
use DB;

class NarrowField extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'narrow_field';

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
    protected $fillable = ['name', 'description', 'broad_field_id'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;
}
