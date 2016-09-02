<div class="form-group">
    {!!Form::label('first_name', 'First Name *', array('class' => 'col-sm-4 control-label')) !!}
    <div class="col-sm-8">
        {!!Form::text('first_name', null, array('class' => 'form-control', 'id'=>'first_name'))!!}
    </div>
</div>

<div class="form-group">
    {!!Form::label('middle_name', 'Middle Name', array('class' => 'col-sm-4 control-label')) !!}
    <div class="col-sm-8">
        {!!Form::text('middle_name', null, array('class' => 'form-control', 'id'=>'middle_name'))!!}
    </div>
</div>

<div class="form-group">
    {!!Form::label('last_name', 'Last Name *', array('class' => 'col-sm-4 control-label')) !!}
    <div class="col-sm-8">
        {!!Form::text('last_name', null, array('class' => 'form-control', 'id'=>'last_name'))!!}
    </div>
</div>

<div class="form-group">
    {!!Form::label('sex', 'Sex *', array('class' => 'col-sm-4 control-label')) !!}
    <div class="col-sm-8">
        <label>
            {!!Form::radio('sex', 'Male', true, array('class' => 'iCheck', 'checked'=>'checked'))!!}
            Male
        </label>
        <label>
            {!!Form::radio('sex', 'Female', array('class' => 'iCheck'))!!} Female
        </label>
    </div>
</div>

<div class="form-group">
    {!!Form::label('position', 'Position *', array('class' => 'col-sm-4 control-label')) !!}
    <div class="col-sm-8">
        {!!Form::text('position', null, array('class' => 'form-control', 'id'=>'position'))!!}
    </div>
</div>

<div class="form-group">
    {!!Form::label('number', 'Phone Number *', array('class' => 'col-sm-4 control-label')) !!}
    <div class="col-sm-8">
        {!!Form::text('number', null, array('class' => 'form-control phone-input', 'id'=>'number'))!!}
    </div>
</div>

<div class="form-group">
    {!!Form::label('email', 'Email Address *', array('class' => 'col-sm-4 control-label')) !!}
    <div class="col-sm-8">
        {!!Form::email('email', null, array('class' => 'form-control', 'id'=>'email'))!!}
    </div>
</div>

</div>