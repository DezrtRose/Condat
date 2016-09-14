@extends('layouts.tenant')
@section('title', 'Client Invoice Advanced Search')
@section('heading', '<h1>Client Invoice - <small>Advanced Search</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Client Invoices"><i class="fa fa-users"></i> Client Invoices</a>
    </li>
    <li>Advanced Search</li>
@stop

@section('content')
    <div class="col-md-12">
        @include('Tenant::InvoiceReport/ClientInvoice/partial/navbar')
        @include('flash::message')
    </div>

    <div class="col-md-12 col-xs-12">
        <div class="box box-primary">
            {!!Form::model($search_attributes, array('route' => 'client.invoice', 'method' => 'post', 'class' => ''))!!}
            <div class="box-header">
                <h3 class="box-title">Filter Options</h3>
                <input type="submit" class="btn btn-primary pull-right" value="Search"/>
            </div>

            <div class="box-body">
                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('status', 'Status', array('class' => 'control-label')) !!}
                    {!!Form::select('status', $status, null, array('class' => 'form-control select2'))!!}

                </div>
                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('client_name', 'Client Name', array('class' => 'control-label')) !!}
                    {!!Form::text('client_name', null, array('class' => 'form-control', 'id'=>'client_name'))!!}

                </div>
                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('invoice_date', 'Invoice Date', array('class' => 'control-label')) !!}
                    <div class='input-group'>
                        {!!Form::text('invoice_date', null, array('class' => 'form-control dateranger', 'id'=>'invoice_date', 'placeholder' => "Select Date Range"))!!}
                        <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                    </div>
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('amount', 'Amount', array('class' => 'control-label')) !!}
                    {!!Form::text('amount', null, array('class' => 'form-control', 'id'=>'amount'))!!}

                </div>
                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('college_name', 'College Name', array('class' => 'control-label')) !!}
                    {!!Form::select('college_name[]', $colleges, null, array('class' => 'form-control select2', 'multiple' => 'multiple'))!!}

                </div>
            </div>
            {{--<div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Search"/>
            </div>--}}
            {!!Form::close()!!}
        </div>
    </div>

    <div class="col-md-12 col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Filtered Client Invoices</h3>
            </div>
            <div class="box-body table-responsive">
                @if(isset($invoice_reports))
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
                @else
                    <div class="callout callout-warning">
                        <h4>No Filtered Records!</h4>

                        <p>You can search for the invoices by providing the details in the form.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#invoice_report_table').DataTable({
                "pageLength": 10
            });

            $('.datepicker').datepicker({
                autoclose: true
            });

            $('.dateranger').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('.dateranger').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('.dateranger').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
@stop