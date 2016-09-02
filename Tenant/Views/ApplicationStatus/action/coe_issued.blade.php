@extends('layouts.tenant')
@section('title', 'Application COE Issued')
@section('heading', '<h1>Application - <small>COE Issued</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Applications"><i class="fa fa-users"></i> Applications</a></li>
    <li>COE Issued</li>
@stop


@section('content')
    <div class="col-md-12">
        @include('Tenant::ApplicationStatus/partial/navbar')

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Application Offer Details</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-7 col-md-offset-1">
                        {!! Form::model($application, ['class'=>'form-horizontal', 'method'=>'POST', 'route'=>['applications.action.update.coe.issued', $application->application_id], 'files'=>true])!!}

                        <div class="form-group @if($errors->has('tuition_fee')) {{'has-error'}} @endif">
                            {!! Form::label('tuition_fee', 'Total Tuition Fee', ['class'=>'col-md-3 form-label text-right']) !!}
                            <div class="col-md-9">
                                {!!Form::text('tuition_fee', null, array('class' => 'form-control', 'id'=>'tuition_fee'))!!}
                                @if($errors->has('tuition_fee'))
                                    {!! $errors->first('tuition_fee', '<label class="control-label"
                                                                              for="inputError">:message</label>') !!}
                                @endif
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="intake" class="col-sm-3 control-label">Select Intake</label>

                            <div class="col-sm-9">
                                {!!Form::select('intake_id', $intakes, null, array('class' => 'form-control intake', 'id' => 'intake'))!!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="end_date" class="col-sm-3 control-label">Finish Date</label>

                            <div class="col-sm-9">
                                <div class='input-group date'>
                                    <input type="text" name="end_date" class="form-control datepicker" id="end_date">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group @if($errors->has('document')) {{'has-error'}} @endif">
                            {{ Form::label('document', 'Upload Offer Letter', ['class'=>'col-md-3 form-label text-right'])}}
                            <div class="col-md-9">
                                {{ Form::file('document')}}
                                @if($errors->has('document'))
                                    {!! $errors->first('document', '<label class="control-label"
                                                                              for="inputError">:message</label>') !!}
                                @endif
                            </div>
                        </div>

                        <div class="form-group @if($errors->has('student_id')) {{'has-error'}} @endif">
                            {{ Form::label('student_id', 'Notes', ['class'=>'col-md-3 form-label text-right'])}}
                            <div class="col-md-9">
                                {{ Form::text('student_id', null, ['class'=>'form-control', 'placeholder'=>'Student ID'])}}
                                @if($errors->has('student_id'))
                                    {!! $errors->first('student_id', '<label class="control-label"
                                                                              for="inputError">:message</label>') !!}
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::submit('Submit',['class'=>'btn btn-primary pull-right'])}}
                            {{ Form::submit('Submit & Continue to Invoice',['class'=>'btn btn-success pull-left'])}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Condat::js("$('.datepicker').datepicker({
                    format: 'dd/mm/yyyy',
                    autoclose: true,
                    todayHighlight: true
                });"
                )
    }}
@stop




