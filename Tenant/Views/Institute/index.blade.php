@extends('layouts.tenant')
@section('title', 'All Institutions')
@section('breadcrumb')
    @parent
    <li><a href="{{url('institute')}}" title="All Institutions"><i class="fa fa-dashboard"></i> Institutions</a></li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">All Institutions</h3>
                <a href="{{route('tenant.institute.create')}}" class="btn btn-primary btn-flat pull-right">Add New Institute</a>
            </div>
            <div class="search">
                
            </div>

            <div class="box-body">
                <table id="institutes" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Institute ID</th>
                        <th>Institute Name</th>
                        <th>Short Name</th> 
                        <th>Phone</th>
                        <th>Website</th>    
                        <th>Created By</th>
                        <th>Actions</th>
                        
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#institutes').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": appUrl + "/tenant/institutes/data",
                "columns": [
                    {data: 'institution_id', name: 'institution_id'},
                    {data: 'name', name: 'name'},
                    {data: 'short_name', name: 'short_name'},  
                    {data: 'number', name: 'number'},
                    {data: 'website', name: 'website'},
                    {data: 'added_by', name: 'added_by'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@stop
