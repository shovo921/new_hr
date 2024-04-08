<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Employee Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('employee_id', $employeeList, $value = null, array('id'=>'employee_id', 'class' => 'form-control select2', 'required'=>"", 'placeholder'=>'Select a Employee')) !!}
			@if($errors->has('employee_id'))<span class="required">{{ $errors->first('employee_id') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Referer Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('ref_name', $value = null, array('id'=>'ref_name', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('ref_name'))<span class="required">{{ $errors->first('ref_name') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Designation<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('designation', $value = null, array('id'=>'designation', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('designation'))<span class="required">{{ $errors->first('designation') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Organization</label>
		<div class="col-md-8">
			{!! Form::text('organization', $value = null, array('id'=>'organization', 'class' => 'form-control')) !!}
			@if($errors->has('organization'))<span class="required">{{ $errors->first('organization') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Mobile No</label>
		<div class="col-md-8">
			{!! Form::text('mobile_no', $value = null, array('id'=>'mobile_no', 'class' => 'form-control')) !!}
			@if($errors->has('mobile_no'))<span class="required">{{ $errors->first('mobile_no') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Address</label>
		<div class="col-md-8">
			{!! Form::text('address', $value = null, array('id'=>'address', 'class' => 'form-control')) !!}
			@if($errors->has('address'))<span class="required">{{ $errors->first('address') }}</span>@endif
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/employee-hidden-reference') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>