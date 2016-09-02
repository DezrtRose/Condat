@extends('layouts.tenant')
@section('title', 'All Intakes')
@section('breadcrumb')
    @parent
    <li><a href="{{url('institute')}}" title="All Institutes"><i class="fa fa-dashboard"></i> Institutes</a></li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')
        @include('Tenant::Institute/navbar')

        <div class="col-md-3 col-xs-12">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">General Information</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-calendar margin-r-5"></i> Institute Id</strong>

                    <p class="text-muted">{{format_id($institute->institution_id, 'I')}}</p>

                    <strong><i class="fa fa-calendar margin-r-5"></i> Short Name</strong>

                    <p class="text-muted">{{$institute->short_name}}</p>

                    <strong><i class="fa fa-phone margin-r-5"></i> Website</strong>

                    <p class="text-muted"><a href="http://{{ $institute->website }}"
                                             target="_blank">{{$institute->website}}</a></p>

                    <strong><i class="fa fa-calendar margin-r-5"></i> Invoice To</strong>

                    <p class="text-muted">{{$institute->invoice_to_name}}</p>

                    <strong><i class="fa fa-calendar margin-r-5"></i> Created At</strong>

                    <p class="text-muted">{{format_datetime($institute->created_at)}}</p>

                    <strong><i class="fa fa-phone margin-r-5"></i> Created By</strong>

                    <p class="text-muted">{{$institute->number}}</p>

                </div>
                <!-- /.box-body -->
            </div>

        </div>

        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Manage Intakes</h3>
                    {{--<a href="{{route('tenant.intake.create', $institution_id)}}" class="btn btn-primary btn-flat pull-right">Add New Intake</a>--}}
                    <a href="#" data-toggle="modal" data-target="#intake-modal"
                       class="btn btn-primary btn-flat pull-right">Add New Intake</a>
                </div>
                <div class="box-body">
                    <table id="intakes" class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th>Intake ID</th>
                            <th>Intake Date</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Intake -->
    <div id="intake-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Intake</h4>
                </div>
                {!!Form::open(array('route' => ['tenant.intake.store', $institute->institution_id], 'class' => 'form-horizontal form-left'))!!}

                @include('Tenant::Intake/form')

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                {!!Form::close()!!}
            </div>

        </div>
    </div>
    <!-- End Modal -->

    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#intakes').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": appUrl + "/tenant/intakes/" + <?php echo $institution_id ?> +"/data",
                "columns": [
                    {data: 'intake_id', name: 'intake_id'},
                    {data: 'intake_date', name: 'intake_date'},
                    {data: 'description', name: 'description'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@stop
