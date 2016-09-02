<?php namespace App\Modules\System\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionStatus extends Model {

    protected $table = "subscription_statuses";
    protected $primaryKey = "status_id";

    protected $fillable = array('name');

    public $timestamps = false;

}
