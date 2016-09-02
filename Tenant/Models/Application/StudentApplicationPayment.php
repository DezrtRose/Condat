<?php namespace App\Modules\Tenant\Models\Application;

use App\Modules\Tenant\Models\Client\ClientPayment;
use App\Modules\Tenant\Models\Invoice\StudentInvoice;
use App\Modules\Tenant\Models\PaymentInvoiceBreakdown;
use Illuminate\Database\Eloquent\Model;
use DB;

class StudentApplicationPayment extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_application_payments';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'student_payments_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['course_application_id', 'client_payment_id'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;

    public function add(array $request, $application_id)
    {
        DB::beginTransaction();

        try {
            $client_id = CourseApplication::find($application_id)->client_id;
            $payment = $this->createPayment($request, $client_id);

            $student_payment = StudentApplicationPayment::create([
                'course_application_id' => $application_id,
                'client_payment_id' => $payment->client_payment_id,
            ]);

            DB::commit();
            return $student_payment->student_payments_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    public function addAndAssign(array $request, $invoice_id)
    {
        DB::beginTransaction();

        try {
            $payment = $this->createPayment($request);

            /* assign payment to invoice */
            PaymentInvoiceBreakdown::create([
                'invoice_id' => $invoice_id,
                'payment_id' => $payment->client_payment_id
            ]);

            $application_id = StudentInvoice::where('invoice_id', $invoice_id)->first()->application_id;

            $student_payment = StudentApplicationPayment::create([
                'course_application_id' => $application_id,
                'client_payment_id' => $payment->client_payment_id,
            ]);

            DB::commit();
            return $student_payment->student_payments_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    function createPayment($request, $client_id = null)
    {
        $payment = ClientPayment::create([
            'client_id' => $client_id,
            'amount' => $request['amount'],
            'date_paid' => insert_dateformat($request['date_paid']),
            'payment_method' => $request['payment_method'],
            'payment_type' => $request['payment_type'],
            'description' => $request['description']
        ]);

        return $payment;
    }

    function getDetails($payment_id)
    {
        $payment = StudentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'student_application_payments.client_payment_id')
            ->select('client_payments.*', 'student_application_payments.student_payments_id', 'student_application_payments.course_application_id')
            ->find($payment_id);
        return $payment;
    }

    function editPayment($request, $payment_id)
    {
        $student_payment = StudentApplicationPayment::find($payment_id);

        $payment = new ClientPayment();
        $payment->edit($request, $student_payment->client_payment_id);

        return $student_payment->course_application_id;
    }
}
