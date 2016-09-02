@extends('layouts.tenant')
@section('title', 'All Clients')
@section('breadcrumb')
    @parent
    <li><a href="{{url('client')}}" title="All Clients"><i class="fa fa-dashboard"></i> Clients</a></li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">All Clients</h3>
                <a href="{{route('tenant.client.create')}}" class="btn btn-primary btn-flat pull-right">Add New
                    Client</a>
            </div>
            <div class="box-body">
                <table id="clients" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Client ID</th>
                        <th>Client Name</th>
                        <th>Phone No</th>
                        <th>Email</th>
                        <th>Added By</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#clients').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": appUrl + "/tenant/client/data",
                "columns": [
                    {data: 'client_id', name: 'clients.client_id'},
                    {data: 'fullname', name: 'fullname'},
                    {data: 'number', name: 'number'},
                    {data: 'email', name: 'emails.email'},
                    {data: 'added_by', name: 'added_by'},
                    {data: 'active', name: 'active', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order: [[0, 'desc']]
            });
        });

        $(document).on('ifChecked', '.active', function (event) {
            var clientId = $(this).attr('id');
            $.ajax({
                url: appUrl + "/tenant/clients/"+clientId+"/active",
                success: function (result) {
                    $('.content .box-primary').before(notify('success', 'Client Made Active Successfully!'));
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                }
            });
        });

        $(document).on('ifUnchecked', '.active', function (event) {
            var clientId = $(this).attr('id');
            $.ajax({
                url: appUrl + "/tenant/clients/"+clientId+"/inactive",
                success: function (result) {
                    $('.content .box-primary').before(notify('success', 'Client Made Inactive Successfully!'));
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                }
            });
        });

        function notify(type, text) {
            return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
        }

    </script>
@stop
