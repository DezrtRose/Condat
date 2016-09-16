@extends('layouts.tenant')
@section('title', 'Client Payments')
@section('heading', 'All Payments - <small>Client</small>')
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
                @include('Tenant::InvoiceReport/Payment/partial/table')
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