<?php namespace App\Modules\Tenant\Models\Payment;

use Illuminate\Database\Eloquent\Model;
use DB;

class CollegePayment extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'college_payments';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'college_payment_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['course_application_id', 'amount', 'date_paid', 'payment_method', 'description', 'payment_type'];

    /* Defining relationships */
    public function invoice()
    {
        return $this->belongsTo('App\Modules\Tenant\Models\Invoice\CollegeInvoicePayment', 'college_payment_id');
    }

    function add(array $request, $application_id)
    {
        DB::beginTransaction();

        try {
            $payment = CollegePayment::create([
                'course_application_id' => $application_id,
                'amount' => $request['amount'],
                'date_paid' => insert_dateformat($request['date_paid']),
                'payment_method' => $request['payment_method'],
                'payment_type' => $request['payment_type'],
                'description' => $request['description']
            ]);

            DB::commit();
            return $payment->college_payment_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    function paymentToCollege($application_id)
    {
        $payments = CollegePayment::where('course_application_id', $application_id)
            ->where('course_application_id', $application_id)
            ->whereIn('payment_type', ['Agent to College', 'Student to College'])
            ->sum('amount');
        return $payments;
    }

    function commissionClaimed($application_id)
    {
        $payments = CollegePayment::where('course_application_id', $application_id)
            ->where('course_application_id', $application_id)
            ->where('payment_type', 'College to Agent')
            ->sum('amount');
        return $payments;
    }

    function getUninvoicedAmount($application_id)
    {
        $amount = CollegePayment::where('course_application_id', $application_id)
            ->where('course_application_id', $application_id)
            ->doesntHave('invoice')
            ->sum('amount');
        return $amount;
    }

    function getDetails($payment_id)
    {
        $payment = CollegePayment::leftJoin('college_invoice_payments', 'college_payments.college_payment_id', '=', 'college_invoice_payments.ci_payment_id')
            ->select(['college_payments.*'])
            ->find($payment_id);
        return $payment;
    }

    function editPayment($request, $payment_id)
    {
        $payment = CollegePayment::find($payment_id);
        $payment->amount = $request['amount'];
        $payment->date_paid = insert_dateformat($request['date_paid']);
        $payment->payment_method = $request['payment_method'];
        $payment->payment_type = $request['payment_type'];
        $payment->description = $request['description'];
        $payment->save();

        return $payment->course_application_id;
    }
}
