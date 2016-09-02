<?php namespace App\Modules\Tenant\Models\Timeline;

use Illuminate\Database\Eloquent\Model;
use DB;

class TimelineType extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'timeline_types';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'type_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description', 'image', 'header', 'body'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;

}
