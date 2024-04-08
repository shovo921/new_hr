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

</div>