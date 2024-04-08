<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Employee ID <span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('employee_id', $value=null, array('id'=>'employee_id', 'class' => 'form-control', 'readonly'=>"readonly")) !!}
		</div>
	</div>


	<div class="form-group">
		<label class="col-md-4 control-label">Leave Type <span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('leave_type', $employeeLeave->leaveType->leave_type, array('id'=>'leave_type', 'class' => 'form-control', 'required'=>"", 'readonly'=>"readonly")) !!}
			<input type="hidden" name="LEAVE_TYPE_ID" value="{{ $employeeLeave->leave_type_id }}">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Leave Balance <span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('leave_balance', $value=null, array('id'=>'leave_balance', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('leave_balance'))<span class="required">{{ $errors->first('leave_balance') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Leave Taken <span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('leave_taken', $value=null, array('id'=>'leave_taken', 'class' => 'form-control','required'=>"")) !!}
			@if($errors->has('leave_taken'))<span class="required">{{ $errors->first('leave_taken') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
	<label class="col-md-4 control-label">Current Balance <span class="required">*</span></label>
	<div class="col-md-8">
		{!! Form::text('last_forwarded_leave', $value=null, array('id'=>'last_forwarded_leave', 'class' => 'form-control', 'required'=>"")) !!}
		@if($errors->has('last_forwarded_leave'))<span class="required">{{ $errors->first('last_forwarded_leave') }}</span>@endif
	</div>
</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Future Apply<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('future_apply',$future, $value = null, array('id'=>'future_apply', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('future_apply'))<span class="required">{{ $errors->first('future_apply') }}</span>@endif
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Update', array('class' => "btn btn-primary")) !!} &nbsp;
{{--			<a href="{{  url('/leave') }}" class="btn btn-success">Back</a>--}}
			<a href="{{  url('view-employee-leave/'.$employeeLeave->employee_id) }}" class="btn btn-success">Back</a>
		</div>
	</div>
</div>