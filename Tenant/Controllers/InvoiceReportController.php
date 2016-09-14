<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Institute\Institute;
use App\Modules\Tenant\Models\Invoice\Invoice;
use App\Modules\Tenant\Models\Invoice\StudentInvoice;
use App\Modules\Tenant\Models\Report\Report;
use Flash;
use DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class InvoiceReportController extends BaseController
{

    function __construct(Invoice $invoice, StudentInvoice $student_invoice, Report $report, Institute $institute, Request $request)
    {
        $this->invoice = $invoice;
        $this->student_invoice = $student_invoice;
        $this->Report = $report;
        $this->institute = $institute;
        $this->request = $request;
        parent::__construct();
    }

    public function clientInvoicePending()
    {
        $data['invoice_reports'] = $this->student_invoice->getAll();
        return view("Tenant::InvoiceReport/ClientInvoice/invoice_pending", $data);
    }

    public function clientInvoicePaid()
    {
        $data['invoice_reports'] = $this->invoice->getInvoiceDetails();

        $data['date'] = Carbon::now();

        return view("Tenant::InvoiceReport/ClientInvoice/invoice_paid", $data);

    }


    public function clientInvoiceFuture()
    {
        $data['invoice_reports'] = $this->invoice->getInvoiceDetails();

        $data['date'] = Carbon::now();

        return view("Tenant::InvoiceReport/Invoice/invoice_future", $data);
    }

    public function clientInvoiceSearch()
    {
        $data['status'] = [0 => 'All',
            1 => 'Pending',
            2 => 'Paid',
            3 => 'Future'];

        $data['colleges'] = $this->institute->getList()->toArray();
        array_unshift($data['colleges'], 'All');

        if ($this->request->isMethod('post')) {
            //$data['applications'] = $this->application->getFilterResults($this->request->all());
            Flash::success(count($data['applications']) . ' records found.');
        }
        return view('Tenant::InvoiceReport/ClientInvoice/search', $data);
    }


    // college Invoices
    public function collegeInvoicePending()
    {
        $data['invoice_reports'] = $this->Report->CollegeInvoiceReport();
        $data['date'] = Carbon::now();

        return view("Tenant::InvoiceReport/CollegeInvoice/invoice_pending", $data);
    }

    public function CollegeInvoicePaid()
    {
        $data['invoice_reports'] = $this->invoice->CollegeInvoiceReport();

        $data['date'] = Carbon::now();

        return view("Tenant::InvoiceReport/CollegeInvoice/invoice_paid", $data);

    }


    public function collegeInvoiceFuture()
    {
        $data['invoice_reports'] = $this->invoice->CollegeInvoiceReport();

        $data['date'] = Carbon::now();

        return view("Tenant::InvoiceReport/CollegeInvoice/invoice_future", $data);
    }

    public function collegeInvoiceSearch()
    {
        $data['status'] = [0 => 'All',
            1 => 'Pending',
            2 => 'Paid',
            3 => 'Future'];

        $data['colleges'] = $this->institute->getList()->toArray();
        array_unshift($data['colleges'], 'All');

        if ($this->request->isMethod('post')) {
            //$data['applications'] = $this->application->getFilterResults($this->request->all());
            Flash::success(count($data['applications']) . ' records found.');
        }
        return view('Tenant::InvoiceReport/CollegeInvoice/search', $data);
    }


}//end of controller
