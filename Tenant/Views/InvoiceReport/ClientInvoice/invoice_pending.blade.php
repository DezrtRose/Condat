@extends('layouts.tenant')
@section('title', 'Client Invoices')
@section('heading', 'Client Invoices - <small>Pending Invoices</small>')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Invoices</li>
@stop

@section('content')
    <div class="col-md-12">

        @include('Tenant::InvoiceReport/ClientInvoice/partial/navbar')

        @include('flash::message')
        <div class="box box-primary">
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
                        <th>Outstanding</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoice_reports as $invoice)
                            <tr>
                                <td>{{ format_id($invoice->invoice_id, 'SI') }}</td>
                                <td>{{ format_date($invoice->invoice_date) }}</td>
                                <td>{{ $invoice->fullname }}</td>
                                <td>{{ $invoice->number }}</td>
                                <td>{{ $invoice->email }}</td>
                                <td>{{ format_price($invoice->invoice_amount) }}</td>
                                <td>{{ format_price($invoice->total_gst) }}</td>

                                <td>
                                    @if(($invoice->final_total) - ($invoice->total_paid) == 0)
                                        {{ '-' }}
                                    @else
                                        {{ format_price(($invoice->final_total) - ($invoice->total_paid)) }}
                                    @endif
                                </td>
                                <td>
                                    <a data-toggle="modal" data-target="#condat-modal" data-url="{{url('tenant/invoices/' . $invoice->invoice_id . '/payment/add/2')}}"><i
                                                class=" btn btn-primary btn-sm glyphicon glyphicon-shopping-cart"
                                                data-toggle="tooltip" data-placement="top" title="Add Payment"></i></a>
                                    <a href="#" title="Print Invoice"><i
                                                class="processing btn btn-primary btn-sm glyphicon glyphicon-print"
                                                data-toggle="tooltip" data-placement="top"
                                                title="Print Invoice"></i></a>
                                    <a href="{{route('tenant.student.invoice', $invoice->student_invoice_id)}}" title="View Invoice"><i
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
                "columns": [
                    {data: 'invoice_id', name: 'invoice_id'},
                    {data: 'invoice_date', name: 'invoice_date'},
                    {data: 'fullname', name: 'fullname'},
                    {data: 'number', name: 'number'},
                    {data: 'email', name: 'email'},
                    {data: 'invoice_amount', name: 'invoice_amount'},
                    {data: 'total_gst', name: 'total_gst'},
                    {data: 'outstanding_amount', name: 'outstanding_amount'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order: [[0, 'desc']]
            });
        });
    </script>
    {!! Condat::registerModal() !!}
@stop
                      

                      
                            
                

      

              


              
        
