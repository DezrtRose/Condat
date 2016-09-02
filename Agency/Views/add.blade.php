@extends('layouts.main')
@section('title', 'Add Agency')
@section('heading', 'Add Agency')
@section('breadcrumb')
    @parent
    <li><a href="{{url('agency')}}" title="All Agencies"><i class="fa fa-Agencies"></i> Agencies</a></li>
    <li>Add</li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Agency Details</h3>
            </div>
            {!!Form::open(array('route' => 'agency.store', 'class' => 'form-horizontal form-left'))!!}
            <div class="box-body">
                @include('Agency::form')
            </div>
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Add"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop
