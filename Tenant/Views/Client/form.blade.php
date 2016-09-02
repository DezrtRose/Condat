<div class="box-body">
    <div class="col-md-6">
        <div class="">

            <div class="">
                <div class="form-group @if($errors->has('first_name')) {{'has-error'}} @endif">
                    {!!Form::label('first_name', 'First Name *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('first_name', null, array('class' => 'form-control', 'id'=>'first_name'))!!}
                        @if($errors->has('first_name'))
                            {!! $errors->first('first_name', '<label class="control-label"
                                                                     for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('middle_name')) {{'has-error'}} @endif">
                    {!!Form::label('middle_name', 'Middle Name', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('middle_name', null, array('class' => 'form-control', 'id'=>'middle_name'))!!}
                        @if($errors->has('middle_name'))
                            {!! $errors->first('middle_name', '<label class="control-label"
                                                                      for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('last_name')) {{'has-error'}} @endif">
                    {!!Form::label('last_name', 'Last Name *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('last_name', null, array('class' => 'form-control', 'id'=>'last_name'))!!}
                        @if($errors->has('last_name'))
                            {!! $errors->first('last_name', '<label class="control-label"
                                                                    for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('sex', 'Sex *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <label>
                            {!!Form::radio('sex', 'Male', true, array('class' => 'iCheck', 'checked'=>'checked'))!!} Male
                        </label>
                        <label>
                            {!!Form::radio('sex', 'Female', array('class' => 'iCheck'))!!} Female
                        </label>
                    </div>
                </div>

                <div class="form-group @if($errors->has('dob')) {{'has-error'}} @endif">
                    {!!Form::label('dob', 'DOB', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            {!!Form::text('dob', null, array('class' => 'form-control', 'id'=>'dob'))!!}
                        </div>
                        @if($errors->has('dob'))
                            {!! $errors->first('dob', '<label class="control-label"
                                                              for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('passport_no')) {{'has-error'}} @endif">
                    {!!Form::label('passport_no', 'Passport No.', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('passport_no', null, array('class' => 'form-control', 'id'=>'passport_no'))!!}
                        @if($errors->has('passport_no'))
                            {!! $errors->first('passport_no', '<label class="control-label"
                                                                   for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('number')) {{'has-error'}} @endif">
                    {!!Form::label('number', 'Phone Number *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                            {!!Form::text('number', null, array('class' => 'form-control', 'id'=>'phone'))!!}
                        </div>
                        @if($errors->has('number'))
                            {!! $errors->first('number', '<label class="control-label"
                                                                   for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('email')) {{'has-error'}} @endif">
                    {!!Form::label('email', 'Email Address', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::email('email', null, array('class' => 'form-control', 'id'=>'email'))!!}
                        @if($errors->has('email'))
                            {!! $errors->first('email', '<label class="control-label"
                                                                   for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('referred_by')) {{'has-error'}} @endif">
                    {!!Form::label('referred_by', 'Referred By', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('referred_by', null, array('class' => 'form-control', 'id'=>'referred_by'))!!}
                        @if($errors->has('email'))
                            {!! $errors->first('referred_by', '<label class="control-label"
                                                                   for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        {{--Adresses--}}
        <div class="">
            Address Details
            <!-- /.box-header -->
            <div class="">
                <div class="form-group @if($errors->has('street')) {{'has-error'}} @endif">
                    {!!Form::label('street', 'Street', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('street', null, array('class' => 'form-control', 'id'=>'street'))!!}
                        @if($errors->has('street'))
                            {!! $errors->first('street', '<label class="control-label"
                                                                for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                </div>
                <div class="form-group @if($errors->has('suburb')) {{'has-error'}} @endif">
                    {!!Form::label('suburb', 'Suburb', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('suburb', null, array('class' => 'form-control', 'id'=>'suburb'))!!}
                        @if($errors->has('suburb'))
                            {!! $errors->first('suburb', '<label class="control-label"
                                                                 for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                </div>
                <div class="form-group @if($errors->has('state')) {{'has-error'}} @endif">
                    {!!Form::label('state', 'State', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('state', null, array('class' => 'form-control', 'id'=>'state'))!!}
                        @if($errors->has('state'))
                            {!! $errors->first('state', '<label class="control-label"
                                                                for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                </div>
                <div class="form-group @if($errors->has('postcode')) {{'has-error'}} @endif">
                    {!!Form::label('postcode', 'Postcode', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('postcode', null, array('class' => 'form-control', 'id'=>'postcode'))!!}
                        @if($errors->has('postcode'))
                            {!! $errors->first('postcode', '<label class="control-label"
                                                                   for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('country_id')) {{'has-error'}} @endif">
                    {!!Form::label('country_id', 'Country', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::select('country_id', $countries, 263, array('class' =>
                        'form-control'))!!}
                        @if($errors->has('country_id'))
                            {!! $errors->first('country_id', '<label class="control-label"
                                                                  for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('description')) {{'has-error'}} @endif">
                    {!!Form::label('description', 'Description', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::textarea('description', null, array('class' => 'form-control', 'id'=>'description'))!!}
                        @if($errors->has('description'))
                            {!! $errors->first('description', '<label class="control-label"
                                                                  for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
</div>

<script>
    $(function(){
        $('input').iCheck({
            radioClass: 'iradio_minimal-blue'
        });
        $("[data-mask]").inputmask();

        var date = new Date();
        $("#dob").datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy',
            endDate: date
        });
    });
</script>