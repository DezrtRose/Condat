@extends('layouts.tenant')
@section('title', 'All Agents')
@section('breadcrumb')
    @parent
    <li><a href="{{url('agents')}}" title="All Agents"><i class="fa fa-dashboard"></i> Agents</a></li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Manage Agents</h3>
                <a href="{{route('tenant.agents.create')}}" class="btn btn-primary btn-flat pull-right">Add New Agent</a>
            </div>
            <div class="box-body">
                <table id="agents" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Agent ID</th>
                        <th>Agent Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Added By</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#agents').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": appUrl + "/tenant/agent/data",
                "columns": [
                    {data: 'agent_id', name: 'agent_id'},
                    {data: 'name', name: 'name'},
                    {data: 'number', name: 'number'},
                    {data: 'email', name: 'email'},
                    {data: 'website', name: 'website'},
                    {data: 'user_email', name: 'user_email'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@stop
