<?php namespace App\Modules\Tenant\Models\Invoice;

use App\Modules\Tenant\Models\Payment\CollegePayment;
use Illuminate\Database\Eloquent\Model;
use DB;

class CollegeInvoicePayment extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'college_invoice_payments';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'invoice_payments_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ci_payment_id', 'college_invoice_id'];

    public $timestamps = false;

    function add(array $request, $invoice_id)
    {
        DB::beginTransaction();

        try {
            $application_id = CollegeInvoice::find($invoice_id)->course_application_id;

            $payment = CollegePayment::create([
                'course_application_id' => $application_id,
                'amount' => $request['amount'],
                'date_paid' => insert_dateformat($request['date_paid']),
                'payment_method' => $request['payment_method'],
                'payment_type' => 'College to Agent',
                'description' => $request['description']
            ]);

            CollegeInvoicePayment::create([
                'ci_payment_id' => $payment->college_payment_id,
                'college_invoice_id' => $invoice_id
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

    /*
     * Assign Payment to Invoice
     */
    public function assign(array $request, $payment_id)
    {
        CollegeInvoicePayment::create([
            'ci_payment_id' => $payment_id,
            'college_invoice_id' => $request['invoice_id']
        ]);
        return true;
    }

}
