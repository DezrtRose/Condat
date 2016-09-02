<?php namespace App\Modules\Tenant\Models\Course;

use Illuminate\Database\Eloquent\Model;
use DB;

class CourseFee extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'course_fees';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'course_fee_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description', 'fees_id', 'course_id'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;
}
