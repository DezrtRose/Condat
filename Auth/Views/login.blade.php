@extends('layouts.min')
@section('title', 'Login')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="">Consultancy Database</a>
        </div>

        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in</p>
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
                <div class="form-group has-feedback @if($errors->has('password')) {{'has-error'}} @endif">
                    <input type="password" name="password" class="form-control" placeholder="Password"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if($errors->has('password'))
                        {!! $errors->first('password', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                    @endif
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember" value=1> Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <a href="{{url('forgot-password')}}">
                <small>I forgot my password</small>
            </a><br>
            <a href="register" class="text-center">Register a new membership</a>
        </div>
        <div class="login-box-footer">
            <p class="text-center">
                <small>&copy; copyright 2015 | Webunisoft</small>
            </p>
        </div>
    </div>
@stop
