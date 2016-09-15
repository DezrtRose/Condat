@extends('layouts.tenant')
@section('title', 'College Invoices')
@section('heading', '<h1>College Invoice - <small>Paid</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Notes</li>
@stop

@section('content')
    <div class="col-md-12">
        @include('Tenant::InvoiceReport/CollegeInvoice/partial/navbar')
        @include('flash::message')
    </div>

    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Paid Invoices</h3>
            </div>
            <div class="box-body">
                <table class="table table-striped table-bordered table-condensed" id="invoice_report_table">
                    <thead>
                    <tr class="text-nowrap">
                        <th>Invoice Id</th>
                        <th>Date</th>
                        <th>Client Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Invoice Amount</th>
                        <th>Total gst</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoice_reports as $invoice)
                        <tr>
                            <td>{{ format_id($invoice->invoice_id, 'CI') }}</td>
                            <td>{{ format_date($invoice->invoice_date) }}</td>
                            <td>{{ $invoice->fullname }}</td>
                            <td>{{ $invoice->number }}</td>
                            <td>{{ $invoice->email }}</td>
                            <td>{{ format_price($invoice->total_commission) }}</td>
                            <td>{{ format_price($invoice->total_gst) }}</td>
                            <td>
                                <a href="#" title="Add Payment"><i
                                            class=" btn btn-primary btn-sm glyphicon glyphicon-shopping-cart"
                                            data-toggle="tooltip" data-placement="top" title="Add Payment"></i></a>
                                <a href="#" title="Print Invoice"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-print"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Print Invoice"></i></a>
                                <a href="#" title="View Invoice"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-eye-open"
                                            data-toggle="tooltip" data-placement="top" title="View Invoice"></i></a>
                                <a href="#" title="Email Invoice"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-send"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Email Invoice"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#invoice_report_table').DataTable({
                "pageLength": 10
            });
        });
    </script>
@stop
                      

                      
                            
                

      

              


              
        
