@extends('layouts.tenant')
@section('title', 'Update Invoice')
@section('heading', 'Update Invoice')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Payment Details</a></li>
    <li>Add</li>
@stop
@section('content')

    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Payment</h3>
            </div>
            @include('flash::message')
             {!!Form::model($client, array('route' => array('tenant.client.update', $client->client_id), 'class' => 'form-horizontal form-left', 'method' => 'put'))!!}
            {!!Form::hidden('user_id', $payment->user_id)!!}
            @include('Tenant::Account/ClientInvoice/form')
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Add"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop