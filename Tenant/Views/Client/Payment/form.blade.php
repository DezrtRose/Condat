<div class="box-body">
    <div class="col-md-12">

        <div class="form-group @if($errors->has('date_paid')) {{'has-error'}} @endif">
            {!!Form::label('date_paid', 'Payment Date *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    {!!Form::text('date_paid', null, array('class' => 'form-control', 'id'=>'date_paid'))!!}
                </div>
                @if($errors->has('date_paid'))
                    {!! $errors->first('date_paid', '<label class="control-label"
                                                      for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('amount')) {{'has-error'}} @endif">
            {!!Form::label('amount', 'Amount *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                {!!Form::text('amount', null, array('class' => 'form-control', 'id'=>'amount'))!!}
                @if($errors->has('amount'))
                    {!! $errors->first('amount', '<label class="control-label"
                                                             for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('payment_method')) {{'has-error'}} @endif">
            {!!Form::label('payment_method', 'Payment Method *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                {!!Form::text('payment_method', null, array('class' => 'form-control', 'id'=>'payment_method'))!!}
                @if($errors->has('payment_method'))
                    {!! $errors->first('payment_method', '<label class="control-label"
                                                              for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>

        <div class="form-group">
            {!!Form::label('payment_type', 'Payment Type *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                {!!Form::select('payment_type', config('constants.payment_by'), null, array('class' => 'form-control', 'id'=>'payment_type'))!!}
            </div>
        </div>

        <div class="form-group @if($errors->has('description')) {{'has-error'}} @endif">
            {!!Form::label('description', 'Description', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                {!!Form::textarea('description', null, array('class' => 'form-control', 'id'=>'description'))!!}
                @if($errors->has('description'))
                    {!! $errors->first('description', '<label class="control-label"
                                                            for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>


    </div>
</div>


<script>
    $(function () {
        $('input').iCheck({
            radioClass: 'iradio_minimal-blue'
        });
        $("[data-mask]").inputmask();

        var date = new Date();
        $("#date_paid").datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy',
            endDate: date
        });
    });
</script>