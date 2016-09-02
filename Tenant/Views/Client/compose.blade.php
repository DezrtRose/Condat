@extends('layouts.tenant')
@section('title', 'Client Email')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Email</li>
@stop
@section('content')

    <div class="container">
        <div class="row">
            @include('Tenant::Client/client_header')
        </div>

        <div class="col-md-12">
            {!! Form::open(array('files' => true)) !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Compose New Message</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <div class="form-control"><strong>To: </strong> {{ $client->email }}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::text('subject', null, array('class' => 'form-control', 'id'=>'subject', 'placeholder' => "Subject:"))!!}
                        @if($errors->has('subject'))
                            {!! $errors->first('subject', '<label class="control-label"
                                                                     for="inputError">:message</label>') !!}
                        @endif
                    </div>
                    <div class="form-group">
                        {!!Form::textarea('body', null, array('class' => 'form-control', 'id'=>'compose-textarea', 'style' => "height: 300px"))!!}
                        @if($errors->has('body'))
                            {!! $errors->first('body', '<label class="control-label"
                                                                     for="inputError">:message</label>') !!}
                        @endif
                    </div>
                    {{--<div class="form-group">
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> Attachment
                            <input type="file" name="attachment">
                        </div>
                        <p class="help-block">Max. 32MB</p>
                    </div>--}}
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                    </div>
                    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                </div>
                <!-- /.box-footer -->
            </div>
            {!! Form::close() !!}
            <!-- /. box -->
        </div>
    </div>

    <script>
        $(function () {
            //Add text editor
            $("#compose-textarea").wysihtml5();
        });
    </script>
@stop