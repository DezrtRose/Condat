@extends('layouts.main')
@section('title', 'Renew Agency Subscription')
@section('heading', 'Renew Agency Subscription')
@section('breadcrumb')
    @parent
    <li><a href="{{url('agency')}}" title="All Agencies"><i class="fa fa-Agencies"></i> Agencies</a></li>
    <li>Subscription</li>
    <li>Renew</li>
@stop
@section('content')
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Subscription Renew</h3>
            </div>
            @include('flash::message')
            {!!Form::open(array('method' => 'post', 'class' => 'form-horizontal form-left'))!!}
            <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        {!!Form::label('renewal_date', 'Renewal Date', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {{ format_date(get_today_date()) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('subscription_years', 'Years', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!!Form::select('subscription_years', config('constants.subscription_years'), null, array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('payment_date', 'Payment Date', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                {!!Form::text('payment_date', null, array('class' =>
                                'form-control datemask', 'data-inputmask' => "'alias': 'dd/mm/yyyy'", 'data-mask'=> ''))!!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('payment_type', 'Payment Type', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!!Form::select('payment_type', config('constants.payment_type'), null, array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('subscription_type', 'Type', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!!Form::select('subscription_type', config('constants.subscription_type'), null, array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Renew" />
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop
