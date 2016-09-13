@extends('layouts.tenant')
@section('title', 'Application Advanced Search')
@section('heading', '<h1>Application - <small>Advanced Search</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Applications"><i class="fa fa-users"></i> Applications</a></li>
    <li>Advanced Search</li>
@stop

@section('content')
    <div class="col-md-12">
        @include('Tenant::ApplicationStatus/partial/navbar')
        @include('flash::message')
    </div>

    <div class="col-md-4 col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Filter Options</h3>
                <input type="submit" class="btn btn-primary pull-right" value="Search"/>
            </div>
            {!!Form::open(array('route' => 'application.search', 'method' => 'post', 'class' => 'form-horizontal form-left'))!!}
            <div class="box-body">

                <div class="form-group">
                    {!!Form::label('status', 'Status', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::select('status', $status, null, array('class' => 'form-control select2'))!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('college_name', 'College Name', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::select('college_name', $colleges, null, array('class' => 'form-control select2', 'multiple' => 'multiple'))!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('course_name', 'Course Name', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('course_name', null, array('class' => 'form-control', 'id'=>'course_name'))!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('client_name', 'Client Name', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('client_name', null, array('class' => 'form-control', 'id'=>'client_name'))!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('invoice_to', 'Invoice To', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('invoice_to', null, array('class' => 'form-control', 'id'=>'invoice_to'))!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('added_by', 'Added By', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::select('added_by', $users, null, array('class' => 'form-control select2'))!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('intake_date', 'Intake Date', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {{--<div class='input-group date'>
                            {!!Form::text('from', null, array('class' => 'form-control datepicker', 'id'=>'from', 'placeholder' => "From"))!!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <div class='input-group date marginTop'>
                            {!!Form::text('to', null, array('class' => 'form-control datepicker', 'id'=>'to', 'placeholder' => "To"))!!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>--}}
                        <div class='input-group'>
                            {!!Form::text('intake_date', null, array('class' => 'form-control dateranger', 'id'=>'intake_date', 'placeholder' => "Select Date Range"))!!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('super_agent', 'Super Agent', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('super_agent', null, array('class' => 'form-control', 'id'=>'super_agent'))!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('sub_agent', 'Sub Agent', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('sub_agent', null, array('class' => 'form-control', 'id'=>'sub_agent'))!!}
                    </div>
                </div>
            </div>
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Search"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>

    <div class="col-md-8 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Filtered Applications</h3>
                </div>
                <div class="box-body table-responsive">
                    @if(isset($applications))
                    <table class="table table-striped table-bordered table-condensed" id="application_table">
                        <thead>
                        <tr class="text-nowrap">
                            <th>Id</th>
                            <th>Client Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>College Name</th>
                            <th>Course Name</th>
                            <th>Start date</th>
                            <th>Invoice To</th>
                            <th>Processing</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($applications as $application)
                            <tr>
                                <td>{{ format_id($application->course_application_id, 'AP') }}</td>
                                <td>{{ $application->fullname }}</td>
                                <td>{{ $application->number }}</td>
                                <td>{{ $application->email }}</td>
                                <td>{{ $application->company }}</td>
                                <td>{{ $application->name }}</td>
                                <td>{{ format_date($application->intake_date) }}</td>
                                <td>{{ $application->invoice_to }}</td>
                                <td>
                                    <a href="{{ route('applications.apply.offer',[$application->course_application_id])}}"
                                       title="Apply Offer"><i
                                                class=" btn btn-primary btn-sm glyphicon glyphicon-education"
                                                data-toggle="tooltip" data-placement="top"
                                                title="Apply Offer"></i></a>
                                    <a href="#" title="view"><i
                                                class="processing btn btn-primary btn-sm glyphicon glyphicon-eye-open"
                                                data-toggle="tooltip" data-placement="top" title="View"></i></a>
                                    <a href="#" title="edit"><i
                                                class="processing btn btn-primary btn-sm glyphicon glyphicon-edit"
                                                data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                    <a href="{{ route('applications.cancel.application',[$application->course_application_id])}}"
                                       title="cancel/quarantine"><i
                                                class="processing btn btn-primary btn-sm glyphicon glyphicon-trash"
                                                data-toggle="tooltip" data-placement="top"
                                                title="Cancel/Quarantine"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="callout callout-warning">
                        <h4>No Filtered Records!</h4>

                        <p>You can search for the applications by providing the details in the form.</p>
                    </div>
                    @endif
                </div>
            </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#application_table').DataTable({
                "pageLength": 10
            });

            $('.datepicker').datepicker({
                autoclose: true
            });

            $('.dateranger').daterangepicker({
                autoUpdateInput: false
            });
        });
    </script>
@stop