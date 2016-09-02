<?php namespace App\Modules\Tenant\Models\Report;
use App\Modules\Tenant\Models\Invoice\CollegeInvoice;
use App\Modules\Tenant\Models\Invoice;
use App\Modules\Tenant\Models\College\OtherCommission;
use App\Modules\Tenant\Models\College\TuitionCommission;
use App\Modules\Tenant\Models\Payment\CollegePayment;
use Illuminate\Database\Eloquent\Model;
use DB;

Class Report extends Model{

	public function CollegeInvoiceReport(){
		$college_invoice = CollegeInvoice::leftJoin('course_application', 'course_application.course_application_id', '=', 'college_invoices.course_application_id')
            ->leftJoin('clients', 'clients.client_id', '=', 'course_application.client_id')
            ->leftjoin('persons', 'persons.person_id', '=', 'clients.person_id')
            ->leftjoin('courses', 'course_application.institution_course_id', '=', 'courses.course_id')
            ->leftjoin('institute_courses', 'institute_courses.course_id', '=', 'courses.course_id')
            ->leftjoin('institutes', 'institute_courses.institute_id', '=', 'institutes.institution_id')
            ->leftjoin('companies', 'companies.company_id', '=', 'institutes.company_id')
            ->leftjoin('college_invoice_payments', 'college_invoice_payments.college_invoice_id', '=', 'college_invoices.college_invoice_id')
            ->leftjoin('college_payments', 'college_payments.college_payment_id', '=', 'college_invoice_payments.ci_payment_id')
            ->select('college_invoices.*','persons.*','institutes.*','courses.name as course_name', 'college_invoices.college_invoice_id as invoice_id','companies.name as institute_name',DB::raw('SUM(college_payments.amount) AS total_paid') )
            ->groupBy('college_invoices.college_invoice_id')
            ->orderBy('college_invoices.college_invoice_id', 'desc')
            ->get();

        return $college_invoice;
	}

	public function PreviousCollegeInvoiceReport(){
		$college_invoice = CollegeInvoice::leftJoin('ci_tuition_commissions', 'ci_tuition_commissions.college_invoice_id', '=', 'college_invoices.college_invoice_id')
            ->leftJoin('ci_other_commissions', 'ci_other_commissions.college_invoice_id', '=', 'college_invoices.college_invoice_id')
            ->leftJoin('course_application', 'course_application.course_application_id', '=', 'college_invoices.course_application_id')
            ->leftJoin('clients', 'clients.client_id', '=', 'course_application.client_id')
            ->leftjoin('persons', 'persons.person_id', '=', 'clients.person_id')
            ->leftjoin('courses', 'course_application.institution_course_id', '=', 'courses.course_id')
            ->leftjoin('institute_courses', 'institute_courses.course_id', '=', 'courses.course_id')
            ->leftjoin('institutes', 'institute_courses.institute_id', '=', 'institutes.institution_id')
            ->leftjoin('companies', 'companies.company_id', '=', 'institutes.company_id')
            ->select('college_invoices.*','persons.*','institutes.*','courses.name as course_name', 'college_invoices.college_invoice_id as invoice_id','companies.name as institute_name', 'ci_tuition_commissions.*', 'ci_other_commissions.amount as incentive', 'ci_other_commissions.gst as incentive_gst', 'ci_other_commissions.description as other_description')
            ->get();

        return $college_invoice;
	}

	

}