<div class="form-body">
    <div class="form-group hidden">
        <div class="col-md-8">
            {!! Form::text('id', $value = $data['employeeKpi']->id ?? null, array('id'=>'id', 'class' => 'form-control')) !!}
            @if($errors->has('id'))
                <span class="required">{{ $errors->first('id') }}</span>
            @endif
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-4 control-label">Employee Info<span class="required">*</span></label>
        <div class="col-md-8">
            @if(empty($data['employeeKpi']))
                {!! Form::select('employee_id', $data['allEmployees'], $value = $data['employeeKpi']->employee_id ?? null, array('id' => 'employee_id', 'placeholder' => 'Employee Info', 'class' => 'form-control select2','onchange'=>"getEmployeeBasicInfo(this.value)", 'required' => '')) !!}
            @else
                {!! Form::text('employee_id', $value = $data['employeeKpi']->employee_id ?? null, array('id' => 'employee_id', 'placeholder' => 'Employee Info', 'class' => 'form-control', 'readonly' => 'readonly')) !!}
            @endif
            @if($errors->has('employee_id'))
                <span class="required">{{ $errors->first('employee_id') }}</span>
            @endif
        </div>
    </div>
    @if(!empty($data['employeeKpi']))
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
        <label class="col-md-4 control-label">KPI Year</label>
        <div class="col-md-8">
            {!! Form::text('kpi_year', $value =$data['employeeKpi']->kpi_year?? null, array('id'=>'kpi_year','readonly'=>'readonly','placeholder'=>'KPI Year', 'class' => 'form-control date-picker-year')) !!}
            @if($errors->has('kpi_year'))
                <span class="required">{{ $errors->first('kpi_year') }}</span>
            @endif
        </div>
    </div>

    @php
        if(!empty($data['employeeKpi'])){
            $kpiScores = json_decode($data['employeeKpi']->kpi_data)->kpiScores;
        }

    else{
        $kpiScores =null;
    }

    @endphp
    @foreach($data['kpiFields'] as $filedValues)
        <div class="form-group">
            <label class="col-md-4 control-label">{{ $filedValues->field_name }}</label>
            <div class="col-md-8">
                @if(empty($data['employeeKpi']))
                    {!! Form::text($filedValues->field_name, null, ['id' => $filedValues->field_name, 'placeholder' => $filedValues->field_name, 'class' => 'form-control']) !!}
                @else
                    @php
                        $fieldId = $filedValues->id;
                        $score = isset($kpiScores->$fieldId) ? $kpiScores->$fieldId : null;
                    @endphp
                    {!! Form::text($filedValues->field_name, $score, ['id' => $filedValues->field_name, 'placeholder' => $filedValues->field_name, 'class' => 'form-control']) !!}
                @endif
                @if($errors->has($filedValues->field_name))
                    <span class="required">{{ $errors->first($filedValues->field_name) }}</span>
                @endif
            </div>
        </div>
    @endforeach

    <div class="form-group">
        <label class="col-md-4 control-label">Status</label>
        <div class="col-md-8">
            @php
                $data['status'] = [''=>'please select',1=>'Active',2=>'Inactive']
            @endphp
            {!! Form::select('status',$data['status'], $value = $data['employeeKpi']->status ?? null, array('id'=>'status','placeholder'=>'Status', 'class' => 'form-control')) !!}
            @if($errors->has('status'))
                <span class="required">{{ $errors->first('status') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            @if(!empty($data['employeeKpi']))
                {!! Form::submit('Update', array('class' => "btn btn-primary")) !!}
            @else
                {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!}
            @endif

            <a href="{{  route('bills-type.index') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>