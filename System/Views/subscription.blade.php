@extends('layouts.main')
@section('title', 'Subscription Fee Settings')
@section('heading', 'Subscription Fee Settings')
@section('breadcrumb')
    @parent
    <li><a href="{{url('settings')}}" title="Settings"><i class="fa fa-cog"></i> Settings</a></li>
    <li>Subscription Fee</li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')
        @if($errors->has())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Basic Subscription</h3>
            </div>
            <!-- /.box-header -->
            {!!Form::model($basic, array('class' => 'form-horizontal'))!!}
            {!!Form::hidden('name', 'basic')!!}
            <div class="box-body">
                <div class="form-group">
                    <div class="col-sm-5 text-right"><strong>Subscription Type</strong></div>
                    <div class="col-sm-7">Basic</div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5 text-right"><strong>Duration</strong></div>
                    <div class="col-sm-7">1 Year</div>
                </div>
                <div class="form-group">
                    {!!Form::label('basic_amount', 'Amount *', array('class' => 'col-sm-5 control-label')) !!}
                    <div class="col-sm-7">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('basic_amount', $basic->amount, array('class' => 'form-control', 'id'=>'amount'))!!}
                            <span class="input-group-addon">.00</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            {!!Form::close()!!}

        </div>
    </div>

    <div class="col-md-4">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Standard Subscription</h3>
            </div>
            <!-- /.box-header -->
            {!!Form::model($standard, array('class' => 'form-horizontal'))!!}
            {!!Form::hidden('name', 'standard')!!}
            <div class="box-body">
                <div class="form-group">
                    <div class="col-sm-5 text-right"><strong>Subscription Type</strong></div>
                    <div class="col-sm-7">Standard</div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5 text-right"><strong>Duration</strong></div>
                    <div class="col-sm-7">1 Year</div>
                </div>
                <div class="form-group">
                    {!!Form::label('standard_amount', 'Amount *', array('class' => 'col-sm-5 control-label')) !!}
                    <div class="col-sm-7">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('standard_amount', $standard->amount, array('class' => 'form-control', 'id'=>'amount'))!!}
                            <span class="input-group-addon">.00</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            {!!Form::close()!!}

        </div>
    </div>

    <div class="col-md-4">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Premium Subscription</h3>
            </div>
            <!-- /.box-header -->
            {!!Form::model($premium, array('class' => 'form-horizontal'))!!}
            {!!Form::hidden('name', 'premium')!!}
            <div class="box-body">
                <div class="form-group">
                    <div class="col-sm-5 text-right"><strong>Subscription Type</strong></div>
                    <div class="col-sm-7">Premium</div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5 text-right"><strong>Duration</strong></div>
                    <div class="col-sm-7">1 Year</div>
                </div>
                <div class="form-group">
                    {!!Form::label('premium_amount', 'Amount *', array('class' => 'col-sm-5 control-label')) !!}
                    <div class="col-sm-7">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('premium_amount', $premium->amount, array('class' => 'form-control', 'id'=>'amount'))!!}
                            <span class="input-group-addon">.00</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            {!!Form::close()!!}

        </div>
    </div>

@stop