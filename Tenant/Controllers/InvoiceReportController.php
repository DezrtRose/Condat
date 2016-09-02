<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Invoice\Invoice;
use App\Modules\Tenant\Models\Report\Report;
use Flash;
use DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class InvoiceReportController extends BaseController
{

    function __construct(Invoice $invoice,Report $report)
    {
        $this->Invoice = $invoice;
        $this->Report=$report;
        parent::__construct();
    }

    public function clientInvoicePending()
    {
        $data['invoice_reports'] = $this->Invoice->getInvoiceDetails();
        $data['date'] = Carbon::now();

        return view("Tenant::InvoiceReport/ClientInvoice/invoice_pending",$data);
    }

     public function clientInvoicePaid()
    {
        $data['invoice_reports'] = $this->Invoice->getInvoiceDetails();
        
        $data['date'] = Carbon::now();     
                      
        return view("Tenant::InvoiceReport/ClientInvoice/invoice_paid",$data);

    }
             

    public function clientInvoiceFuture()
    {
        $data['invoice_reports'] = $this->Invoice->getInvoiceDetails();
        
        $data['date'] = Carbon::now();

        return view("Tenant::InvoiceReport/Invoice/invoice_future",$data);
    }



    
    // college Invoices
    public function collegeInvoicePending()
    {
        $data['invoice_reports'] = $this->Report->CollegeInvoiceReport();
        $data['date'] = Carbon::now();

        return view("Tenant::InvoiceReport/CollegeInvoice/invoice_pending",$data);
    }

     public function CollegeInvoicePaid()
    {
        $data['invoice_reports'] = $this->Invoice->CollegeInvoiceReport();
        
        $data['date'] = Carbon::now();     
                      
        return view("Tenant::InvoiceReport/CollegeInvoice/invoice_paid",$data);

    }
             

    public function collegeInvoiceFuture()
    {
        $data['invoice_reports'] = $this->Invoice->CollegeInvoiceReport();
        
        $data['date'] = Carbon::now();

        return view("Tenant::InvoiceReport/CollegeInvoice/invoice_future",$data);
    }
        

}//end of controller
