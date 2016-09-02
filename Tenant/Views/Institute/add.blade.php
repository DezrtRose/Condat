@extends('layouts.tenant')
@section('title', 'Add Institute')
@section('heading', 'Add Institute')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/institute')}}" title="All Institutes"><i class="fa fa-building"></i> Institutes</a></li>
    <li>Add</li>
@stop
@section('content')
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Institute Details</h3>
            </div>
            @include('flash::message')
            {!!Form::open(array('route' => 'tenant.institute.store', 'class' => 'form-horizontal form-left'))!!}
            @include('Tenant::Institute/form')
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Add"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop

