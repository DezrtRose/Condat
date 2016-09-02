@extends('layouts.tenant')
@section('title', 'Update Institute')
@section('heading', 'Update Institute')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/institute')}}" title="All Institutes"><i class="fa fa-building"></i> Institutes</a></li>
    <li>Update</li>
@stop
@section('content')
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Institute Details</h3>
            </div>
            @include('flash::message')
            {!!Form::model($institute, array('route' => array('tenant.institute.update', $institute->institution_id), 'class' => 'form-horizontal form-left', 'method' => 'put'))!!}
            {!!Form::hidden('user_id', $institute->user_id)!!}
            @include('Tenant::Institute/form')
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop
