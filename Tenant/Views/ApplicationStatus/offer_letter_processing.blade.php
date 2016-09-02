@extends('layouts.tenant')
@section('title', 'Application Offer Letter Processing')
@section('heading', '<h1>Application - <small>Offer Letter Processing</small></h1>')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Offer Letter Processing</li>
@stop

@section('content')
    <div class="col-md-12">

        @include('Tenant::ApplicationStatus/partial/navbar')

        @include('flash::message')

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">All Applications</h3>
            </div>
            <div class="box-body">
                <table class="table table-striped table-bordered table-condensed" id="offer_table">
                    <thead>
                    <tr class="text-nowrap">
                        <th>Id</th>
                        <th>Client Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>College Name</th>
                        <th>Course Name</th>
                        <th>Start date</th>
                        <th>Invoice To</th>
                        <th>Processing</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($applications as $key => $application)
                        <tr>
                            <td>{{ format_id($application->course_application_id) }}</td>
                            <td>{{ $application->fullname }}</td>
                            <td>{{ $application->number }}</td>
                            <td>{{ $application->email }}</td>
                            <td>{{ $application->company }}</td>
                            <td>{{ $application->name }}</td>
                            <td>{{ format_date($application->intake_date) }}</td>
                            <td>{{ $application->company }}</td>
                            <td>
                                <a href="{{ route('applications.offer.received', $application->course_application_id) }}"
                                   title="Offer Received"><i
                                            class=" btn btn-primary btn-sm glyphicon glyphicon-education"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Offer Received"></i></a>
                                <a href="#" title="view"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-eye-open"
                                            data-toggle="tooltip" data-placement="top"
                                            title="View"></i></a>
                                <a href="#" title="edit"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-edit"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Edit"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#offer_table').DataTable({
                "pageLength": 10
            });
        });
    </script>
@stop