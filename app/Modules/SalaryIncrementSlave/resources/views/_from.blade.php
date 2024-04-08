
<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Designation<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('designation_id', $designations, $value = null, array('id'=>'designation_id', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('designation_id'))<span class="required">{{ $errors->first('designation_id') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Basic Salary<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('basic_salary', $value = null, array('id'=>'basic_salary', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('basic_salary'))<span class="required">{{ $errors->first('basic_salary') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Increment Amount<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('increment_amount', $value = null, array('id'=>'increment_amount', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('increment_amount'))<span class="required">{{ $errors->first('increment_amount') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Increment Slab No.<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('inc_slave_no', $value = null, array('id'=>'inc_slave_no', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('inc_slave_no'))<span class="required">{{ $errors->first('inc_slave_no') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/salary-increment-slave') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>