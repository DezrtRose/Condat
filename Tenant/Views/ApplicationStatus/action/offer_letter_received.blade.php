@extends('layouts.tenant')
@section('title', 'Application Offer Letter Received')
@section('heading', '<h1>' . $client_name . '- <small>Offer Letter Received</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Offer Letter Received</li>
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
                    'files'=>true,
                    'method'=>'POST',
                    'route'=>['applications.offer_letter.update',$application->application_id]
                    ])!!}

                <div class="form-group">
                    {{ Form::label('institute_name', 'Institute Name',['class'=>'col-md-3 form-label text-right'])}}
                    <div class="col-md-8">
                        {{ $application->company_name }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('course_name', 'Course Name',['class'=>'col-md-3 form-label text-right'])}}
                    <div class="col-md-8">
                        {{ $application->course_name }}
                    </div>
                </div>

                <div class="form-group @if($errors->has('tuition_fee')) {{'has-error'}} @endif">
                    {!! Form::label('tuition_fee', 'Total Tuition Fee', ['class'=>'col-md-3 form-label text-right']) !!}
                    <div class="col-md-8">
                        <div id="total_tuition_fee" class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('tuition_fee', null, array('class' => 'form-control', 'id'=>'tuition_fee'))!!}
                            <span class="input-group-addon">.00</span>
                        </div>
                        @if($errors->has('tuition_fee'))
                            {!! $errors->first('tuition_fee', '<label class="control-label"
                                                                      for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('intake_id', 'Select Intake', ['class'=>'col-md-3 form-label text-right']) !!}
                    <div class="col-md-8">
                        {!!Form::select('intake_id', $intakes, null, array('class' => 'form-control intake', 'id' => 'intake'))!!}
                        <a class="btn btn-success btn-xs marginTop" data-toggle="modal" data-target="#condat-modal"
                           data-url="{{ url('tenant/application/intake/add')}}"><i
                                    class="glyphicon glyphicon-plus-sign"></i> Add Intake</a>
                    </div>
                </div>

                <div class="form-group @if($errors->has('student_id')) {{'has-error'}} @endif">
                    {{ Form::label('student_id', 'Student Id', ['class'=>'col-md-3 form-label text-right'])}}
                    <div class="col-md-8">
                        {{ Form::text('student_id', null, ['class'=>'form-control col-md-12','placeholder'=>'Student ID'])}}
                        @if($errors->has('student_id'))
                            {!! $errors->first('student_id', '<label class="control-label"
                                                                      for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('fee_for_coe')) {{'has-error'}} @endif">
                    {{ Form::label('fee_for_coe', 'Total Fee For COE', ['class'=>'col-md-3 form-label text-right'])}}
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
                    </div>
                </div>

                <div class="form-group @if($errors->has('document')) {{'has-error'}} @endif">
                    {{ Form::label('document', 'Upload Offer Letter', ['class'=>'col-md-3 form-label text-right'])}}
                    <div class="col-md-8">
                        {{ Form::file('document')}}
                        @if($errors->has('document'))
                            {!! $errors->first('document', '<label class="control-label"
                                                                      for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('description')) {{'has-error'}} @endif">
                    {{ Form::label('description', 'Notes', ['class'=>'col-md-3 form-label text-right'])}}
                    <div class="col-md-8">
                        {{ Form::textarea('description', null, ['class'=>'form-control', 'rows'=>3])}}

                        @if($errors->has('description'))
                            {!! $errors->first('description', '<label class="control-label"
                                                                      for="inputError">:message</label>') !!}
                        @endif
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

    {!! Condat::registerModal() !!}

    <script type="text/javascript">
        $(document).on("submit", "#add-intake", function (event) {
            var formData = $(this).serialize();
            var institute_id = '<?php echo $application->institute_id ?>';
            var url = appUrl + '/tenant/intakes/' + institute_id + '/store';

            // process the form
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                dataType: 'json',
                encode: true
            })
                    .done(function (result) {
                        if (result.status == 1) {
                            var select = $('#intake');
                            select.append($("<option></option>").attr("value", result.data.intake_id).text(result.data.name));
                            select.val(result.data.intake_id);

                            if ($(".intake option[value='']").length != 0)
                                $(".intake option[value='']").remove();

                            $('#condat-modal').modal('hide');
                            $('.container .box-primary').before(notify('success', 'Intake Added Successfully!'));
                        }
                        else {
                            $.each(result.data.errors, function (i, v) {
                                //$('#add-institute').find('input[name=' + i + ']').after('<label class="error ">' + v + '</label>').closest('.form-group').addClass('has-error');
                                /* Applicable for other elements like calender, phone */
                                $('#add-intake').find('#' + i).after('<label class="error ">' + v + '</label>').closest('.form-group').addClass('has-error');
                            });
                        }
                        setTimeout(function () {
                            $('.callout').remove()
                        }, 2500);
                    });
            event.preventDefault();
        });

        function notify(type, text) {
            return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
        }
    </script>

@stop




