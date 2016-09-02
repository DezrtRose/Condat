@extends('layouts.tenant')
@section('title', 'Application Apply COE')
@section('heading', '<h1>Application - <small>Apply COE</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Apply COE</li>
@stop

@section('content')
    <div class="col-md-12">

        @include('Tenant::ApplicationStatus/partial/navbar')

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Application Offer Details</h3>
            </div>
            <div class="box-body">
                {!! Form::model($application,[
                    'class'=>'form-horizontal',
                    'method'=>'POST',
                    'route'=>['applications.update.applied.coe', $application->application_id]
                    ])!!}

                <div class="form-group">
                    {{ Form::label('total_fee', 'Total Fee', ['class'=>'col-md-3 form-label text-right'])}}
                    <div class="col-md-8">
                        {{ $application->tuition_fee }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('intake_date', 'Intake Date', ['class'=>'col-md-3 form-label text-right'])}}
                    <div class="col-md-8">
                        {{ format_date($application->intake_date) }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-3 form-label text-right"><strong>Student ID</strong></div>
                    <div class="col-md-8">
                        {{ $application->student_id }}
                    </div>
                </div>

                <div class="form-group @if($errors->has('fee_for_coe')) {{'has-error'}} @endif">
                    {{ Form::label('fee_for_coe', 'Fee Paid For COE', ['class'=>'col-md-3 form-label text-right'])}}
                    <div class="col-md-8">
                        <div id="total_tuition_fee" class="input-group">
                            <span class="input-group-addon">$</span>
                            {{ Form::text('fee_for_coe', null, ['class'=>'form-control col-md-12','placeholder'=>'COE Fee'])}}
                            <span class="input-group-addon">.00</span>
                        </div>
                        @if($errors->has('fee_for_coe'))
                            {!! $errors->first('fee_for_coe', '<label class="control-label"
                                                                      for="inputError">:message</label>') !!}
                        @endif

                        <a href="{{ $offer_letter->shelf_location }}" target="_blank">View Offer Letter</a><br>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-3">
                        {{ Form::submit('Submit',['class'=>'btn btn-primary'])}}
                    </div>
                </div>

                {!! Form::close()!!}
            </div>
        </div>

    </div>
@stop
					 




