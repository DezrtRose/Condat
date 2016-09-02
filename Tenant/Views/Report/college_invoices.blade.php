@extends('layouts.tenant')
@section('title', 'College Invoices Report')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/client')}}" title="All Clients"><i class="fa fa-users"></i> College Invoices</a></li>
    <li>View</li>
@stop
@section('content')

    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">College Invoices</h3>
            </div>
            <div class="box-body">
                <table id="invoices" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Invoice Id</th>
                        <th>Invoice Date</th>
                        <th>Total Amount</th>
                        <th>Total GST</th>
                        <th>Status</th>
                        <th>Outstanding Amount</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function () {

            iTable = $('#invoices').DataTable({
                "processing": true,
                "serverSide": true,

                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true,

                "ajax": appUrl + "/tenant/applications/invoices/" + <?php echo $invoices->course_application_id ?> +"/data",
                "columns": [
                    {data: 'college_invoice_id', name: 'college_invoice_id'},
                    {data: 'invoice_date', name: 'invoice_date'},
                    {data: 'total_commission', name: 'total_commission'},
                    //{data: 'final_total', name: 'final_total'},
                    {data: 'total_gst', name: 'total_gst'},
                    {data: 'status', name: 'status'},
                    {data: 'outstanding_amount', name: 'outstanding_amount'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    

    
@stop