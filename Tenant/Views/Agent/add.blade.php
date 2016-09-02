@extends('layouts.tenant')
@section('title', 'Add Agent')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/agents')}}" title="All Agents"><i class="fa fa-briefcase"></i> Agents</a></li>
    <li>Add</li>
@stop
@section('content')
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Agent Details</h3>
            </div>
            @include('flash::message')
            {!!Form::open(array('route' => ['tenant.agents.store'], 'class' => 'form-horizontal form-left'))!!}
            @include('Tenant::Agent/form')
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Add"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop
