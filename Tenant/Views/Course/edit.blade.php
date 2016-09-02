@extends('layouts.tenant')
@section('title', 'Update Course')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Update</li>
@stop
@section('content')
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Course Details</h3>
            </div>
            @include('flash::message')
            {!!Form::model($course, array('route' => array('tenant.course.update', $course->course_id), 'class' => 'form-horizontal form-left', 'method' => 'put'))!!}
            @include('Tenant::Course/form')
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop
