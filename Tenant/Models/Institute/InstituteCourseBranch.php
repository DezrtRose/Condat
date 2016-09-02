<?php namespace App\Modules\Tenant\Models\Institute;

use Illuminate\Database\Eloquent\Model;
use DB;

class InstituteCourseBranch extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'institute_course_branch';

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
    protected $fillable = ['institute_course_id', 'company_branch_id', 'description'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;

}
