<?php namespace App\Modules\Tenant\Models\Intake;

use Illuminate\Database\Eloquent\Model;
use DB;

class InstituteIntake extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'institute_intakes';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'institute_intake_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['intake_id', 'institute_id'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;
}
