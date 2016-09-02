@extends('layouts.main')
@section('title', 'Email Settings')
@section('heading', 'Email Settings')
@section('breadcrumb')
    @parent
    <li><a href="{{url('settings')}}" title="Settings"><i class="fa fa-cog"></i> Settings</a></li>
    <li>Email</li>
@stop
@section('content')

    <div class="col-xs-12">
        @include('flash::message')
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Email Details</h3>
            </div>

            {!!Form::open(array('url' => 'settings/email', 'method' => 'post', 'class' => 'form-horizontal'))!!}
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="group" class="form-control" value="email">

            <div class="box-body">
                <div class="form-group">
                    {!!Form::label('exampleInputEmail1', 'Sender Name', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-8">
                        <input type="text" name="name" class="form-control"
                               value="{{ $setting->name or old('name') }}"/>
                        @if($errors->has('name'))
                            {!! $errors->first('name', '<label for="inputError" class="control-label has-error"><i
                                        class="fa fa-times-circle-o"></i> :message</label>') !!}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('exampleInputEmail1', 'Sender Email', array('class' => 'col-sm-2
                    control-label')) !!}
                    <div class="col-sm-8">
                        <input type="email" name="email" id="exampleInputEmail1" class="form-control"
                               value="{{ $setting->email or old('email') }}">
                        @if($errors->has('email'))
                            {!! $errors->first('email', '<label for="inputError"
                                                                class="control-label has-error"><i
                                        class="fa fa-times-circle-o"></i> :message</label>') !!}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('exampleInputEmail1', 'Sender Password', array('class' => 'col-sm-2
                    control-label')) !!}
                    <div class="col-sm-8">
                        <input type="password" name="password" class="form-control"
                               value="{{ $setting->password or old('password') }}">
                        @if($errors->has('password'))
                            {!! $errors->first('password', '<label for="inputError"
                                                                   class="control-label has-error"><i
                                        class="fa fa-times-circle-o"></i> :message</label>') !!}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('exampleInputEmail1', 'Email Notify', array('class' => 'col-sm-2
                    control-label')) !!}
                    <div class="col-sm-8">
                        <input type="email" name="notify" id="exampleInputEmail2" class="form-control"
                               value="{{ $setting->notify or  old('notify') }}">
                        @if($errors->has('notify'))
                            {!! $errors->first('notify', '<label for="inputError"
                                                                 class="control-label has-error"><i
                                        class="fa fa-times-circle-o"></i> :message</label>') !!}
                        @endif
                    </div>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button class="btn btn-primary pull-right" type="submit">Save</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop