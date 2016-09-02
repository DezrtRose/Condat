<div class="box-body">
    <div class="col-md-12">
        <div class="">
            <div class="form-group @if($errors->has('name')) {{'has-error'}} @endif">
                {!!Form::label('name', 'Course Name *', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-8">
                    {!!Form::text('name', null, array('class' => 'form-control', 'id'=>'name'))!!}
                    @if($errors->has('name'))
                        {!! $errors->first('name', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
                    @endif
                </div>
            </div>

            <div class="form-group @if($errors->has('level')) {{'has-error'}} @endif">
                {!!Form::label('level', 'Level *', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-8">
                    {!!Form::text('level', null, array('class' => 'form-control'))!!}
                </div>
            </div>

            <div class="form-group @if($errors->has('total_tuition_fee')) {{'has-error'}} @endif">
                {!!Form::label('total_tuition_fee', 'Tuition Fee *', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-8">
                    <div class="input-group" id="total_tuition_fee">
                        <span class="input-group-addon">$</span>
                        {!!Form::text('total_tuition_fee', null, array('class' => 'form-control'))!!}
                        <span class="input-group-addon">.00</span>
                    </div>
                    @if($errors->has('total_tuition_fee'))
                        {!! $errors->first('total_tuition_fee', '<label class="control-label"
                                                                        for="inputError">:message</label>') !!}
                    @endif
                </div>
            </div>

            <div class="form-group @if($errors->has('coe_fee')) {{'has-error'}} @endif">
                {!!Form::label('coe_fee', 'COE Issue Field*', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-8">
                    <div class="input-group" id="coe_fee">
                        <span class="input-group-addon">$</span>
                        {!!Form::text('coe_fee', null, array('class' => 'form-control'))!!}
                        <span class="input-group-addon">.00</span>
                    </div>
                    @if($errors->has('coe_fee'))
                        {!! $errors->first('coe_fee', '<label class="control-label"
                                                              for="inputError">:message</label>') !!}
                    @endif
                </div>
            </div>

            <div class="form-group @if($errors->has('commission_percent')) {{'has-error'}} @endif">
                {!!Form::label('commission_percent', 'Commission Percent', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-8">
                    <div class="input-group">
                        <?php if(!isset($commission_percent)) $commission_percent = null; ?>
                        {!!Form::text('commission_percent', $commission_percent, array('class' => 'form-control', 'id'=>'commission_percent'))!!}
                        <span class="input-group-addon">%</span>
                    </div>
                    @if($errors->has('commission_percent'))
                        {!! $errors->first('commission_percent', '<label class="control-label"
                                                              for="inputError">:message</label>') !!}
                    @endif
                </div>
            </div>

            <div class="form-group @if($errors->has('broad_field')) {{'has-error'}} @endif">
                {!!Form::label('broad_field', 'Broad Field*', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-8">
                    {!!Form::select('broad_field', $broad_fields, null, array('class' => 'form-control', 'id'=>'broad_field'))!!}
                </div>
            </div>

            <div class="form-group @if($errors->has('narrow_field')) {{'has-error'}} @endif">
                {!!Form::label('narrow_field', 'Narrow Field*', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-8">
                    {!!Form::select('narrow_field', $narrow_fields, null, array('class' => 'form-control', 'id'=>'narrow_field'))!!}
                </div>
            </div>


            <div class="form-group @if($errors->has('description')) {{'has-error'}} @endif">
                {!!Form::label('description', 'Description', array('class' => 'col-sm-3 control-label')) !!}
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
</div>

<script type="text/javascript">
    $("#broad_field").change(function() {
        var broad_field = $(this).val();
        $.ajax({url: appUrl + "/tenant/narrowfield/" + broad_field,
            success: function(result){
                $("#narrow_field").html("tenant/narrowfield/" + result.data.options);
            }});
    });
</script>