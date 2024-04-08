<div class="form-body">
	

	<div class="form-group">
		<label class="col-md-4 control-label">Branch Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('branch_id', $branchList, $value = null, array('id'=>'branch_id', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('branch_id'))<span class="required">{{ $errors->first('branch_id') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Division Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('division_id', $divisionList, $value = null, array('id'=>'division_id', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('division_id'))<span class="required">{{ $errors->first('division_id') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Department Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('department_id', $departmentList, $value = null, array('id'=>'department_id', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('department_id'))<span class="required">{{ $errors->first('department_id') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Unit Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('unit_name', $value = null, array('id'=>'unit_name', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('unit_name'))<span class="required">{{ $errors->first('unit_name') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Status<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('status', $status, $value = null, array('id'=>'status', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('status'))<span class="required">{{ $errors->first('status') }}</span>@endif
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/department-unit') }}" class="btn btn-success">Back</a>
		</div>
	</div>
</div>