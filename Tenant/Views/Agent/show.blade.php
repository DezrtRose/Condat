@extends('layouts.tenant')
@section('title', 'Agent View')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/agents')}}" title="All Agents"><i class="fa fa-users"></i> Agents</a></li>
    <li>View</li>
@stop
@section('content')
    <div class="col-md-4">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                {{--<img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg"
                     alt="User profile picture">--}}

                <h3 class="profile-username text-center">Agent ID: {{format_id($agent->agent_id, 'Ag')}}</h3>

                <p class="text-muted text-center">System Agent</p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Followers</b> <a class="pull-right">1,322</a>
                    </li>
                    <li class="list-group-item">
                        <b>Following</b> <a class="pull-right">543</a>
                    </li>
                    <li class="list-group-item">
                        <b>Friends</b> <a class="pull-right">13,287</a>
                    </li>
                </ul>

                <a href="{{route('tenant.agents.edit', $agent->agent_id)}}" class="btn btn-primary btn-block"><b>Update</b></a>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- About Me Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">General Information</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-calendar margin-r-5"></i> Created At</strong>
                <p class="text-muted">{{format_datetime($agent->created_at)}}</p>
                <hr>
                <strong><i class="fa fa-file-text-o margin-r-5"></i> Description</strong>
                <p class="text-muted">{{$agent->description}}</p>
                <hr>
                <strong><i class="fa fa-plus-square margin-r-5"></i> Added By</strong>
                <p class="text-muted">{{get_tenant_name($agent->added_by)}}</p>
                <hr>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-xs-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Company Details</h3>
            </div>
            <div class="box-body">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th style="width: 34%;">Agent ID</th>
                        <td>{{format_id($agent->agent_id, 'Ag')}}</td>
                    </tr>
                    <tr>
                        <th>Company Name</th>
                        <td>{{$agent->name}}</td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td>{{$agent->number}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$agent->email}}</td>
                    </tr>
                    <tr>
                        <th>Website</th>
                        <td>{{$agent->website}}</td>
                    </tr>
                    <tr>
                        <th>Invoice To Whom</th>
                        <td>{{$agent->invoice_to_whom}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xs-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-map-marker"></i> Address Details</h3>
            </div>
            <div class="box-body">
                <table class="table table-hover">
                <tbody>
                <tr style="width: 34%;">
                    <th>Street</th>
                    <td>{{ $agent->street }}</td>
                </tr>
                <tr>
                    <th>Suburb</th>
                    <td>{{ $agent->suburb }}</td>
                </tr>
                <tr>
                    <th>Postcode</th>
                    <td>{{ $agent->postcode }}</td>
                </tr>
                <tr>
                    <th>State</th>
                    <td>{{ $agent->state }}</td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td>{{ get_country($agent->country_id) }}</td>
                </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
