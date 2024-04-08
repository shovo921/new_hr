<h3 class="block">Provide your employee account details</h3>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="col-md-4 control-label">Name<span class="required">*</span></label>
			<div class="col-md-8">
				@if (in_array(auth()->user()->role_id,['1','3']))
					{!! Form::text('name', $value = @$employee->name, array('id'=>'name', 'class' => 'form-control', 'required'=>"")) !!}
				@endif
				@if (in_array(auth()->user()->role_id,['2','21']))
					{!! Form::text('name', $value = @$employee->name, array('id'=>'name', 'class' => 'form-control', 'required'=>"",'readonly' => 'readonly')) !!}
				@endif
			</div>
		</div>
	</div>
	<!--/span-->
	<div class="col-md-6">
		<div class="form-group">
			<label class="col-md-4 control-label">Email</label>
			<div class="col-md-8">
				@if (in_array(auth()->user()->role_id,['1','3']))
					{!! Form::text('email', $value = @$employee->email, array('id'=>'email', 'class' => 'form-control')) !!}
				@endif
				@if (in_array(auth()->user()->role_id,['2','21']))
					{!! Form::text('email', $value = @$employee->email, array('id'=>'email', 'class' => 'form-control','readonly' => 'readonly')) !!}
				@endif
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<?php
		$readonly = ' readonly="readonly"';
		$employeeID = null;
		if (@$employee->employee_id) {
			$employeeID = $employee->employee_id;
		} else {
			$employeeID = getEmployeeID();
		}
		?>
		<div class="form-group">
			<label class="col-md-4 control-label">Employee ID<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::text('employee_id', $value = $employeeID, array('id'=>'employee_id', 'class' => 'form-control', 'required'=>"", $readonly)) !!}
			</div>
		</div>
	</div>
	<!--/span-->

	<div class="col-md-6">
		<div class="form-group">
			<label class="col-md-4 control-label">Joining Date<span class="required">*</span></label>
			<div class="col-md-8">
				<?php
				$joining_date = null;

				if (@$employeeDetails->joining_date != '') {
					$joining_date = $employeeDetails->joining_date;
				}
				?>
				{!! Form::text('joining_date', $value = $joining_date, array('id'=>'joining_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'required'=>"", 'readonly' => 'readonly')) !!}
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="col-md-4 control-label">Personal File no.<span class="required">*</span></label>
			<div class="col-md-8">
				<div class="input-group">
					<span class="input-group-addon" style="padding: 0;">
						{!! Form::text('prefix', $value = @$employeeDetails->prefix, array('id'=>'prefix', 'class' => 'form-control', 'placeholder'=>'Prefix', 'style'=>'width : 100px;border:none;', $readonly)) !!}
					</span>
					{!! Form::text('personal_file_no', $value = @$employeeDetails->personal_file_no, array('id'=>'personal_file_no', 'class' => 'form-control', $readonly)) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="form-group">
			<label class="col-md-4 control-label">Staff Type<span class="required">*</span></label>
			<div class="col-md-8">
				<?php
				$staff_value = null;
				if (@$employeeDetails->staff_type != '')
					$staff_value = $employeeDetails->staff_type;
				?>

				{!! Form::select('staff_type', $staff_type, $staff_value, ['id'=>'staff_type', 'class' => 'form-control', 'onchange' => 'getEmployeePrefix(this.value)', 'required'=>""]) !!}
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="col-md-4 control-label">Mobile No.<span class="required">*</span></label>
			<div class="col-md-8">
				<?php
				$employeeMobile = null;
				if (@$employee->mobile_no)
					$employeeMobile = $employee->mobile_no;
				?>
				@if (in_array(auth()->user()->role_id,['1','3']))
					{!! Form::text('mobile_no', $value = $employeeMobile, array('id'=>'mobile_no', 'class' => 'form-control', 'required'=>"", 'maxlength'=>"11", 'autocomplete'=>"off")) !!}
				@endif
				@if (in_array(auth()->user()->role_id,['2','21']))
					{!! Form::text('mobile_no', $value = $employeeMobile, array('id'=>'mobile_no', 'class' => 'form-control', 'required'=>"", 'maxlength'=>"11", 'autocomplete'=>"off",'readonly'=>'readonly')) !!}
				@endif
			</div>
		</div>
	</div>


	<div class="col-md-6">
		<div class="form-group">
			<label class="col-md-4 control-label">Employment Type<span class="required">*</span></label>
			<div class="col-md-8">
				@if (in_array(auth()->user()->role_id,['1','3']))
					@if(@$employeeDetails->period_start_date != '' || @$employeeDetails->period_end_date != '')
						{!! Form::select('employment_type', ['' => '--Please Select--']+$employment_type, @$employeeDetails->employment_type, ['class' => 'form-control', 'required'=>""]) !!}
					@else
						{!! Form::select('employment_type', ['' => '--Please Select--']+$employment_type, @$employeeDetails->employment_type, ['id' => 'employment_type', 'class' => 'form-control', 'required'=>""]) !!}
					@endif
				@endif
				@if (in_array(auth()->user()->role_id,['2','21']))
					@if(@$employeeDetails->period_start_date != '' || @$employeeDetails->period_end_date != '')
					{!! Form::select('employment_type',['' => '--Please Select--']+$employment_type,@$employeeDetails->employment_type,['class' => 'form-control', 'required'=>"",'readonly'=>'readonly']) !!}
					@else
					{!! Form::select('employment_type',['' => '--Please Select--']+$employment_type,@$employeeDetails->employment_type,['id' => 'employment_type', 'class' => 'form-control', 'required'=>"",'readonly'=>'readonly']) !!}
					@endif
				@endif
			</div>
		</div>
	</div>
</div>


<div class="row" id="prov_contract_area">
	<?php
	$employmentType = getEmploymentType(@$employeeDetails->employment_type);
	?>
	@if(@$employmentType == 'Contractual' || @$employmentType == 'Probation')
		@php
			if(@$employeeDetails->period_start_date != '')
             $periodStart = $employeeDetails->period_start_date;

            if(@$employeeDetails->period_end_date != '')
             $periodEnd =$employeeDetails->period_end_date;

//            dd($periodStart,$periodEnd);

		@endphp

		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">Period Start Date<span class="required">*</span></label>
				<div class="col-md-8">

					{!! Form::text('period_start_date', $value = $periodStart, array('id'=>'period_start_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'readonly' => 'readonly')) !!}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">Period Expiry Date<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('period_end_date', $value = $periodEnd, array('id'=>'period_end_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'readonly' => 'readonly')) !!}
				</div>
			</div>
		</div>
	@endif
</div>

<div class="form-group">
	<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
		@if(!isset($employee->id))
			<button type="button" class="btn btn-success" onclick="createNewUser()">Create</button>
		@else
			<button type="button" class="btn btn-success" onclick="updateUserBasicInfo()">Update</button>
		@endif
		<a class="btn btn-primary" href="{{url('/employee') }}"> Cancel</a>
	</div>
</div>
