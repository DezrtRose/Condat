<?php
namespace App\Modules\Agency\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


Class AgencySubscription extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agency_subscriptions';
    protected $primaryKey = "agency_subscription_id";

    protected $fillable = ['agency_id', 'is_current', 'start_date', 'end_date', 'subscription_status_id', 'subscription_id'];

    public static function view($id = null)
    {
        $results = DB::select('select * from agency where id = ?', array($id));
        return $results;

    }

    public static function index()
    {
        $clients = DB::table('agencies')
            ->select('agencies.*', 'persons.*', 'person_phones.*', 'person_emails.*', 'phones.*', 'companies.*')
            ->leftJoin('companies', 'agencies.company_id', '=', 'companies.company_id')
            ->leftJoin('person_phones', 'persons.person_id', '=', 'person_phones.person_id')
            ->leftJoin('person_emails', 'persons.person_id', '=', 'person_emails.person_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'person_phones.phone_id')
            ->leftJoin('emails', 'emails.email_id', '=', 'person_emails.email_id')
            ->orderBy('agencies.agency_id', 'desc')
            ->simplePaginate(15);
        return $clients;

    }


}