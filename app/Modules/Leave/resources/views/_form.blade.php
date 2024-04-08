<div class="form-body">


	<div class="form-group">
		<label class="col-md-4 control-label">Employee ID <span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('employee_id', $postingInfo->employee_id, array('id'=>'employee_id', 'class' => 'form-control', 'required'=>"", 'readonly'=>"readonly")) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Employee Name <span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('employee_name', $postingInfo->employee_name, array('id'=>'employee_name', 'class' => 'form-control', 'required'=>"", 'readonly'=>"readonly")) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Designation <span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('designation', @$postingInfo->designation, array('id'=>'designation', 'class' => 'form-control', 'required'=>"", 'readonly'=>"readonly")) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Branch / Division <span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('branch', @$postingInfo->branch->branch_name, array('id'=>'branch', 'class' => 'form-control', 'required'=>"", 'readonly'=>"readonly")) !!}
		</div>
	</div>

	{{--<div class="form-group">
		<label class="col-md-4 control-label">Division </label>
		<div class="col-md-8">
			{!! Form::text('division', @$postingInfo->division->br_name, array('id'=>'division', 'class' => 'form-control', 'readonly'=>"readonly")) !!}
		</div>
	</div>--}}
	<div class="form-group">
		<label class="col-md-4 control-label">Leave Type<span class="required">*</span></label>
		<div class="col-md-8" style="padding: 0px">
			<div class="col-md-4">
				<label class="control-label">Leave Type<span class="required">*</span></label>
				{{--{!! Form::select('leave_type_id', $leaveTypes, $value = null, array('id'=>'leave_type_id', 'class' => 'form-control', 'required'=>"", 'onchange'=>'checkLeaveConditions(this.value)')) !!}--}}
				{!! Form::select('leave_type_id', $leaveTypes, $value = null, array('id'=>'leave_type_id', 'class' => 'form-control', 'required'=>"", 'onchange'=>'checkLeaveBalance(this.value)')) !!}
			</div>
			<div class="col-md-4">
				<label class="control-label">Current Balance</label>
				{!! Form::text('current_balance', $value = null, array('id'=>'current_balance', 'class' => 'form-control', 'readonly'=>"readonly")) !!}
			</div>
			<div class="col-md-4">
				<label class="control-label">Leave Availed</label>
				{{--{!! Form::text('remaining_balance', $value = null, array('id'=>'remaining_balance', 'class' => 'form-control', 'readonly'=>"readonly")) !!}--}}
				{!! Form::text('leave_taken', $value = null, array('id'=>'leave_taken', 'class' => 'form-control', 'readonly'=>"readonly")) !!}
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Leave Duration <span class="required">*</span></label>
		<div class="col-md-8" style="padding: 0px">
			<?php
			$start_date = null;
			$start_date1 = null;
			$end_date1 = null;
			$end_date = null;
			$next_date = null;

			if(@$leaveApplication->start_date != '')
				$start_date = date('m/d/Y', strtotime($leaveApplication->start_date));

			if(@$leaveApplication->start_date != '')
				$start_date1 = date('m/d/Y', strtotime($leaveApplication->start_date));

			if(@$leaveApplication->end_date != '')
				$end_date = date('m/d/Y', strtotime($leaveApplication->end_date));

			if(@$leaveApplication->end_date != '')
				$end_date1 = date('m/d/Y', strtotime($leaveApplication->end_date));

			if(@$leaveApplication->next_joining_date != '')
				$next_date = date('m/d/Y', strtotime($leaveApplication->next_joining_date));
			?>
			<div id="future1" style="display: none">
				<div class="col-md-4" >
					<label class="control-label">Start Date<span class="required">*</span></label>
					{!! Form::text('start_date1', $value = $start_date1, array('id'=>'start_date1','class' => 'form-control date-picker1', 'placeholder'=>'mm/dd/yyyy', )) !!}
				</div>
				<div class="col-md-4" >
					<label class="control-label">End Date<span class="required">*</span></label>
					{!! Form::text('end_date1', $value = $end_date1, array('id'=>'end_date1', 'placeholder'=>'mm/dd/yyyy','class' => 'form-control date-picker1',   'onchange'=>'calculateTotalDays1()')) !!}
				</div>
			</div>
			<div id="future" >
				<div class="col-md-4" >
					<label class="control-label">Start Date<span class="required">*</span></label>
					{!! Form::text('start_date', $value = $start_date, array('id'=>'start_date','class' => 'form-control date-picker', 'placeholder'=>'mm/dd/yyyy', )) !!}
				</div>
				<div class="col-md-4" >
					<label class="control-label">End Date<span class="required">*</span></label>
					{!! Form::text('end_date', $value = $end_date, array('id'=>'end_date', 'placeholder'=>'mm/dd/yyyy','class' => 'form-control date-picker', 'onchange'=>'calculateTotalDays()')) !!}
				</div>
			</div>


			<div class="col-md-4">
				<label class="control-label">Total day/days<span class="required">*</span></label>
				{!! Form::text('total_days', $value = null, array('id'=>'total_days', 'class' => 'form-control', 'required'=>"",'readonly'=>"readonly")) !!}
				@if($errors->has('total_days'))<span class="required">{{ $errors->first('total_days') }}</span>@endif
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Next Joining Date<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('next_joining_date', $value = $next_date, array('id'=>'next_joining_date', 'placeholder'=>'mm/dd/yyyy', 'class' => 'form-control', 'required'=>"",'readonly'=>"readonly")) !!}

		</div>
	</div>



	<div class="form-group">
		<label class="col-md-4 control-label">Reason of Leave<span class="required">*</span></label>
		<div class="col-md-8">
			{{--{!! Form::text('reason_of_leave', $value = null, array('id'=>'reason_of_leave', 'class' => 'form-control', 'required'=>"")) !!}--}}
			{!! Form::select('reason_of_leave', $leaveReason, $value = null, array('id'=>'reason_of_leave', 'class' => 'form-control select2', 'required'=>"")) !!}
			@if($errors->has('reason_of_leave'))<span class="required">{{ $errors->first('reason_of_leave') }}</span>@endif
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Leave Attachment</label>
		<div class="col-md-8">
			{!! Form::file(str_replace(" ", "_",'attachment'), $value = null, array('id'=>'attachment','class' => 'form-control')) !!}
			<a href="{{ asset('uploads/employeedata/' . ($leaveApplication->employee_id ?? '') . '/leave/'.($leaveApplication->leaveAttachment->attachment ?? '') ) }}" target="_blank"><i class="fa fa-eye">View File</i></a>
			@if($errors->has('attachment'))<span>{{ $errors->first('attachment') }}</span>@endif
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Leave Location<span class="required">*</span></label>
		<div class="col-md-8" style="padding: 0px">
			<div class="col-md-4">
				<label class="control-label">Leave Location<span class="required">*</span></label>
				{!! Form::select('leave_location', $leaveLocation, $value =null, array('id'=>'leave_location', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
			<div class="col-md-4" id='country_name'>
				<label class="control-label">Name of Country<span class="required">*</span></label>
				{!! Form::text('country_name', $value = null, array('id'=>'country_name', 'class' => 'form-control')) !!}
			</div>
			<div class="col-md-4" id='passport_no'>
				<label class="control-label">Passport No<span class="required">*</span></label>
				{!! Form::text('passport_no', $value = null, array('id'=>'passport_no', 'class' => 'form-control')) !!}
			</div>


		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Address & Telephone Number During Leave<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('contact_info_during_leave', $value = null, array('id'=>'contact_info_during_leave', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('contact_info_during_leave'))<span class="required">{{ $errors->first('contact_info_during_leave') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Responsible Person<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('responsible_to', $responsibleUser, $value = null, array('id'=>'responsible_to', 'class' => 'form-control select2', 'required'=>"")) !!}

			@if($errors->has('responsible_to'))<span class="required">{{ $errors->first('responsible_to') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/allApplication') }}" class="btn btn-success">Back</a>
		</div>
	</div>
</div>