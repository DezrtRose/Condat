@extends('layouts.tenant')
@section('title', 'Add Intake')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/intake')}}" title="All Intakes"><i class="fa fa-graduation-cap"></i> Intakes</a></li>
    <li>Add</li>
@stop
@section('content')
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Course Details</h3>
            </div>
            @include('flash::message')
            {!!Form::open(array('route' => ['tenant.intake.store', $institution_id], 'class' => 'form-horizontal form-left'))!!}
            @include('Tenant::Course/form')
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Add"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop
