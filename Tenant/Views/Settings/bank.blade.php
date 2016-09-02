@extends('layouts.tenant')
@section('title', 'Bank Details')
@section('breadcrumb')
    @parent
    <li>Bank Details</li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Bank Details</h3>
            </div>
            {!!Form::model($bank, array('route' => ['tenant.bank.store'], 'class' => 'form-horizontal form-left'))!!}
            <div class="box-body">
                <div class="form-group @if($errors->has('name')) {{'has-error'}} @endif">
                    {!!Form::label('name', 'Bank Name *', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-6">
                        {!!Form::text('name', null, array('class' => 'form-control', 'id'=>'name'))!!}
                        @if($errors->has('name'))
                            {!! $errors->first('name', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('account_name')) {{'has-error'}} @endif">
                    {!!Form::label('account_name', 'Account Name *', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-6">
                        {!!Form::text('account_name', null, array('class' => 'form-control', 'id'=>'account_name'))!!}
                        @if($errors->has('account_name'))
                            {!! $errors->first('account_name', '<label class="control-label"
                                                                for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('number')) {{'has-error'}} @endif">
                    {!!Form::label('number', 'Account Number *', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-6">
                        {!!Form::text('number', null, array('class' => 'form-control', 'id'=>'number'))!!}
                        @if($errors->has('number'))
                            {!! $errors->first('number', '<label class="control-label"
                                                                for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('bsb')) {{'has-error'}} @endif">
                    {!!Form::label('bsb', 'BSB', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-6">
                        {!!Form::text('bsb', null, array('class' => 'form-control', 'id'=>'bsb'))!!}
                        @if($errors->has('bsb'))
                            {!! $errors->first('bsb', '<label class="control-label"
                                                                  for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>
            </div>
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop
