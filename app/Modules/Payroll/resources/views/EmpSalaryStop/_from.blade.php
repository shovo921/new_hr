<div class="form-body">
    <div class="form-group hidden">
        <div class="col-md-8">
            {!! Form::text('id', $value = $data['empSalStop']->id ?? null, array('id'=>'id', 'class' => 'form-control')) !!}
            @if($errors->has('id'))
                <span class="required">{{ $errors->first('id') }}</span>
            @endif
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-4 control-label">Employee Info<span class="required">*</span></label>
        <div class="col-md-8">
            @if(empty($data['empSalStop']))
                {!! Form::select('employee_id',$data['allEmployees'], $value = $data['empSalStop']->employee_id ?? null, array('id'=>'employee_id','placeholder'=>'Employee Info', 'class' => 'form-control select2','onchange'=>"getEmployeeBasicInfo(this.value)", 'required'=>"")) !!}
                @if($errors->has('employee_id'))
                    <span class="required">{{ $errors->first('employee_id') }}</span>
                @endif
            @else
                {!! Form::text('employee_id', $value = $data['empSalStop']->employee_id ?? null, array('id'=>'employee_id','placeholder'=>'Employee Info', 'class' => 'form-control','readonly'=>'readonly')) !!}
                @if($errors->has('employee_id'))
                    <span class="required">{{ $errors->first('employee_id') }}</span>
                @endif
            @endif
        </div>
    </div>
    @if(!empty($data['empSalStop']))
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
    <div class="form-group hidden">
        <div class="col-md-8">
            {!! Form::text('designation_id', $value =  null, array('id'=>'designation_id', 'class' => 'form-control')) !!}
            @if($errors->has('designation_id'))
                <span class="required">{{ $errors->first('designation_id') }}</span>
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
        <label class="col-md-4 control-label">Start Date<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('start_date', $value = $data['empSalStop']->start_date ?? null, array('id'=>'start_date','placeholder'=>'Start Date', 'class' => 'form-control date-picker', 'required'=>"")) !!}
            @if($errors->has('start_date'))
                <span class="required">{{ $errors->first('start_date') }}</span>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">End Date<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('end_date', $value = $data['empSalStop']->end_date ?? null, array('id'=>'end_date','placeholder'=>'End Date', 'class' => 'form-control date-picker', 'required'=>"")) !!}
            @if($errors->has('end_date'))
                <span class="required">{{ $errors->first('end_date') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Remarks<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::textarea('remarks', $value = $data['empSalStop']->remarks ?? null, array('id'=>'remarks','placeholder'=>'Remarks', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('remarks'))
                <span class="required">{{ $errors->first('remarks') }}</span>
            @endif
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-4 control-label">Status<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('status', $data['status'] ,$value =$data['empSalStop']->status ??  null, array('id'=>'status', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('status'))
                <span class="required">{{ $errors->first('status') }}</span>
            @endif
        </div>
    </div>


    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            @if(!empty($data['empSalStop']))
                {!! Form::submit('Update', array('class' => "btn btn-primary")) !!}
            @else
                {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!}
            @endif
            <a href="{{  route('stop-sal.index') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>