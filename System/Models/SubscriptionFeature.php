<?php namespace App\Modules\System\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionFeature extends Model {

    protected $table = "subscription_features";
    protected $primaryKey = "subscription_feature_id";

    protected $fillable = array('description', 'custom_subscriptions_id', 'feature_id', 'standard_subscriptions_id');

    public $timestamps = false;

}
