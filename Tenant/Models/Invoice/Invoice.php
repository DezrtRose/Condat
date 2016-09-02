<?php namespace App\Modules\Tenant\Models\Invoice;

use Illuminate\Database\Eloquent\Model;
use DB;

class Invoice extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'invoice_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['amount', 'discount', 'invoice_date', 'invoice_amount', 'final_total', 'total_gst', 'description', 'due_date'];



    function getInvoiceDetails()
    {
        
      //  SELECT invoices.*,sum(client_payments.amount) from invoices LEFT JOIN payment_invoice_breakdowns on payment_invoice_breakdowns.invoice_id=invoices.invoice_id left JOIN client_payments on client_payments.client_payment_id=payment_invoice_breakdowns.payment_id group by payment_invoice_breakdowns.invoice_id 
        
         $invoice_reports = Invoice::leftjoin('payment_invoice_breakdowns', 'payment_invoice_breakdowns.invoice_id', '=', 'invoices.invoice_id')
            ->leftjoin('client_payments', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->leftjoin('student_invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->leftjoin('clients', 'clients.client_id', '=', 'student_invoices.client_id')
            ->leftjoin('persons', 'persons.person_id', '=', 'clients.person_id')
            ->leftjoin('person_emails', 'persons.person_id', '=', 'person_emails.person_id')
            ->leftjoin('emails', 'emails.email_id', '=', 'person_emails.email_id')
            ->leftjoin('person_phones', 'persons.person_id', '=', 'person_phones.person_id')
            ->leftjoin('phones', 'person_phones.phone_id', '=', 'phones.phone_id')
            ->select([DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname'),'email','phones.number','invoices.invoice_amount','invoices.final_total','invoices.invoice_id','invoices.total_gst','invoices.invoice_date',DB::raw('SUM(client_payments.amount) AS total_paid')])
            ->groupBy('invoices.invoice_id')
            ->orderBy('invoices.invoice_date', 'desc')
            ->get();
            


        return $invoice_reports;
    }

    
}
