<?php namespace App\Modules\Tenant\Models\Invoice;

use App\Modules\Tenant\Models\College\OtherCommission;
use App\Modules\Tenant\Models\College\TuitionCommission;
use App\Modules\Tenant\Models\Payment\CollegePayment;
use Illuminate\Database\Eloquent\Model;
use DB;

class CollegeInvoice extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'college_invoices';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'college_invoice_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['course_application_id', 'total_commission', 'total_gst', 'final_total', 'due_date', 'installment_no', 'invoice_date'];

    function add(array $request, $application_id)
    {
        DB::beginTransaction();

        try {
            $college_invoice = CollegeInvoice::create([
                'course_application_id' => $application_id,
                'total_commission' => $request['total_commission'],
                'total_gst' => $request['total_gst'],
                'final_total' => $request['final_total'],
                'installment_no' => $request['installment_no'],
                'invoice_date' => insert_dateformat($request['invoice_date'])
            ]);

            if(isset($request['tuition_fee']))
            {
                $ci_commission = TuitionCommission::create([
                    'tuition_fee' => $request['tuition_fee'],
                    'enrollment_fee' => $request['enrollment_fee'],
                    'material_fee' => $request['material_fee'],
                    'coe_fee' => $request['coe_fee'],
                    'other_fee' => $request['other_fee'],
                    'sub_total' => $request['sub_total'],
                    'description' => $request['description'],
                    'commission_percent' => $request['commission_percent'],
                    'commission_amount' => $request['commission_amount'],
                    'commission_gst' => $request['tuition_fee_gst'],
                    'college_invoice_id' => $college_invoice->college_invoice_id
                ]);
            }

            if(isset($request['incentive']))
            {
                $ci_commission = OtherCommission::create([
                    'amount' => $request['incentive'],
                    'gst' => $request['incentive_gst'],
                    'description' => $request['description'],
                    'college_invoice_id' => $college_invoice->college_invoice_id
                ]);
            }

            DB::commit();
            return $college_invoice->college_invoice_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    function getDetails($invoice_id)
    {
        $college_invoice = CollegeInvoice::leftJoin('ci_tuition_commissions', 'ci_tuition_commissions.college_invoice_id', '=', 'college_invoices.college_invoice_id')
            ->leftJoin('ci_other_commissions', 'ci_other_commissions.college_invoice_id', '=', 'college_invoices.college_invoice_id')
            ->select('college_invoices.*', 'college_invoices.college_invoice_id as invoice_id', 'ci_tuition_commissions.*', 'ci_other_commissions.amount as incentive', 'ci_other_commissions.gst as incentive_gst', 'ci_other_commissions.description as other_description')
            ->find($invoice_id);
        return $college_invoice;
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
        $invoices = CollegeInvoice::select('total_commission')
            ->where('course_application_id', $application_id)
            ->orderBy('created_at', 'desc')
            ->sum('total_commission');
        return $invoices;
    }

    function getTotalPaid($application_id)
    {
        $payments = CollegePayment::has('invoice')
            ->where('course_application_id', $application_id)
            ->sum('amount');
        return $payments;
    }

    function getList($application_id)
    {
        $invoices = CollegeInvoice::select('total_commission', 'college_invoice_id')
            ->where('course_application_id', $application_id)
            ->orderBy('created_at', 'desc')
            ->get();
        //->lists('invoice_details', 'invoices.invoice_id');
        $invoice_list = array();
        foreach($invoices as $key => $invoice)
        {
            $formatted_id = format_id($invoice->college_invoice_id, 'CI');
            $invoice_list[$invoice->college_invoice_id] = $formatted_id. ', $'. $invoice->total_commission;
        }
        return $invoice_list;
    }

    function getClientId($invoice_id)
    {
        $client = CollegeInvoice::join('course_application', 'college_invoices.course_application_id', '=', 'course_application.course_application_id')
            ->select('client_id')
            ->find($invoice_id);
        return $client->client_id;
    }

    function getPaidAmount($invoice_id)
    {
        $paid = CollegePayment::join('college_invoice_payments', 'college_payments.college_payment_id', '=', 'college_invoice_payments.ci_payment_id')
            ->where('college_invoice_payments.college_invoice_id', $invoice_id)
            ->sum('college_payments.amount');
        return $paid;
    }

    //remaining
    function getOutstandingAmount($invoice_id)
    {
        $paid = $this->getPaidAmount($invoice_id);
        $final_total = CollegeInvoice::find($invoice_id)->final_total;
        $outstanding = ($final_total - $paid > 0)? $final_total - $paid : 0;
        return $outstanding;
    }

    function getPayDetails($invoice_id)
    {
        $details = new \stdClass();
        $details->paid = $this->getPaidAmount($invoice_id);
        $details->outstandingAmount = $this->getOutstandingAmount($invoice_id);
        return $details;
    }

    function editInvoice(array $request, $application_id)
    {
        DB::beginTransaction();

        try {
            $college_invoice = CollegeInvoice::create([
                'course_application_id' => $application_id,
                'total_commission' => $request['total_commission'],
                'total_gst' => $request['total_gst'],
                'final_total' => $request['final_total'],
                'installment_no' => $request['installment_no'],
                'invoice_date' => insert_dateformat($request['invoice_date'])
            ]);

            if(isset($request['tuition_fee']))
            {
                $ci_commission = TuitionCommission::create([
                    'tuition_fee' => $request['tuition_fee'],
                    'enrollment_fee' => $request['enrollment_fee'],
                    'material_fee' => $request['material_fee'],
                    'coe_fee' => $request['coe_fee'],
                    'other_fee' => $request['other_fee'],
                    'sub_total' => $request['sub_total'],
                    'description' => $request['description'],
                    'commission_percent' => $request['commission_percent'],
                    'commission_amount' => $request['commission_amount'],
                    'commission_gst' => $request['tuition_fee_gst'],
                    'college_invoice_id' => $college_invoice->college_invoice_id
                ]);
            }

            if(isset($request['incentive']))
            {
                $ci_commission = OtherCommission::create([
                    'amount' => $request['incentive'],
                    'gst' => $request['incentive_gst'],
                    'description' => $request['description'],
                    'college_invoice_id' => $college_invoice->college_invoice_id
                ]);
            }

            DB::commit();
            return $college_invoice->college_invoice_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }
}
