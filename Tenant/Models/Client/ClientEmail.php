<?php namespace App\Modules\Tenant\Models\Client;

use Illuminate\Database\Eloquent\Model;
use DB;


class ClientEmail extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'client_emails';

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
    protected $fillable = ['email', 'subject', 'body', 'status', 'user_id', 'client_id', 'created_at'];

    public $timestamps = false;

    function storeMail($client_id, array $request, $status = 1)
    {
        ClientEmail::create([
            'email' => $request['email'],
            'subject' => $request['subject'],
            'body' => $request['body'],
            'status' => $status,
            'user_id' => current_tenant_id(),
            'client_id' => $client_id,
            'created_at' => get_today_datetime()
        ]);
    }

    function getEmails($client_id, $status = 1)
    {
        $emails = ClientEmail::where('client_id', $client_id)->where('status', $status)->get();
        return $emails;
    }

}

