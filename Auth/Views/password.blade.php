@extends('layouts.min')
@section('title', 'Login')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="">Consultancy Database</a>
        </div>

        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Forgot Password?</p>
            @if(Session::has('message'))
                <div class="callout callout-danger">
                    <h4>Invalid Login</h4>
                    <p>{{Session::get('message')}}</p>
                </div>
            @endif
            @if(Session::has('message_success'))
                <div class="callout callout-success">
                    <p>{{Session::get('message_success')}}</p>
                </div>
            @endif

            <p class="login-box-msg">To reset your password, enter the email address you used to sign in to Condat System.</p>
            <form action="" method="post">

                <input type="hidden" name="_token" value="{{csrf_token()}}">

                <div class="form-group has-feedback @if($errors->has('email')) {{'has-error'}} @endif">
                    <input type="text" class="form-control" name="email" placeholder="Email"
                           value="{{old('email')}}"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if($errors->has('email'))
                        {!! $errors->first('email', '<label class="control-label" for="inputError">:message</label>
                        ') !!}
                    @endif

                </div>
                <div class="row">
                    <div class="col-xs-7 pull-right">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Reset Password</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="login-box-footer">
            <p class="text-center">
                <small>&copy; copyright 2015 | Webunisoft</small>
            </p>
        </div>
    </div>
@stop
