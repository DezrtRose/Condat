@extends('layouts.tenant')
@section('title', 'Add User')
@section('breadcrumb')
    @parent
    <li><a href="{{url('users')}}" title="All Users"><i class="fa fa-users"></i> Users</a></li>
    <li>Add</li>
@stop
@section('content')
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">User Details</h3>
            </div>
            @include('flash::message')
            {!!Form::open(array('route' => 'tenant.user.store', 'class' => 'form-horizontal'))!!}
            @include('Tenant::User/form')
            <div class="box-footer">
                <input type="submit" class="btn btn-primary pull-right" value="Add"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop
