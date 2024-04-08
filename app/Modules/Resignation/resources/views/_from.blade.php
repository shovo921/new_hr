<div class="form-body">

    <div class="form-group">
        <label class="col-md-4 control-label">Employee ID<span class="required">*</span></label>
        <div class="col-md-8">
            @if(empty($resign))
                {!! Form::select('employee_id',$employeeList, $value = null, array('id'=>'employee_id', 'class' => 'form-control select2','placeholder'=>'Employee Id', 'required'=>"",'onchange'=>"getEmployeeBasicInfo(this.value)")) !!}
                @if($errors->has('employee_id'))<span class="required">{{ $errors->first('employee_id') }}</span>@endif
            @else
                {!! Form::text('employee_id', $value = null, array('id'=>'employee_id','readonly'=>'readonly', 'placeholder'=>'Employee Id','class' => 'form-control')) !!}
            @endif
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
            {!! Form::text('employee_branch', $value = null, array('id'=>'employee_branch','readonly'=>'readonly','placeholder'=>'Branch/Division', 'class' => 'form-control')) !!}
            @if($errors->has('employee_branch'))<span
                    class="required">{{ $errors->first('employee_branch') }}</span>@endif
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Resign Reason<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('resign_cat_id',$resignCategory, $value = null, array('id'=>'resign_cat_id', 'class' => 'form-control select2','placeholder'=>'Please Select', 'required'=>"")) !!}
            @if($errors->has('resign_cat_id'))<span class="required">{{ $errors->first('resign_cat_id') }}</span>@endif
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Remarks</label>
        <div class="col-md-8">
            {!! Form::textarea('remarks', $value = null, array('id'=>'remarks', 'placeholder'=>'Please Give an entry','class' => 'form-control')) !!}
            @if($errors->has('remarks'))<span class="required">{{ $errors->first('remarks') }}</span>@endif
        </div>
    </div>
    @php
        $date_resign = null;
        $release_date = null;
        if(@$resign->date_resign != '')
            $resign->date_resign = date('d/m/Y', strtotime($resign->date_resign));
        if(@$resign->release_date != '')
            $resign->release_date = date('d/m/Y', strtotime($resign->release_date));
    @endphp
    <div class="form-group">
        <label class="col-md-4 control-label">Resign Date<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('date_resign', $value = $release_date, array('id'=>'date_resign','autocomplete'=>'off', 'class' => 'form-control date-picker','placeholder'=>'dd/mm/yyyy', 'required'=>"")) !!}
            @if($errors->has('date_resign'))<span class="required">{{ $errors->first('date_resign') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Release Date</label>
        <div class="col-md-8">
            {!! Form::text('release_date', $value = $release_date, array('id'=>'release_date','autocomplete'=>'off','placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker')) !!}
            @if($errors->has('release_date'))<span class="required">{{ $errors->first('release_date') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
            <a href="{{  url('/branch') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>