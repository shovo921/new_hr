<div class="form-body">
    <div class="form-group hidden">
        <div class="col-md-8">
            {!! Form::text('id', $value = $data['employeeBills']->id ?? null, array('id'=>'id', 'class' => 'form-control')) !!}
            @if($errors->has('id'))
                <span class="required">{{ $errors->first('id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Employee Info<span class="required">*</span></label>
        <div class="col-md-8">
            @if(empty($data['employeeBills']))
                {!! Form::select('employee_id',$data['allEmployees'], $value = $data['employeeBills']->employee_id ?? null, array('id'=>'employee_id','placeholder'=>'Employee Info', 'class' => 'form-control select2','onchange'=>"getEmployeeBasicInfo(this.value)", 'required'=>"")) !!}
                @if($errors->has('employee_id'))
                    <span class="required">{{ $errors->first('employee_id') }}</span>
                @endif
            @else
                {!! Form::text('employee_id', $value = $data['employeeBills']->employee_id ?? null, array('id'=>'employee_id','placeholder'=>'Employee Info', 'class' => 'form-control','readonly'=>'readonly')) !!}
                @if($errors->has('employee_id'))
                    <span class="required">{{ $errors->first('employee_id') }}</span>
                @endif
            @endif
        </div>
    </div>
    @if(!empty($data['employeeBills']))
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
        <label class="col-md-4 control-label">Bill Type<span class="required">*</span></label>
        <div class="col-md-8">
{{--@php  dd($data['billsType'],$data['employeeBills']->bill_setup_id); @endphp--}}
            {!! Form::select('bill_setup_id',$data['billsType'], $value = $data['employeeBills']->bill_setup_id ?? null, array('id'=>'bill_setup_id','placeholder'=>'Please Select Bill Type', 'class' => 'form-control select2', 'required'=>"")) !!}
            @if($errors->has('bill_setup_id'))
                <span class="required">{{ $errors->first('bill_setup_id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Bill Amount<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::number('bill_amount', $value = $data['employeeBills']->bill_amount ?? null, array('id'=>'bill_amount','placeholder'=>'Bill Amount', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('bill_amount'))
                <span class="required">{{ $errors->first('bill_amount') }}</span>
            @endif
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-4 control-label">Status<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('status', $data['status'] ,$value =$data['employeeBills']->status ??  null, array('id'=>'status', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('status'))
                <span class="required">{{ $errors->first('status') }}</span>
            @endif
        </div>
    </div>


    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            @if(!empty($data['employeeBills']))
                {!! Form::submit('Update', array('class' => "btn btn-primary")) !!}
            @else
                {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!}
            @endif
                <a href="{{  route('emp-bills.index') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>