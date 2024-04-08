<div class="form-body">

	<div class="form-group">
		<label class="col-md-4 control-label">Employee ID<span class="required">*</span></label>
		<div class="col-md-8">
				{!! Form::select('employee_id',$employeeList, $value = null, array('id'=>'employee_id', 'class' => 'form-control select2','placeholder'=>'Employee Id', 'required'=>"",'onchange'=>"getEmployeeBasicInfo(this.value)")) !!}
				@if($errors->has('employee_id'))<span class="required">{{ $errors->first('employee_id') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Employee Name</label>
		<div class="col-md-8">
			{!! Form::text('employee_name', $value = null, array('id'=>'employee_name','readonly'=>'readonly','placeholder'=>'Employee Name', 'class' => 'form-control')) !!}
			@if($errors->has('employee_name'))<span class="required">{{ $errors->first('employee_name') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Designation</label>
		<div class="col-md-8">
			{!! Form::text('employee_designation', $value = null, array('id'=>'employee_designation','readonly'=>'readonly','placeholder'=>'Designation', 'class' => 'form-control')) !!}
			@if($errors->has('employee_designation'))<span
					class="required">{{ $errors->first('employee_designation') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Account Number<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::number('account_no', $value = null, array('id'=>'account_no','placeholder'=>'Please Give Account Number', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('account_no'))<span class="required">{{ $errors->first('account_no') }}</span>@endif

			{{--<a class="btn btn-info" onclick="getAccInfo($('#account_no').val(),1)">Check Account</a>--}}
		</div>

	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Customer ID<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::number('customer_id', $value = null, array('id'=>'customer_id','placeholder'=>'Please Enter Customer ID', 'readonly'=>'readonly','class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('customer_id'))<span
					class="required">{{ $errors->first('customer_id') }}</span>@endif
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Customer Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('cus_name', $value = null, array('id'=>'cus_name','placeholder'=>'Customer Name', 'readonly'=>'readonly','class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('cus_name'))<span
					class="required">{{ $errors->first('cus_name') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Select Branch<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('branch_id',$branchList, $value = null, array('id'=>'branch_id', 'class' => 'form-control select2','placeholder'=>'Branch ID', 'required'=>"")) !!}
			@if($errors->has('id'))<span class="required">{{ $errors->first('id') }}</span>@endif
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
			<a href="{{  url('salary-account') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>