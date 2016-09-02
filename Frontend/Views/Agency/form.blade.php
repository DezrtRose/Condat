<div class="box-body">
    <div class="col-md-6">
        <div class="">
            Agency Details

            <div class="">
                <div class="form-group @if($errors->has('name')) {{'has-error'}} @endif">
                    {!!Form::label('name', 'Company Name *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('name', null, array('class' => 'form-control', 'id'=>'name'))!!}
                        @if($errors->has('name'))
                            {!! $errors->first('name', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                {{--<div class="form-group">
                    {!!Form::label('company_database_name', 'Domain Name ', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <span class="domain-suggestion"></span>
                    </div>
                </div>--}}

                <div class="form-group @if($errors->has('abn')) {{'has-error'}} @endif">
                    {!!Form::label('abn', 'ABN *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('abn', null, array('class' => 'form-control', 'id'=>'abn'))!!}
                        @if($errors->has('abn'))
                            {!! $errors->first('abn', '<label class="control-label"
                                                              for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('email_id')) {{'has-error'}} @endif">
                    {!!Form::label('email_id', 'Email Address *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('email_id', null, array('class' => 'form-control', 'id'=>'email_id'))!!}
                        @if($errors->has('email_id'))
                            {!! $errors->first('email_id', '<label class="control-label"
                                                                   for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('phone')) {{'has-error'}} @endif">
                    {!!Form::label('phone', 'Phone *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('phone', null, array('class' => 'form-control', 'id'=>'phone'))!!}
                        @if($errors->has('phone'))
                            {!! $errors->first('phone', '<label class="control-label"
                                                                for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('acn')) {{'has-error'}} @endif">
                    {!!Form::label('acn', 'ACN', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('acn', null, array('class' => 'form-control', 'id'=>'acn'))!!}
                        @if($errors->has('acn'))
                            {!! $errors->first('acn', '<label class="control-label"
                                                              for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('website')) {{'has-error'}} @endif">
                    {!!Form::label('website', 'Website', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('website', null, array('class' => 'form-control', 'id'=>'website'))!!}
                        @if($errors->has('website'))
                            {!! $errors->first('website', '<label class="control-label"
                                                                  for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('invoice_to_name')) {{'has-error'}} @endif">
                    {!!Form::label('invoice_to_name', 'Invoice To', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('invoice_to_name', null, array('class' => 'form-control',
                        'id'=>'invoice_to_name'))!!}
                        @if($errors->has('invoice_to_name'))
                            {!! $errors->first('invoice_to_name', '<label class="control-label"
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

                <div class="form-group @if($errors->has('recaptcha')) {{'has-error'}} @endif">
                    {!!Form::label('recaptcha', 'Recaptcha *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Recaptcha::render() !!}
                        @if($errors->has('email'))
                            {!! $errors->first('recaptcha', '<label class="control-label"
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
                <div class="form-group @if($errors->has('line1')) {{'has-error'}} @endif">
                    {!!Form::label('line1', 'Line 1', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('line1', null, array('class' => 'form-control', 'id'=>'line1'))!!}
                        @if($errors->has('line1'))
                            {!! $errors->first('line1', '<label class="control-label"
                                                                for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                </div>
                <div class="form-group @if($errors->has('line2')) {{'has-error'}} @endif">
                    {!!Form::label('line2', 'Line 2', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('line2', null, array('class' => 'form-control', 'id'=>'line2'))!!}
                        @if($errors->has('line2'))
                            {!! $errors->first('line2', '<label class="control-label"
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

                <div class="form-group @if($errors->has('country')) {{'has-error'}} @endif">
                    {!!Form::label('country', 'Country', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::select('country', config('constants.countries'), null, array('class' =>
                        'form-control'))!!}
                        @if($errors->has('country'))
                            {!! $errors->first('country', '<label class="control-label"
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

<?php Condat::js("registration.js"); ?>