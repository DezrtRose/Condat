@extends('layouts.tenant')
@section('title', 'Update Invoice')
@section('heading', 'Update Invoice')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Invoice Details</a></li>
    <li>Add</li>
@stop
@section('content')

    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Update Invoice</h3>
            </div>
            @include('flash::message')
             {!!Form::model($invoice, array('route' => array('tenant.invoice.update', $invoice->student_invoice_id), 'class' => 'form-horizontal form-left', 'method' => 'put'))!!}
            @include('Tenant::Client/Invoice/form')
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop