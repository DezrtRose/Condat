@extends('layouts.tenant')
@section('title', 'Update Payment')
@section('heading', 'Update Payment')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Client</a></li>
    <li>Add</li>
@stop
@section('content')

    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Payment</h3>
            </div>
            @include('flash::message')
            {!!Form::model($payment, array('route' => array('application.subagents.updatePayment', $payment->subagent_payments_id), 'class' => 'form-horizontal form-left', 'method' => 'put'))!!}
            @include('Tenant::SubAgent/Payment/form')
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop