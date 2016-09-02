@extends('layouts.tenant')
@section('title', 'Update Agent')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/agents')}}" title="All Agents"><i class="fa fa-users"></i> Agents</a></li>
    <li>Update</li>
@stop
@section('content')
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Agent Details</h3>
            </div>
            @include('flash::message')
            {!!Form::model($agent, array('route' => array('tenant.agents.update', $agent->agent_id), 'class' => 'form-horizontal form-left', 'method' => 'put'))!!}
            @include('Tenant::Agent/form')
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop
