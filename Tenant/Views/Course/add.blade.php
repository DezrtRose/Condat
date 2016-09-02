@extends('layouts.tenant')
@section('title', 'Add Course')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/course')}}" title="All Courses"><i class="fa fa-users"></i> Courses</a></li>
    <li>Add</li>
@stop
@section('content')
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Course Details</h3>
            </div>
            @include('flash::message')
            {!!Form::open(array('route' => ['tenant.course.store', $institution_id], 'class' => 'form-horizontal form-left'))!!}
            @include('Tenant::Course/form')
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Add"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop
