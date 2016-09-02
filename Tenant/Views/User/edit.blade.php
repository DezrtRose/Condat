@extends('layouts.tenant')
@section('title', 'Update User')
@section('breadcrumb')
    @parent
    <li><a href="{{url('users')}}" title="All Users"><i class="fa fa-users"></i> Users</a></li>
    <li>Update</li>
@stop
@section('content')
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Update User</h3>
            </div>
            @include('flash::message')
            {!!Form::model($user, array('route' => array('tenant.user.update', $user->id), 'class' => 'form-horizontal', 'method' => 'put'))!!}
            @include('Tenant::User/form')
            <div class="box-footer">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop
