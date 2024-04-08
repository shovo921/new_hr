<div class="form-body">

	<div class="form-group">
		<label class="col-md-4 control-label">Leave Type <span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('leave_type', $value=null, array('id'=>'leave_type', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('leave_type'))<span class="required">{{ $errors->first('leave_type') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Eligibility<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('eligibility_id', $leaveEligibilities, $value = null, array('id'=>'eligibility_id', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('eligibility_id'))<span class="required">{{ $errors->first('eligibility_id') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Total Leave Per Year <span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('total_leave_per_year', $value = null, array('id'=>'total_leave_per_year', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('total_leave_per_year'))<span class="required">{{ $errors->first('total_leave_per_year') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Max Taken at a Time <span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('max_taken_at_a_time', $value = null, array('id'=>'max_taken_at_a_time', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('max_taken_at_a_time'))<span class="required">{{ $errors->first('max_taken_at_a_time') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Carried Forward? <span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('carried_forward_status', @$forwardStatus, $value = null, array('id'=>'carried_forward_status', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('carried_forward_status'))<span class="required">{{ $errors->first('carried_forward_status') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Max Carried Forward</label>
		<div class="col-md-8">
			{!! Form::text('max_carried_forward', $value = null, array('id'=>'max_carried_forward', 'class' => 'form-control')) !!}
			@if($errors->has('max_carried_forward'))<span class="required">{{ $errors->first('max_carried_forward') }}</span>@endif
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/leave-type') }}" class="btn btn-success">Back</a>
		</div>
	</div>
</div>