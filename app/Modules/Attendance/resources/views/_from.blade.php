

<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Employee<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('employee_id', $employeeList, $value = null, array('id'=>'employee_id', 'class' => 'form-control select2', 'required'=>"")) !!}

			@if($errors->has('employee_id'))<span class="required">{{ $errors->first('employee_id') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Remarks<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::textarea('remarks', $value = null, array('id'=>'remarks', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('remarks'))<span class="required">{{ $errors->first('remarks') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Attendance Date<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('attendance_date', $value = null, array('id'=>'attendance_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker')) !!}
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">In Time</label>
		<div class="col-md-2">
			{!! Form::time('in_time', $value = null, array('id'=>'in_time', 'placeholder'=>'hh:min:sec', 'class' => 'form-control')) !!}
			{{--<input type="time" class="form-control"  id="in_time" name="in_time">--}}
			{{--{!! Form::text('in_time', $value = null, array('id'=>'in_time', 'placeholder'=>'hh:min:sec', 'class' => 'form-control timepicker-no-seconds')) !!}--}}
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Out Time</label>
		<div class="col-md-2">
			<input type="time" class="form-control" id="out_time" name="out_time">
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/attendance') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>
