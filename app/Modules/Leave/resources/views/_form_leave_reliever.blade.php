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
		<label class="col-md-4 control-label">Branch <span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('branch', @$postingInfo->branch->branch_name, array('id'=>'branch', 'class' => 'form-control', 'required'=>"", 'readonly'=>"readonly")) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Division </label>
		<div class="col-md-8">
			{!! Form::text('division', @$postingInfo->division->br_name, array('id'=>'division', 'class' => 'form-control', 'readonly'=>"readonly")) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Leave Duration <span class="required">*</span></label>
		{{--<div class="col-md-8" style="padding: 0px">
			<?php
			$start_date = null;
			$end_date = null;
			$next_date = null;

			if(@$leaveApplication->start_date != '')
				$start_date = date('d/m/Y', strtotime($leaveApplication->start_date));

			if(@$leaveApplication->end_date != '')
				$end_date = date('d/m/Y', strtotime($leaveApplication->end_date));

			if(@$leaveApplication->next_joining_date != '')
				$next_date = date('d/m/Y', strtotime($leaveApplication->next_joining_date));
			?>
			<div class="col-md-4">
				<label class="control-label">Start Date<span class="required">*</span></label>
				{!! Form::text('start_date', $value = $start_date, array('id'=>'start_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'required'=>"", 'readonly'=>"readonly")) !!}
			</div>
			<div class="col-md-4">
				<label class="control-label">End Date<span class="required">*</span></label>
				{!! Form::text('end_date', $value = $end_date, array('id'=>'end_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'required'=>"", 'onchange'=>'calculateTotalDays()', 'readonly'=>"readonly")) !!}
			</div>
			<div class="col-md-4">
				<label class="control-label">Total day/days<span class="required">*</span></label>
				{!! Form::text('total_days', $value = null, array('id'=>'total_days', 'class' => 'form-control', 'required'=>"",'readonly'=>"readonly")) !!}
				@if($errors->has('total_days'))<span class="required">{{ $errors->first('total_days') }}</span>@endif
			</div>
		</div>--}}
		<div class="col-md-8" style="padding: 0px">
			<?php
			$start_date = null;
			$end_date = null;
			$next_date = null;

			if(@$leaveApplication->start_date != '')
				$start_date = date('m/d/Y', strtotime($leaveApplication->start_date));

			if(@$leaveApplication->end_date != '')
				$end_date = date('m/d/Y', strtotime($leaveApplication->end_date));

			if(@$leaveApplication->next_joining_date != '')
				$next_date = date('m/d/Y', strtotime($leaveApplication->next_joining_date));
			?>
			<div class="col-md-4">
				<label class="control-label">Start Date<span class="required">*</span></label>
				{!! Form::text('start_date', $value = $start_date, array('id'=>'start_date', 'placeholder'=>'mm/dd/yyyy', 'class' => 'form-control date-picker', 'required'=>"")) !!}
			</div>
			<div class="col-md-4">
				<label class="control-label">End Date<span class="required">*</span></label>
				{!! Form::text('end_date', $value = $end_date, array('id'=>'end_date', 'placeholder'=>'mm/dd/yyyy', 'class' => 'form-control date-picker', 'required'=>"", 'onchange'=>'calculateTotalDays()')) !!}
			</div>
			<div class="col-md-4">
				<label class="control-label">Total day/days<span class="required">*</span></label>
				{!! Form::text('total_days', $value = null, array('id'=>'total_days', 'class' => 'form-control', 'required'=>"",'readonly'=>"readonly")) !!}
				@if($errors->has('total_days'))<span class="required">{{ $errors->first('total_days') }}</span>@endif
			</div>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Leave Type<span class="required">*</span></label>
		<div class="col-md-8" style="padding: 0px">
			<div class="col-md-3">
				<label class="control-label">Leave Type<span class="required">*</span></label>
				{!! Form::text('leave_type_id', $value = $leaveBalance->leave_type, array('id'=>'leave_type_id', 'class' => 'form-control', 'required'=>"",'readonly'=>"readonly", 'onchange'=>'checkLeaveConditions(this.value)')) !!}
			</div>
			<div class="col-md-3">
				<label class="control-label">Current Balance</label>

				{!! Form::text('current_balance', $value = $leaveBalance->last_forwarded_leave, array('id'=>'current_balance', 'class' => 'form-control', 'readonly'=>"readonly")) !!}
			</div>
			<div class="col-md-3">
				<label class="control-label">Leave Availed</label>
				{!! Form::text('remaining_balance',$value = $leaveBalance->leave_taken ?? 0, array('id'=>'remaining_balance', 'class' => 'form-control', 'readonly'=>"readonly")) !!}
			</div>
			<div class="col-md-3">
				@php
					$datetime1 = strtotime($start_date); // convert to timestamps
    				$datetime2 = strtotime($end_date); // convert to timestamps
    				$days = (int)(($datetime2 - $datetime1)/86400);
                    $total_day =$days+1;
                    $balance_after_deduct = $leaveBalance->last_forwarded_leave -$total_day;
                    //dd($total_day,$balance_after_deduct);
				@endphp
				<label class="control-label">After Deduction</label>
				{!! Form::text('balance_after_deduction',$value = $balance_after_deduct ?? 0, array('id'=>'remaining_balance', 'class' => 'form-control', 'readonly'=>"readonly")) !!}
			</div>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Next Joining Date<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('next_joining_date', $value = $next_date, array('id'=>'next_joining_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'required'=>"", 'readonly'=>"readonly")) !!}
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
		<label class="col-md-4 control-label">Reason of Leave<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('reason_of_leave', $value = null, array('id'=>'reason_of_leave', 'class' => 'form-control','readonly'=>"readonly", 'required'=>"")) !!}
			@if($errors->has('reason_of_leave'))<span class="required">{{ $errors->first('reason_of_leave') }}</span>@endif
		</div>
	</div>
	{{--@if(!empty($leaveApplication->leaveAttachment->attachment) || in_array(1, $leaveApplication->leaveAttachment->attachment, true))--}}
		<div class="form-group">
			<label class="col-md-4 control-label">Leave Attachment</label>
			<div class="col-md-8">
				<label class="col-md-4 control-label">{{ $leaveApplication->leaveAttachment->attachment ?? ''}}</label>
				<a href="{{ asset('uploads/employeedata/' . ($leaveApplication->employee_id ?? '') . '/leave/'.($leaveApplication->leaveAttachment->attachment ?? '') ) }}" target="_blank"><i class="fa fa-eye">View File</i></a>
			</div>
		</div>
	{{--@endif--}}

	<div class="form-group">
		<label class="col-md-4 control-label">Address & Telephone Number During Leave<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('contact_info_during_leave', $value = null, array('id'=>'contact_info_during_leave', 'readonly'=>"readonly",'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('contact_info_during_leave'))<span class="required">{{ $errors->first('contact_info_during_leave') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Responsible Person<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('responsible_to', $leaveReliever, $value = null, array('id'=>'responsible_to', 'class' => 'form-control select2', 'required'=>"")) !!}

			@if($errors->has('responsible_to'))<span class="required">{{ $errors->first('responsible_to') }}</span>@endif
		</div>
	</div>
	@if (in_array(auth()->user()->role_id,['21']))
	<div class="form-group">
		<label class="col-md-4 control-label"><b>Reliever Remarks</b><span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('line_manager_remarks', $value = null, array('id'=>'line_manager_remarks', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('line_manager_remarks'))<span class="required">{{ $errors->first('line_manager_remarks') }}</span>@endif
		</div>
	</div>
	@endif
	@if (in_array(auth()->user()->role_id,['2','1','3']))
		<?php
		//dd($leaveApplicationLogResposible);
			if(@$leaveApplicationLogResposible->remarks != '')
				$remarks = $leaveApplicationLogResposible->remarks;
			else
				$remarks =null;
			?>
	<div class="form-group">
		<label class="col-md-4 control-label" ><b>Reliever Remarks</b><span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('line_manager_remarks', $value = $remarks, array('id'=>'line_manager_remarks', 'readonly'=>"readonly",'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('line_manager_remarks'))<span class="required">{{ $errors->first('line_manager_remarks') }}</span>@endif
		</div>
	</div>
	@endif

	<div class="form-group">
		<label class="col-md-4 control-label">Division Head<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('responsible_to_div_head', $divisionHead, $value = null, array('id'=>'responsible_to_div_head', 'class' => 'form-control select2', 'required'=>"")) !!}

			@if($errors->has('responsible_to_div_head'))<span class="required">{{ $errors->first('responsible_to_div_head') }}</span>@endif
		</div>
	</div>

	@if (in_array(auth()->user()->role_id,['2']))
		<div class="form-group">
			<label class="col-md-4 control-label"><b>Division Head Remarks</b><span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::text('division_head_remarks', $value = null, array('id'=>'division_head_remarks', 'class' => 'form-control', 'required'=>"")) !!}
				@if($errors->has('division_head_remarks'))<span class="required">{{ $errors->first('division_head_remarks') }}</span>@endif
			</div>
		</div>
	@endif
	@if (in_array(auth()->user()->role_id,['1','3']))
		<?php

		if(@$leaveApplicationLogDiviHead->remarks != '')
			$remarks = $leaveApplicationLogDiviHead->remarks;
		else
			$remarks =null;
		?>
			<div class="form-group">
				<label class="col-md-4 control-label"><b>Division Head / Branch Manager</b><span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('division_head_remarks', $value = $remarks, array('id'=>'division_head_remarks', 'class' => 'form-control','readonly'=>'readonly', 'required'=>"")) !!}
					@if($errors->has('division_head_remarks'))<span class="required">{{ $errors->first('division_head_remarks') }}</span>@endif
				</div>
			</div>
	@endif
	@if (in_array(auth()->user()->role_id,['1','3']))
		<div class="form-group">
			<label class="col-md-4 control-label"><b>HR Remarks</b><span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::text('hr_remarks', $value = null, array('id'=>'hr_remarks', 'class' => 'form-control', 'required'=>"")) !!}
				@if($errors->has('hr_remarks'))<span class="required">{{ $errors->first('hr_remarks') }}</span>@endif
			</div>
		</div>
	@endif


	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Approve / Forward', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{ url('cancelLeave/'.$leaveApplication->id) }}" class="btn btn-danger">Cancel</a>
			<a href="{{  url('/waiting-list') }}" class="btn btn-success">Back</a>
		</div>
	</div>
</div>