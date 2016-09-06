<?php
namespace App\Modules\Tenant\Models\Person;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

Class Person extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'persons';
    protected $primaryKey = 'person_id';
    protected $fillable = ['first_name', 'middle_name', 'last_name', 'dob', 'sex', 'photo_id', 'passport_no'];


    public function email()
    {
        return $this->hasMany('Email')->orderBy('id', 'desc');
    }

    public function phone()
    {
        return $this->hasMany('Phone')->orderBy('id', 'desc');
    }

}