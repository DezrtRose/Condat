@extends('layouts.app')
@section('title', 'Register Agency')
@section('heading', 'Register Agency')
@section('breadcrumb')
    @parent
    <li><a href="{{url('agency')}}" title="All Agencies"><i class="fa fa-Agencies"></i> Agencies</a></li>
    <li>Register</li>
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @include('flash::message')
                <div class="panel panel-default">
                    <div class="panel-heading">Register Your Agency</div>
                    {!!Form::open(array('class' => 'form-horizontal form-left'))!!}
                    <div class="panel-body">
                        @include('Agency::form')
                    </div>
                    <div class="panel-footer clearfix">
                        <input type="submit" class="btn btn-primary pull-right" value="Register"/>
                    </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@stop
