@extends('layouts.tenant')
@section('title', 'Client Payments')
@section('heading', 'All Payments - <small>SubAgent</small>')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/client')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
@stop
@section('content')

    <div class="col-xs-12">
        @include('Tenant::InvoiceReport/Payment/partial/navbar')
        @include('flash::message')

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">All Payments</h3>
            </div>
            <div class="box-body">
                <table id="payments" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Payment Date</th>
                        <th>Amount</th>
                        <th>Payment Type</th>
                        <th>Invoice Id</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody> <?php //dd($payments->toArray()) ?>

                    @foreach($payments as $key => $payment)
                        <tr>
                            <td>{{ format_id($payment->subagent_payments_id, 'CPI') }}</td>
                            <td>{{ format_date($payment->date_paid) }}</td>
                            <td>{{ format_price($payment->amount) }}</td>
                            <td>{{ $payment->payment_type }}</td>
                            <td>{{ format_id($payment->invoice_id, 'CI')}}</td>
                            <td>{{ $payment->description }}</td>
                            <td>
                                <a href="{{route('subagents.payment.view', $payment->subagent_payments_id)}}" title="Print Payment"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-print"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Print Payment"></i></a>
                                <a href="{{route("application.subagents.editPayment", $payment->subagent_payments_id)}}" title="Edit Payment"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-pencil"
                                            data-toggle="tooltip" data-placement="top" title="Edit Payment"></i></a>
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
            oTable = $('#payments').DataTable({
                "pageLength": 10
            });
        });
    </script>

    {!! Condat::registerModal() !!}
@stop