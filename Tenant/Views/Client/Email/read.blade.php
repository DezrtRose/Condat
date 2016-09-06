@extends('layouts.tenant')
@section('title', 'Client Email')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Email</li>
@stop
@section('content')
    @include('Tenant::Client/client_header')

    <div class="col-md-3">

        <a href="{{ route('tenant.client.compose', $client->client_id) }}"
           class="btn btn-primary btn-block margin-bottom">Compose</a>

        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Folders</h3>

                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="{{ route('tenant.client.sent', $client->client_id) }}"><i class="fa fa-envelope-o"></i>
                            Sent</a></li>
                    <li><a href="#"><i class="fa fa-file-text-o"></i> Drafts</a></li>
                    <li><a href="#"><i class="fa fa-trash-o"></i> Trash</a></li>
                </ul>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Read Mail</h3>

                {{--<div class="box-tools pull-right">
                    <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Previous"><i class="fa fa-chevron-left"></i></a>
                    <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Next"><i class="fa fa-chevron-right"></i></a>
                </div>--}}
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="mailbox-read-info">
                    <h3>{{ $mail->subject }}</h3>
                    <h5><strong>From:</strong> {{ get_tenant_name($mail->user_id) }} {{-- We need to change this later --}}
                        <span class="mailbox-read-time pull-right">{{ readable_date($mail->created_at) }}</span></h5>
                </div>
                <!-- /.mailbox-read-info -->
                <div class="mailbox-controls with-border text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body"
                                title="Delete">
                            <i class="fa fa-trash-o"></i></button>
                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body"
                                title="" data-original-title="Reply">
                            <i class="fa fa-reply"></i></button>
                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body"
                                title="" data-original-title="Forward">
                            <i class="fa fa-share"></i></button>
                    </div>
                    <!-- /.btn-group -->
                    <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title=""
                            data-original-title="Print">
                        <i class="fa fa-print"></i></button>
                </div>
                <!-- /.mailbox-controls -->
                <div class="mailbox-read-message">
                    {!! $mail->body !!}
                </div>
                <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="pull-right">
                    <button type="button" class="btn btn-default"><i class="fa fa-reply"></i> Reply</button>
                    <button type="button" class="btn btn-default"><i class="fa fa-share"></i> Forward</button>
                </div>
                <button type="button" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</button>
                <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /. box -->
    </div>
@stop