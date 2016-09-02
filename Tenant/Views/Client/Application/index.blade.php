@extends('layouts.tenant')
@section('title', 'Application List')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/client')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
@stop
@section('content')

    @include('Tenant::Client/client_header')
    <div class="container">
        <div class="col-xs-12 col-md-12">
            @include('flash::message')
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Manage Applications</h3>
                    <a href="{{route('tenant.application.create', $client->client_id)}}"
                       class="btn btn-primary btn-flat pull-right"><i class="fa  fa-graduation-cap"></i> Enroll Now</a>
                </div>
                <div class="box-body table-responsive">

                    <table id="applications" class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th>Application ID</th>
                            <th>Institute Name</th>
                            <th>Course Name</th>
                            <th>Start Date</th>
                            <th>Finish Date</th>
                            <th>Student Id</th>
                            <th>Total Tuition Fee</th>
                            <th>Status</th>
                            <th>Added By</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#applications').DataTable({
                "processing": true,
                "serverSide": true,

                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true,

                "ajax": appUrl + "/tenant/applications/"+ <?php echo $client->client_id ?> +"/data",
                "columns": [
                    {data: 'application_id', name: 'application_id'},
                    {data: 'name', name: 'name'},
                    {data: 'course_name', name: 'course_name'},
                    {data: 'orientation_date', name: 'orientation_date'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'student_id', name: 'student_id'},
                    {data: 'tuition_fee', name: 'tuition_fee'},
                    {data: 'status', name: 'status'},
                    {data: 'added_by', name: 'added_by'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@stop
