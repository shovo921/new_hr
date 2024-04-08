<div class="form-body">
    <div class="form-group hidden">
        <div class="col-md-8">
            {!! Form::text('id', $value = $data['employeeAllowances']->id ?? null, array('id'=>'id', 'class' => 'form-control')) !!}
            @if($errors->has('id'))
                <span class="required">{{ $errors->first('id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Employee Info<span class="required">*</span></label>
        <div class="col-md-8">
            @if(empty($data['employeeAllowances']))
                {!! Form::select('employee_id',$data['allEmployees'], $value = $data['employeeAllowances']->employee_id ?? null, array('id'=>'employee_id','placeholder'=>'Employee Info', 'class' => 'form-control select2','onchange'=>"getEmployeeBasicInfo(this.value)", 'required'=>"")) !!}
                @if($errors->has('employee_id'))
                    <span class="required">{{ $errors->first('employee_id') }}</span>
                @endif
            @else
                {!! Form::text('employee_id', $value = $data['employeeAllowances']->employee_id ?? null, array('id'=>'employee_id','placeholder'=>'Employee Info', 'class' => 'form-control','readonly'=>'readonly')) !!}
                @if($errors->has('employee_id'))
                    <span class="required">{{ $errors->first('employee_id') }}</span>
                @endif
            @endif
        </div>
    </div>
    @if(!empty($data['employeeAllowances']))
        <div class="form-group">
            <label class="col-md-4 control-label">Employee Name</label>
            <div class="col-md-8">
                {!! Form::text('employee_name', $value = null, array('id'=>'employee_name','readonly'=>'readonly','placeholder'=>'Employee Name', 'class' => 'form-control')) !!}
                @if($errors->has('employee_name'))
                    <span class="required">{{ $errors->first('employee_name') }}</span>
                @endif
            </div>
        </div>
    @endif

    <div class="form-group">
        <label class="col-md-4 control-label">Branch/Division</label>
        <div class="col-md-8">
            {!! Form::text('employee_branch', $value = null, array('id'=>'employee_branch','readonly'=>'readonly','placeholder'=>'Branch/Division', 'class' => 'form-control')) !!}
            @if($errors->has('employee_branch'))
                <span class="required">{{ $errors->first('employee_branch') }}</span>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Designation</label>
        <div class="col-md-8">
            {!! Form::text('employee_designation', $value = null, array('id'=>'employee_designation','readonly'=>'readonly','placeholder'=>'Designation', 'class' => 'form-control')) !!}
            @if($errors->has('employee_designation'))
                <span class="required">{{ $errors->first('employee_designation') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Allowance Type<span class="required">*</span></label>
        <div class="col-md-8">

            {!! Form::select('allowance_type',$data['allowanceTypes'], $value = $data['employeeAllowances']->allowance_type ?? null, array('id'=>'allowance_type','placeholder'=>'Please Give Allowance Type', 'class' => 'form-control select2', 'required'=>"")) !!}
            @if($errors->has('allowance_type'))
                <span class="required">{{ $errors->first('allowance_type') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Disbursement Amount<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::number('disb_amount', $value = $data['employeeAllowances']->disb_amount ?? null, array('id'=>'disb_amount','placeholder'=>'Please Give Allowance Type', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('disb_amount'))
                <span class="required">{{ $errors->first('disb_amount') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Disbursement Date</label>
        <div class="col-md-8">
            {!! Form::text('disb_date', $value =$data['employeeAllowances']->disb_date ?? null, array('id'=>'disb_date', 'placeholder'=>'yyyy-mm-dd', 'class' => 'form-control date-picker')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Amortization Start Month</label>
        <div class="col-md-8">
            {!! Form::text('deduct_start_month', $value = $data['employeeAllowances']->deduct_start_month ?? null, array('id'=>'deduct_start_month', 'placeholder'=>'yyyy-mm', 'class' => 'form-control date-picker-month')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Amortization End Month</label>
        <div class="col-md-8">
            {!! Form::text('deduct_end_month', $value = $data['employeeAllowances']->deduct_end_month ?? null, array('id'=>'end_date', 'placeholder'=>'yyyy-mm', 'class' => 'form-control date-picker-month')) !!}
        </div>
    </div>

    @if(!empty($data['employeeAllowances']))
        <div class="form-group">
            <label class="col-md-4 control-label">Status<span class="required">*</span></label>
            <div class="col-md-8">
                {!! Form::select('status', $data['status'] ,$value =$data['employeeAllowances']->status ??  null, array('id'=>'status', 'class' => 'form-control', 'required'=>"")) !!}
                @if($errors->has('status'))
                    <span class="required">{{ $errors->first('status') }}</span>
                @endif
            </div>
        </div>
    @endif

    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            @if(!empty($data['employeeAllowances']))
                {!! Form::submit('Update', array('class' => "btn btn-primary")) !!}
            @else
                {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!}
            @endif
            <a href="{{  url('allowance-type') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>