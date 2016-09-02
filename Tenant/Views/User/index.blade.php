@extends('layouts.tenant')
@section('title', 'All Users')
@section('breadcrumb')
    @parent
    <li><a href="{{url('users')}}" title="All Users"><i class="fa fa-dashboard"></i> Users</a></li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Manage Users</h3>
                <a href="{{route('tenant.user.create')}}" class="btn btn-primary btn-flat pull-right">Add New User</a>
            </div>
            <div class="box-body">
                <table id="users" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
            $(document).ready(function () {
                oTable = $('#users').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": appUrl + "/tenant/users/data",
                    "columns": [
                        {data: 'user_id', name: 'user_id'},
                        {data: 'fullname', name: 'fullname'},
                        {data: 'email', name: 'email'},
                        {data: 'status', name: 'status'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    order: [ [0, 'desc'] ]
                });
            });
        </script>
@stop
