<div class="box-body">

    <div class="form-group @if($errors->has('username')) {{'has-error'}} @endif">
        {!!Form::label('username', 'Username *', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
            {!!Form::text('username', null, array('class' => 'form-control', 'id'=>'username'))!!}
            @if($errors->has('username'))
                {!! $errors->first('username', '<label class="control-label"
                                                       for="inputError">:message</label>') !!}
            @endif
        </div>
    </div>
    <div class="form-group @if($errors->has('title')) {{'has-error'}} @endif">
        {!!Form::label('title', 'Title', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
            {!!Form::select('title', config('constants.title'), null, array('class' => 'form-control'))!!}
        </div>

    </div>
    <div class="form-group @if($errors->has('given_name')) {{'has-error'}} @endif">
        {!!Form::label('given_name', 'Given Name *', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
            {!!Form::text('given_name', null, array('class' => 'form-control', 'id'=>'given_name'))!!}
            @if($errors->has('given_name'))
                {!! $errors->first('given_name', '<label class="control-label"
                                                         for="inputError">:message</label>') !!}
            @endif
        </div>
    </div>
    <div class="form-group @if($errors->has('surname')) {{'has-error'}} @endif">
        {!!Form::label('surname', 'Surname *', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
            {!!Form::text('surname', null, array('class' => 'form-control', 'id'=>'surname'))!!}
            @if($errors->has('surname'))
                {!! $errors->first('surname', '<label class="control-label"
                                                      for="inputError">:message</label>') !!}
            @endif
        </div>
    </div>

    @if($current_user->role == 1)
        <div class="form-group">
            {!!Form::label('role', 'User Role', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!!Form::select('role', config('constants.user_role'), null, array('class' => 'form-control'))!!}
            </div>
        </div>
    @endif

    <div class="form-group @if($errors->has('email')) {{'has-error'}} @endif">
        {!!Form::label('email', 'Email Address *', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
            {!!Form::text('email', null, array('class' => 'form-control', 'id'=>'email'))!!}
            @if($errors->has('email'))
                {!! $errors->first('email', '<label class="control-label"
                                                    for="inputError">:message</label>') !!}
            @endif
        </div>
    </div>
</div>