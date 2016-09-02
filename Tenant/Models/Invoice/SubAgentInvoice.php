<?php namespace App\Modules\Tenant\Models\Invoice;

use App\Modules\Tenant\Models\Payment\SubAgentApplicationPayment;
use Illuminate\Database\Eloquent\Model;
use DB;

class SubAgentInvoice extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subagent_invoices';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'subagent_invoice_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['invoice_id', 'course_application_id'];

    public $timestamps = false;

    function add(array $request, $application_id)
    {
        DB::beginTransaction();

        try {
            $invoice = Invoice::create([
                'client_id' => null, //change this later
                'amount' => $request['amount'],
                'invoice_date' => insert_dateformat($request['invoice_date']),
                'discount' => $request['discount'],
                //'final_total' => $request['final_total'],
                //'total_gst' => $request['total_gst'],
                'invoice_amount' => $request['invoice_amount'],
                'description' => $request['description'],
                'due_date' => insert_dateformat($request['due_date']),
            ]);

            $subagent_invoice = SubAgentInvoice::create([
                'invoice_id' => $invoice->invoice_id,
                'course_application_id' => $application_id
            ]);

            DB::commit();
            return $subagent_invoice->subagent_invoice_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    function getList($application_id)
    {
        $invoices = SubAgentInvoice::join('invoices', 'subagent_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->select('invoices.invoice_id', 'invoices.amount')
            ->where('subagent_invoices.course_application_id', $application_id)
            ->orderBy('created_at', 'desc')
            ->get();
            //->lists('invoice_details', 'invoices.invoice_id');
        $invoice_list = array();
        foreach($invoices as $key => $invoice)
        {
            $formatted_id = format_id($invoice->invoice_id, 'I');
            $invoice_list[$invoice->invoice_id] = $formatted_id. ', $'. $invoice->amount;
        }
        return $invoice_list;
    }

    function getStats($application_id)
    {
        $stats = array();
        $stats['invoice_amount'] = $this->getTotalAmount($application_id);
        $stats['total_paid'] = $this->getTotalPaid($application_id);
        $due_amount = $stats['invoice_amount'] - $stats['total_paid'];
        $stats['due_amount'] = ($due_amount < 0)? 0 : $due_amount;
        return $stats;
    }

    function getTotalAmount($application_id)
    {
        $invoices = SubAgentInvoice::join('invoices', 'subagent_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->select('invoices.amount')
            ->where('subagent_invoices.course_application_id', $application_id)
            ->orderBy('created_at', 'desc')
            ->sum('invoices.amount');
        return $invoices;
    }

    function getTotalPaid($application_id)
    {
        $payments = SubAgentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'subagent_application_payments.client_payment_id')
            ->join('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->where('course_application_id', $application_id)
            ->sum('client_payments.amount');
        return $payments;
    }

    function getClientId($invoice_id)
    {
        $client = SubAgentInvoice::join('course_application', 'subagent_invoices.application_id', '=', 'course_application.course_application_id')
            ->select('client_id', 'course_application_id')
            ->find($invoice_id);
        return $client->client_id;
    }

    function getOutstandingAmount($invoice_id)
    {
        $paid = $this->getPaidAmount($invoice_id);
        $final_total = Invoice::find($invoice_id)->invoice_amount;
        $outstanding = ($final_total - $paid > 0)? $final_total - $paid : 0;
        return $outstanding;
    }

    function getPaidAmount($invoice_id)
    {
        $paid = SubAgentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'subagent_application_payments.client_payment_id')
            ->join('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->where('invoice_id', $invoice_id)
            ->sum('client_payments.amount');
        return $paid;
    }

    function getDetails($invoice_id)
    {
        $subagent_invoice = SubAgentInvoice::join('invoices', 'subagent_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->select(['invoices.*', 'subagent_invoices.subagent_invoice_id'])
            ->find($invoice_id);
        return $subagent_invoice;
    }

    function editInvoice(array $request, $invoice_id)
    {
        $subagent_invoice = SubAgentInvoice::find($invoice_id);

        $invoice = Invoice::find($subagent_invoice->invoice_id);
        $invoice->amount = $request['amount'];
        $invoice->invoice_date = insert_dateformat($request['invoice_date']);
        $invoice->discount = $request['discount'];
        $invoice->invoice_amount = $request['invoice_amount'];
        //$invoice->final_total = $request['final_total'];
        //$invoice->total_gst = $request['total_gst'];
        $invoice->description = $request['description'];
        $invoice->due_date = insert_dateformat($request['due_date']);
        $invoice->save();

        return $subagent_invoice->course_application_id;
    }
}

