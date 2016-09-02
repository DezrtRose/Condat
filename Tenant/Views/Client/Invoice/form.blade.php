<div class="box-body">
    <div class="col-md-6">

        <div class="form-group">
            {!!Form::label('application_id', 'Application *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                {!!Form::select('application_id', $applications, null, array('class' => 'form-control', 'id'=>'application_id'))!!}
            </div>
        </div>

        <div class="form-group @if($errors->has('invoice_date')) {{'has-error'}} @endif">
            {!!Form::label('invoice_date', 'Invoice Date *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    @if(!isset($invoice) || $invoice->invoice_date == null)
                        {!!Form::text('invoice_date', null, array('class' => 'form-control', 'id'=>'invoice_date'))!!}
                    @else
                        {!!Form::text('invoice_date', format_date($invoice->invoice_date), array('class' => 'form-control', 'id'=>'invoice_date'))!!}
                    @endif
                </div>
                @if($errors->has('invoice_date'))
                    {!! $errors->first('invoice_date', '<label class="control-label"
                                                      for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('amount')) {{'has-error'}} @endif">
            {!!Form::label('amount', 'Amount *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    {!!Form::text('amount', null, array('class' => 'form-control', 'id'=>'amount','autocomplete'=>'off'))!!}
                </div>
                @if($errors->has('amount'))
                    {!! $errors->first('amount', '<label class="control-label"
                                                             for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('discount')) {{'has-error'}} @endif">
            {!!Form::label('discount', 'Discount *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    {!!Form::text('discount', 0, array('class' => 'form-control', 'id'=>'discount','autocomplete'=>'off'))!!}
                </div>
                @if($errors->has('discount'))
                    {!! $errors->first('discount', '<label class="control-label"
                                                              for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('invoice_amount')) {{'has-error'}} @endif">
            {!!Form::label('invoice_amount', 'Invoice Amount *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    {!!Form::text('invoice_amount', null, array('class' => 'form-control', 'id'=>'invoice_amount','autocomplete'=>'off'))!!}
                </div>
                @if($errors->has('invoice_amount'))
                    {!! $errors->first('invoice_amount', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('total_gst')) {{'has-error'}} @endif">
            {!!Form::label('total_gst', 'GST *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    {!!Form::text('total_gst', null, array('class' => 'form-control', 'id'=>'gst','placeholder'=>'10% of Amount ','readonly' => 'true'))!!}
                    <span class="input-group-addon">
                               {{ Form::checkbox('gst_checker_incentive', 'incentive', false,array('id'=>'gst_checker_incentive')) }} GST
                            </span>
                </div>
                @if($errors->has('total_gst'))
                    {!! $errors->first('total_gst', '<label class="control-label"
                                                             for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('final_total')) {{'has-error'}} @endif">
            {!!Form::label('final_total', 'Final Total *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    {!!Form::text('final_total', null, array('class' => 'form-control', 'id'=>'final_total','readonly' => 'true'))!!}
                </div>
                @if($errors->has('final_total'))
                    {!! $errors->first('final_total', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
                @endif
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

        <div class="form-group @if($errors->has('due_date')) {{'has-error'}} @endif">
            {!!Form::label('due_date', 'Due Date *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    @if(!isset($invoice) || $invoice->due_date == null)
                        {!!Form::text('due_date', null, array('class' => 'form-control', 'id'=>'due_date'))!!}
                    @else
                        {!!Form::text('due_date', format_date($invoice->due_date), array('class' => 'form-control', 'id'=>'due_date'))!!}
                    @endif
                </div>
                @if($errors->has('due_date'))
                    {!! $errors->first('due_date', '<label class="control-label"
                                                      for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>


    </div>
</div>


<script>

    $('#amount, #invoice_amount,#discount').keyup(function () {
        var amount = parseFloat($('#amount').val());
        var discount = parseFloat($('#discount').val());
        var invoice_amount = amount - discount;
        if ($('#gst_checker_tuition_fee').is(":checked")) // "this" refers to the element that fired the event
        {
            var gst = invoice_amount / 10;

        }
        else {
            gst = 0;

        }

        $('#invoice_amount').val(invoice_amount.toFixed(2));
        $('#gst').val(gst);

        final_total = invoice_amount + gst;
        $('#final_total').val(final_total.toFixed(2));

    });

    $('#gst_checker_incentive').click(function () {
        if ($(this).is(":checked")) // "this" refers to the element that fired the event
        {
            $('#gst').val(parseFloat($('#invoice_amount').val() / 10));
        }
        else {
            $('#gst').val(0);

        }
        gst_change();

    });

    function gst_change() {

        var invoice_amount = parseFloat($('#invoice_amount').val());
        var gst = parseFloat($('#gst').val()); //10% of commission amount
        $('#gst').val(gst.toFixed(2));
        final_total = invoice_amount + gst;
        $('#final_total').val(final_total.toFixed(2));
    }

    $(function () {
        $("#invoice_date").datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $("#due_date").datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });
    });
</script>