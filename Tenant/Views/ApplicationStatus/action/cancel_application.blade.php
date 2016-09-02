@extends('layouts.tenant')
@section('title', 'Application Enquiry')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Notes</li>
@stop

@section('content')
    <div class="container">
		<div class="row">
			<div class="col-md-12">
				@if(count($errors)>0)
					<div class="alert alert-waring">
						<ul>
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
						</ul>
					</div>
				@endif
				<h1 class="margin-down">{{ $applications->first_name}} - <small>Cancel Application</small></h1>
				
				 @include('Tenant::ApplicationStatus/partial/navbar')
				
				<div class="box box-primary">
					<div class="box-body">
						{!! Form::open([
									'class'=>'form-horizontal',
									'route'=>['applications.cancel', $applications->course_application_id]
						])!!}	
						
							<div class="form-group">
								{{ Form::label('institute_name', 'Institute Name',['class'=>'col-md-3 form-label text-right'])}}
								<div class="col-md-9">
									{{ $applications->company }}	
								</div>
							</div>

							<div class="form-group">
								{{ Form::label('course_name', 'Course Name',['class'=>'col-md-3 form-label text-right'])}}
								<div class="col-md-9">
								{{ $applications->name }}	
								</div>
							</div>

							<div class="form-group">
								{{ Form::label('notes', 'Notes', ['class'=>'col-md-3 form-label text-right'])}}
								<div class="col-md-9">
								{{ Form::textarea('notes', '', ['class'=>'col-md-6','rows'=>5])}}	
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-9 col-md-offset-3">
								{{ Form::submit('Cancel',['class'=>'btn btn-primary'])}}
								</div>
							</div>

						{!! Form::close()!!}
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
					 




