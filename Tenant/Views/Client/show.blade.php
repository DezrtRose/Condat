@extends('layouts.tenant')
@section('title', 'Client View')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
@stop
@section('content')

    <div class="container">
        <div class="row">
            @include('Tenant::Client/client_header')
        </div>
        <div class="col-md-3">


            <div class="row">
                <!-- About Me Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">General Information</h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Client ID</strong>

                        <p class="text-muted">{{format_id($client->client_id, 'C')}}</p>

                        <strong><i class="fa fa-calendar margin-r-5"></i> Created At</strong>

                        <p class="text-muted">{{format_datetime($client->created_at)}}</p>

                        <strong><i class="fa fa-user-plus margin-r-5"></i> Created By</strong>

                        <p class="text-muted">{{get_tenant_name($client->added_by)}}</p>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Due Amount</strong>

                        <p class="text-muted">200</p>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Referred By</strong>

                        <p class="text-muted">{{ $client->referred_by }}</p>


                    </div>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="row">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Reminders</h3>

                        <a href="{{url("tenant/clients/$client->client_id/notes")}}"
                           class="btn btn-success pull-right btn-sm"><i class="fa fa-plus"></i> Add New</a>


                    </div>
                    <!-- Recent Payments -->
                    <div class="box-body">
                        @if(count($remainders) > 0)
                            @foreach($remainders as $key => $remainder)
                                <strong><i class="fa fa-file-text-o margin-r-5"></i> {{ $remainder->description }}
                                </strong>

                                <p class="text-muted">{{ format_date($remainder->reminder_date) }}</p>
                            @endforeach
                        @else
                            <p class="text-muted well">
                                No upcoming reminders.
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- /.box -->
        </div>

        <div class="col-md-9">
            <div class="box">
                <div class="box-body">
                    @include('Tenant::Client/Show/timeline')
                </div>
                <!-- /.post -->
            </div>
        </div>
    </div>
    <!-- /.col -->


@stop
