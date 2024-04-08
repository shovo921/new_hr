<div class="form-body">

    <div class="form-group">
        <label class="col-md-4 control-label">Employee ID</label>
        <div class="col-md-8">
            {!! Form::text('employee_id', $value = $salaryAccount->employee_id, array('id'=>'employee_id', 'class' => 'form-control ', 'readonly'=>'readonly')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Employee Name</label>
        <div class="col-md-8">
            {!! Form::text('employee_name', $value = $salaryAccount->employee->name, array('id'=>'employee_name','readonly'=>'readonly', 'class' => 'form-control')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Designation</label>
        <div class="col-md-8">
            {!! Form::text('employee_designation', $value = $salaryAccount->employeeDetails->designation, array('id'=>'employee_designation','readonly'=>'readonly', 'class' => 'form-control')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Account Number<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::number('account_no', $value = $salaryAccount->account_no, array('id'=>'account_no','readonly'=>'readonly', 'class' => 'form-control')) !!}
            @if($errors->has('account_no'))
                <span class="required">{{ $errors->first('account_no') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Customer ID<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::number('customer_id', $value = $salaryAccount->customer_id ?? null, array('id'=>'customer_id','placeholder'=>'Please Enter Customer ID', 'class' => 'form-control', 'required'=>"")) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Branch Name<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('branch_id', $value = $salaryAccount->employeeDetails->branch_name, array('id'=>'branch_id', 'class' => 'form-control','readonly'=>'readonly', 'required'=>"")) !!}
            @if($errors->has('id'))
                <span class="required">{{ $errors->first('id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Status<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('status', $status, $value = $salaryAccount->status, array('id'=>'status', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('status'))
                <span class="required">{{ $errors->first('status') }}</span>
            @endif
        </div>
    </div>


    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
            <a href="{{  url('salary-account') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>