<?php namespace App\Modules\Tenant\Models\Invoice;

use App\Modules\Tenant\Models\Application\CourseApplication;
use App\Modules\Tenant\Models\Application\StudentApplicationPayment;
use Illuminate\Database\Eloquent\Model;
use DB;

class StudentInvoice extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_invoices';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'student_invoice_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['invoice_id', 'application_id', 'client_id'];

    public $timestamps = false;

    function add(array $request, $client_id)
    {
        DB::beginTransaction();

        try {
            $invoice = Invoice::create([
                'amount' => $request['amount'],
                'invoice_date' => insert_dateformat($request['invoice_date']),
                'discount' => $request['discount'],
                'invoice_amount' => $request['invoice_amount'],
                'final_total' => $request['final_total'],
                'total_gst' => $request['total_gst'],
                'description' => $request['description'],
                'due_date' => insert_dateformat($request['due_date']),
            ]);

            $student_invoice = StudentInvoice::create([
                'invoice_id' => $invoice->invoice_id,
                'application_id' => ($request['application_id'] != 0)? $request['application_id'] : null,
                'client_id' => $client_id
            ]);

            DB::commit();
            return $student_invoice->student_invoice_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    function getStats($application_id)
    {
        $stats = array();
        $stats['invoice_amount'] = $this->getTotalAmount($application_id);
        $stats['total_paid'] = $this->getTotalPaid($application_id);
        $due_amount = $stats['invoice_amount'] - $stats['total_paid'];
        $stats['due_amount'] = ($due_amount < 0) ? 0 : $due_amount;
        return $stats;
    }

    function getTotalAmount($application_id)
    {
        $invoices = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->where('student_invoices.application_id', $application_id)
            ->sum('invoices.amount');
        return $invoices;
    }

    function getTotalPaid($application_id)
    {
        $payments = StudentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'student_application_payments.client_payment_id')
            ->join('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->where('course_application_id', $application_id)
            ->sum('client_payments.amount');
        return $payments;
    }

    function getList($application_id)
    {
        $invoices = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->where('student_invoices.application_id', $application_id)
            ->select('invoices.invoice_id', 'invoices.amount')
            ->orderBy('created_at', 'desc')
            ->get();
        //->lists('invoice_details', 'invoices.invoice_id');
        $invoice_list = array();
        foreach ($invoices as $key => $invoice) {
            $formatted_id = format_id($invoice->invoice_id, 'SI');
            $invoice_list[$invoice->invoice_id] = $formatted_id . ', $' . $invoice->amount;
        }
        return $invoice_list;
    }

    function getClientId($invoice_id)
    {
        $client = StudentInvoice::join('course_application', 'student_invoices.application_id', '=', 'course_application.course_application_id')
            ->select('client_id')
            ->find($invoice_id);
        return $client->client_id;
    }

    function getOutstandingAmount($invoice_id)
    {
        $paid = $this->getPaidAmount($invoice_id);
        $final_total = Invoice::find($invoice_id)->invoice_amount;
        $outstanding = ($final_total - $paid > 0) ? $final_total - $paid : 0;
        return $outstanding;
    }

    function getPaidAmount($invoice_id)
    {
        $paid = StudentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'student_application_payments.client_payment_id')
            ->join('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->where('invoice_id', $invoice_id)
            ->sum('client_payments.amount');
        return $paid;
    }

    function getDetails($invoice_id)
    {
        $student_invoice = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->select(['invoices.*', 'student_invoices.*'])
            ->find($invoice_id);
        return $student_invoice;
    }

    function getPayDetails($invoice_id)
    {
        $details = new \stdClass();
        $details->paid = $this->getPaidAmount($invoice_id);
        $details->outstandingAmount = $this->getOutstandingAmount($invoice_id);
        return $details;
    }

    function editInvoice(array $request, $invoice_id)
    {
        $student_invoice = StudentInvoice::find($invoice_id);
        $invoice = Invoice::find($student_invoice->invoice_id);
        $invoice->amount = $request['amount'];
        $invoice->invoice_date = insert_dateformat($request['invoice_date']);
        $invoice->discount = $request['discount'];
        $invoice->invoice_amount = $request['invoice_amount'];
        $invoice->final_total = $request['final_total'];
        $invoice->total_gst = $request['total_gst'];
        $invoice->description = $request['description'];
        $invoice->due_date = insert_dateformat($request['due_date']);
        $invoice->save();

        return $student_invoice->application_id;
    }
}
