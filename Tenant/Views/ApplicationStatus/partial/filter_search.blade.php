<section class="margin-to-down">
	{!! Form::open(['class'=>'form-inline']) !!}
		<div class="form-group">
		  {!! Form::label('filter_id', 'Filter By:') !!}
		  <select name="filter_id", class="form-control">
		      <option value="1">College Name</option>
		      <option value="2">Course Name</option>
		      <option value="3">Email</option>
		      <option value="4">Phone</option>
		  </select>
		</div>
	{!! Form::close() !!}
</section>
