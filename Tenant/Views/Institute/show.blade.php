@extends('layouts.tenant')
@section('title', 'Institute View')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/institute')}}" title="All Institutes"><i class="fa fa-building"></i> Institutes</a></li>
    <li>View</li>
@stop
@section('content')
    @include('Tenant::Institute/navbar')

    <div class="col-md-3 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">General Information</h3>
                <div class="box-tools pull-right"><a data-toggle="tooltip" title="Edit Institute" class="btn btn-action-box" href ="{{ route( 'tenant.institute.edit', $institute->institution_id) }}"><i class="fa fa-edit"></i></a> </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-circle-o margin-r-5"></i> Institute Id</strong>

                <p class="text-muted">{{format_id($institute->institution_id, 'I')}}</p>

                <strong><i class="fa fa-star margin-r-5"></i> Institute Name</strong>

                <p class="text-muted">{{$institute->name}}</p>

                <strong><i class="fa fa-star-half-full margin-r-5"></i> Short Name</strong>

                <p class="text-muted">{{$institute->short_name}}</p>

                <strong><i class="fa fa-phone margin-r-5"></i> Phone Number</strong>

                <p class="text-muted">{{$institute->number}}</p>

                <strong><i class="fa fa-desktop margin-r-5"></i> Website</strong>

                <p class="text-muted"><a href="http://{{ $institute->website }}"
                                         target="_blank">{{$institute->website}}</a></p>

                <strong><i class="fa fa-file margin-r-5"></i> Invoice To</strong>

                <p class="text-muted">{{$institute->invoice_to_name}}</p>

                <strong><i class="fa fa-calendar margin-r-5"></i> Created At</strong>

                <p class="text-muted">{{format_datetime($institute->created_at)}}</p>

                <strong><i class="fa fa-envelope-o margin-r-5"></i> Email</strong>

                <p class="text-muted">{{$institute->email}}</p>

                <strong><i class="fa fa-user margin-r-5"></i> Added By</strong>

                <p class="text-muted">{{ get_tenant_name($institute->added_by)}}</p>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Super Agents</h3>
            </div>
            <div class="box-body">
                @if(count($super_agents) > 0)
                <table class="table table-hover">
                    <tbody>
                    @foreach($super_agents as $key => $super_agent)
                        <tr>
                            <td>{{$super_agent->name}}</td>
                            <td>{{$super_agent->commission_percent}}%</td>
                            <td><a data-toggle="tooltip" title="Remove Super Agent" class="btn btn-action-box" href ="{{ route('tenant.superagent.remove', ['institute_id' => $institute->institution_id, 'agent_id' => $super_agent->agent_id]) }}" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                    <p class="text-muted well well-sm no-shadow">
                        No super agents found.
                    </p>
                @endif
            </div>
            <div class ="box-footer">
                @if(count($agents) > 0)
                <button class="btn btn-success pull-right" data-toggle="modal" data-target="#agentModal"><i class="glyphicon glyphicon-plus-sign"></i> Super Agent
                </button>
                @endif
            </div>

        </div>

    </div>

    <div class="col-md-9">

        @include('Tenant::Institute/contact')

        @include('Tenant::Institute/address')
    </div>

    <!-- Add Super Agent -->
    <div id="agentModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Super Agent</h4>
                </div>
                {!!Form::open(['url' => 'tenant/superagents/'.$institute->institution_id.'/store', 'id' => 'add-agent', 'class' => 'form-horizontal form-left'])!!}
                <div class="modal-body">

                    <div class="form-group">
                        {!!Form::label('agent_id', 'Agent *', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!!Form::select('agent_id', $agents, null, array('class' => 'form-control', 'id'=>'agent_id'))!!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!!Form::label('commission_percent', 'Commission', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                {!!Form::text('commission_percent', null, array('class' => 'form-control', 'id'=>'	commission_percent'))!!}
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
                        Add
                    </button>
                </div>
                {!!Form::close()!!}
            </div>

        </div>
    </div>

    {!! Condat::registerModal('modal-lg') !!}
@stop
