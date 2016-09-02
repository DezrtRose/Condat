@extends('layouts.tenant')
@section('title', 'Application Details')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/application')}}" title="All Applications"><i class="fa fa-users"></i> Applications</a>
    </li>
    <li>Details</li>
@stop
@section('content')

    @include('Tenant::Client/Application/navbar')

    <div class="content">

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"> &nbsp;Application -
                    <small>Timeline</small>
                </h3>
            </div>

            <div class="box-body">
                @include('Tenant::Client/Show/timeline')
            </div>
        </div>
    </div>

@stop
