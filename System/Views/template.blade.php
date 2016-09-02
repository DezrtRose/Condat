@extends('layouts.main')
@section('title', 'Email Templates')
@section('heading', 'Email Templates')
@section('breadcrumb')
    @parent
    <li><a href="{{url('settings')}}" title="Settings"><i class="fa fa-cog"></i> Settings</a></li>
    <li>Email Templates</li>
@stop
@section('content')

    <div class="col-xs-12">
        @include('flash::message')
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Templates</h3>
            </div>

            <form role="form" method="post" action="{{url('settings/templates')}}">
                <div class="box-body">
                    @if($errors->has())
                        <p class="alert alert-error">
                            <?php foreach($errors->all() as $error) { ?>
                        <div>{{ $error }}</div>
                        <?php } ?>
                        </p>
                    @endif

                    <input type="hidden" name="_token" value="{{csrf_token()}}">

                    <input type="hidden" name="group" class="form-control" value="template">

                    <div class="form-group">
                        <label>Account confirmation email</label><br>
                        <label>Subject : </label>
                        <input type="text" name="confirmation_email_subject" class="form-control"
                               value="{{ $setting->confirmation_email_subject or old('confirmation_email_subject') }}"><br>

                        <label>Body : </label>
                        <textarea id="confirmation_email" rows="3" name="confirmation_email"
                                  class="form-control">{{ $setting->confirmation_email or old('confirmation_email') }}</textarea>


                    </div>

                    <div class="form-group">
                        <label>Forgot password request</label><br>
                        <label>Subject : </label>
                        <input type="text" name="forgot_password_subject" class="form-control"
                               value="{{ $setting->forgot_password_subject or old('forgot_password_subject') }}"><br>

                        <label>Body : </label>
                        <textarea id="forgot_password" rows="3" name="forgot_password"
                                  class="form-control">{{ $setting->forgot_password or old('forgot_password') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Password Reset Confirm</label><br>
                        <label>Subject : </label>
                        <input type="text" name="password_confirm_subject" class="form-control"
                               value="{{ $setting->password_confirm_subject or old('password_confirm_subject') }}"><br>

                        <label>Body : </label>
                        <textarea id="password_confirm" rows="3" name="password_confirm"
                                  class="form-control">{{ $setting->password_confirm or old('password_confirm') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Email Log</label><br>
                        <label>Subject : </label>
                        <input type="text" name="email_log_subject" class="form-control"
                               value="{{ $setting->email_log_subject or old('email_log_subject') }}"><br>

                        <label>Body : </label>
                        <textarea id="email_log" rows="3" name="email_log"
                                  class="form-control">{{ $setting->email_log or old('email_log') }}</textarea>
                    </div>
                </div>

                <div class="box-footer">
                    <button class="btn btn-primary pull-right" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{Condat::js('assets/plugins/ckeditor/ckeditor.js')}}
    {{Condat::js('assets/plugins/ckeditor/styles.js')}}
    {{Condat::js("
    $(function () {
        CKEDITOR.replace('email_log');
        CKEDITOR.replace('confirmation_email');
        CKEDITOR.replace('forgot_password');
        CKEDITOR.replace('password_confirm');
      });
    ")}}

@stop