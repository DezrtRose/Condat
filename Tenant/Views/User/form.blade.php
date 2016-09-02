<div class="box-body">
    <div class="col-md-6">
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

        @if($current_user->role == 1)
            <div class="form-group">
                {!!Form::label('role', 'User Role', array('class' => 'col-sm-4 control-label')) !!}
                <div class="col-sm-8">
                    {!!Form::select('role', config('constants.user_role'), null, array('class' => 'form-control'))!!}
                </div>
            </div>
        @endif

        <div class="form-group @if($errors->has('email')) {{'has-error'}} @endif">
            {!!Form::label('email', 'Email Address *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                {!!Form::text('email', null, array('class' => 'form-control', 'id'=>'email'))!!}
                @if($errors->has('email'))
                    {!! $errors->first('email', '<label class="control-label"
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
                    {!!Form::text('number', null, array('class' => 'form-control phone-input', 'id'=>'phone'))!!}
                </div>
                @if($errors->has('number'))
                    {!! $errors->first('number', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        {{--Adresses--}}
        <!-- /.box-header -->
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
                {!!Form::select('country_id', $countries, null, array('class' =>
                'form-control'))!!}
                @if($errors->has('country_id'))
                    {!! $errors->first('country_id', '<label class="control-label"
                                                          for="inputError">:message</label>')
                    !!}
                @endif
            </div>
        </div>
    </div>
    <!-- /.box -->
</div>

<script>
    $(function(){
        var date = new Date();
        $("#dob").datepicker({
            autoclose: true,
            endDate: date
        });
    });
</script>