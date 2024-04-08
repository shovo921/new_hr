<div class="form-body">
	

	<div class="form-group">
		<label class="col-md-4 control-label">Branch Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('br_id', $branchList, $value = null, array('id'=>'br_id', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('br_id'))<span class="required">{{ $errors->first('br_id') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Division Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('div_id', $divisionList, $value = null, array('id'=>'div_id', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('div_id'))<span class="required">{{ $errors->first('div_id') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Department Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('dept_name', $value = null, array('id'=>'dept_name', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('dept_name'))<span class="required">{{ $errors->first('dept_name') }}</span>@endif
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Department Details<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('dept_details', $value = null, array('id'=>'dept_details', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('dept_details'))<span class="required">{{ $errors->first('dept_details') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Status<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('dept_status', $status, $value = null, array('id'=>'dept_status', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('dept_status'))<span class="required">{{ $errors->first('dept_status') }}</span>@endif
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/br-department') }}" class="btn btn-success">Back</a>
		</div>
	</div>
</div>