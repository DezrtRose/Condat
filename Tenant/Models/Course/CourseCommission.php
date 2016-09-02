<?php namespace App\Modules\Tenant\Models\Course;

use Illuminate\Database\Eloquent\Model;
use DB;

class CourseCommission extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'course_commissions';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'course_commission_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description', 'commissions_id', 'course_id'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean 'https://www.youtube.com/watch?v=HANW9JiYmew
     */
    public $timestamps = false;
}
