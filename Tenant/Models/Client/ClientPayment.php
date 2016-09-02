<?php namespace App\Modules\Tenant\Models\Client;

use Illuminate\Database\Eloquent\Model;
use DB;

class ClientPayment extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'client_payments';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'client_payment_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['client_id', 'amount', 'date_paid', 'payment_method', 'description', 'payment_type'];

    function add(array $request, $client_id)
    {
        DB::beginTransaction();

        try {
            $payment = ClientPayment::create([
                'client_id' => $client_id,
                'amount' => $request['amount'],
                'date_paid' => insert_dateformat($request['date_paid']),
                'payment_method' => $request['payment_method'],
                'payment_type' => $request['payment_type'],
                'description' => $request['description']
            ]);

            DB::commit();
            return $payment->client_payment_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    function edit($request, $payment_id)
    {
        $payment = ClientPayment::find($payment_id);
        $payment->amount = $request['amount'];
        $payment->date_paid = insert_dateformat($request['date_paid']);
        $payment->payment_method = $request['payment_method'];
        $payment->payment_type = $request['payment_type'];
        $payment->description = $request['description'];
        $payment->save();

        return $payment->client_payment_id;
    }

}
