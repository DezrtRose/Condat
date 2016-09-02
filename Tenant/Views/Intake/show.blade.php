@extends('layouts.tenant')
@section('title', 'Client View')
@section('heading', 'Client View')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
@stop
@section('content')
    <div class="col-md-4">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                {{--<img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg"
                     alt="User profile picture">--}}

                <h3 class="profile-username text-center">Client ID: {{format_id($client->client_id, 'C')}}</h3>

                <p class="text-muted text-center">System Client</p>

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

                <a href="{{route('tenant.client.edit', $client->client_id)}}" class="btn btn-primary btn-block"><b>Update</b></a>
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
                <p class="text-muted">{{format_datetime($client->created_at)}}</p>
                <hr>
                <strong><i class="fa fa-file-text-o margin-r-5"></i> Description</strong>
                <p class="text-muted">{{$client->description}}</p>
                <hr>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-xs-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Personal Details</h3>
            </div>
            <div class="box-body">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th style="width: 34%;">Client ID</th>
                        <td>{{format_id($client->client_id, 'C')}}</td>
                    </tr>
                    <tr>
                        <th>First Name</th>
                        <td>{{$client->first_name}}</td>
                    </tr>
                    <tr>
                        <th>Middle Name</th>
                        <td>{{$client->middle_name}}</td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td>{{$client->last_name}}</td>
                    </tr>
                    <tr>
                        <th>Sex</th>
                        <td>{{$client->sex}}</td>
                    </tr>
                    <tr>
                        <th>DOB</th>
                        <td>{{format_date($client->dob)}}</td>
                    </tr>
                    <tr>
                        <th>Passport No.</th>
                        <td>{{$client->passport_no}}</td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td>{{$client->email}}</td>
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
                <tr>
                    <th style="width: 34%;">Line 1</th>
                    <td>{{ $client->line1 }}</td>
                </tr>
                <tr>
                    <th>Line 2</th>
                    <td>{{ $client->line2 }}</td>
                </tr>
                <tr>
                    <th>Street</th>
                    <td>{{ $client->street }}</td>
                </tr>
                <tr>
                    <th>Suburb</th>
                    <td>{{ $client->suburb }}</td>
                </tr>
                <tr>
                    <th>Postcode</th>
                    <td>{{ $client->postcode }}</td>
                </tr>
                <tr>
                    <th>State</th>
                    <td>{{ $client->state }}</td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td>{{ get_country($client->country_id) }}</td>
                </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
