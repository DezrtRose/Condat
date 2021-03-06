@extends('layouts.tenant')
@section('title', 'Application Notes')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/application')}}" title="All Applications"><i class="fa fa-users"></i> Applications</a>
    </li>
    <li>Notes</li>
@stop
@section('content')

    @include('Tenant::Client/Application/navbar')

    <div class="content">
        <div class="col-md-4 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add</h3>
                </div>

                <!-- /.box-header -->
                <div class="box-body">

                    {!! Form::open(['method' => 'post']) !!}
                        <div class="form-group">
                            <textarea name="description" class="form-control" id="description"></textarea>
                        </div>
                        <div class="checkbox form-group">
                            <label><input type="checkbox" id="remind" name="remind" value="1"> Add to
                                Reminder</label>
                        </div>
                        <div id="reminderDate" style="display: none">
                            <div class="form-group">
                                <label for="reminder_date" class="control-label">Reminder Date</label>

                                <div class="">
                                    <div class='input-group date'>
                                        <input type="text" name="reminder_date" class="form-control datepicker"
                                               id="reminder_date" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit
                            </button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-8 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Application Notes</h3>
                </div>
                <div class="box-body table-responsive">
                    @if(count($notes) > 0)
                        <hr/>
                        <table id="table-lead" class="table table-hover">

                            <thead>
                            <tr>
                                <th>Added By</th>
                                <th>Notes</th>
                                <th>Remind me</th>
                                <th>Reminder date</th>
                                <th>Processing</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($notes as $key => $note)

                                <tr>
                                    <td>{{ get_tenant_name($note->added_by_user_id)}}</td>
                                    <td>{{ $note->description }}</td>
                                    <td>{{ ($note->remind == 1) ? 'yes' : 'no' }}</td>
                                    <td>{{($note->remind == 1) ? format_date($note->reminder_date) : ''}}</td>
                                    <td>
                                        <a href="{{route('tenant.client.notes.delete', $note->notes_id)}}"
                                           target="_blank"
                                           onClick="return confirm('Are you sure want to delete this record')"><i
                                                    class="fa fa-trash"></i> Delete</a>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    @else
                        <p class="text-muted well">
                            No note uploaded yet.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap date picker -->
    <script type="text/javascript">
        $(function () {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                startDate: '+0d',
                autoclose: true,
                todayHighlight: true
            });

        });

        $(document).ready(function () {
            $('#remind').change(function () {
                if (this.checked)
                    $('#reminderDate').fadeIn('slow');
                else
                    $('#reminderDate').fadeOut('slow');
            });
        });
    </script>
@stop
