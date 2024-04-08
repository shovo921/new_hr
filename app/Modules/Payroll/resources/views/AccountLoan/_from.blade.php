<div class="form-body">

    <div class="form-group">
        <label class="col-md-4 control-label">Employee ID<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('employee_id',$employeeList, $value = null, array('id'=>'employee_id', 'class' => 'form-control select2','placeholder'=>'Employee Id', 'required'=>"",'onchange'=>"getEmployeeBasicInfo(this.value)")) !!}
            @if($errors->has('employee_id'))
                <span class="required">{{ $errors->first('employee_id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Employee Name</label>
        <div class="col-md-8">
            {!! Form::text('employee_name', $value = null, array('id'=>'employee_name','readonly'=>'readonly','placeholder'=>'Employee Name', 'class' => 'form-control')) !!}
            @if($errors->has('employee_name'))
                <span class="required">{{ $errors->first('employee_name') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Designation</label>
        <div class="col-md-8">
            {!! Form::text('employee_designation', $value = null, array('id'=>'employee_designation','readonly'=>'readonly','placeholder'=>'Designation', 'class' => 'form-control')) !!}
            @if($errors->has('employee_designation'))
                <span
                        class="required">{{ $errors->first('employee_designation') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Account Number<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::number('acc_no', $value = null, array('id'=>'acc_no','placeholder'=>'Please Give Account Number', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('acc_no'))
                <span
                        class="required">{{ $errors->first('acc_no') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Disbursement Amount<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::number('disb_amt', $value = null, array('id'=>'disb_amt','placeholder'=>'Please Give Disbursement Amount', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('disb_amt'))
                <span
                        class="required">{{ $errors->first('disb_amt') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Rate<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::number('rate', $value = null, array('id'=>'rate','placeholder'=>'Please Give Rate', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('rate'))
                <span
                        class="required">{{ $errors->first('rate') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Disbursement Date</label>
        <div class="col-md-8">
            {!! Form::text('disb_date', $value = null, array('id'=>'disb_date', 'placeholder'=>'yyyy/mm/dd', 'class' => 'form-control date-picker')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Installment Start Month</label>
        <div class="col-md-8">
            {!! Form::text('start_month', $value = null, array('id'=>'start_date', 'placeholder'=>'mm-yyyy', 'class' => 'form-control date-picker1')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Installment End Month</label>
        <div class="col-md-8">
            {!! Form::text('end_month', $value = null, array('id'=>'end_date', 'placeholder'=>'mm-yyyy', 'class' => 'form-control date-picker1')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Tenor<span class="required">*</span></label>
        <div class="row">
            <div class="col-md-6">
                {!! Form::number('tenor', $value = null, array('id'=>'tenor','placeholder'=>'Number Of Month', 'class' => 'form-control', 'required'=>"")) !!}
                @if($errors->has('tenor'))
                    <span
                            class="required">{{ $errors->first('tenor') }}</span>
                @endif
            </div>
            <div class="col-md-1">
                <label class="col-md-4 control-label">Month</label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Select Branch<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('branch_id',$branchList, $value = null, array('id'=>'branch_id', 'class' => 'form-control select2','placeholder'=>'Branch ID', 'required'=>"")) !!}
            @if($errors->has('id'))
                <span class="required">{{ $errors->first('id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Select Loan Type<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('dtype_id',$dedList, $value = null, array('dtype_id'=>'dtype_id', 'class' => 'form-control select2','placeholder'=>'DeductionType', 'required'=>"")) !!}
            @if($errors->has('dtype_id'))
                <span class="required">{{ $errors->first('dtype_id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Status<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('status', $status, $value = null, array('id'=>'status', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('status'))
                <span class="required">{{ $errors->first('status') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Executive Car Loan<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('exe_car_loan', $data['exe_car_loan'], $value = null, array('id'=>'exe_car_loan', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('exe_car_loan'))
                <span class="required">{{ $errors->first('exe_car_loan') }}</span>
            @endif
        </div>
    </div>


    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
            <a href="{{  url('account-loan') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>