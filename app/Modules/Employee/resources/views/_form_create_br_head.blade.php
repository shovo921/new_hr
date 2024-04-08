
<div class="form-body">

    <div class="form-group">
        <label class="col-md-4 control-label">Employee Name<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('employee_id', $employeeList, $value = null, array('id'=>'employee_id', 'class' => 'form-control select2', 'required'=>"", 'onchange'=>"getEmployeeBasicInfo(this.value)")) !!}
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
        <label class="col-md-4 control-label">Branch/Division</label>
        <div class="col-md-8">
            {!! Form::select('id',$branchList, $value = null, array('id'=>'id', 'class' => 'form-control select2', 'required'=>"",'placeholder'=>'Select a Branch')) !!}
            @if($errors->has('id'))<span
                    class="required">{{ $errors->first('id') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Effective Date<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('start_date',$value = null,   array('id'=>'start_date','autocomplete'=>'off', 'class' => 'form-control date-picker','placeholder'=>'dd/mm/yyyy', 'required'=>"")) !!}
            @if($errors->has('start_date'))<span class="required">{{ $errors->first('start_date') }}</span>@endif
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-4 control-label">Branch/Division Head<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('status', $head, $value =null, array('id'=>'status', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('status'))<span class="required">{{ $errors->first('status') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!}
            <a href="{{  url('/brdivhead') }}" class="btn btn-success">Back</a>
        </div>
    </div>
</div>