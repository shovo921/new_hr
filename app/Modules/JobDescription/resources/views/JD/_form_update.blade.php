<div class="form-body">

    <div class="form-group">
        <label class="col-md-4 control-label">Employee ID</label>
        <div class="col-md-8">
            {!! Form::text('employee_id', $value = $employeeDetails->employee_id, array('id'=>'employee_id', 'class' => 'form-control ', 'readonly'=>'readonly')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Employee Name</label>
        <div class="col-md-8">
            {!! Form::text('employee_name', $value = $employeeDetails->employee_name, array('id'=>'employee_name','readonly'=>'readonly', 'class' => 'form-control')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Designation</label>
        <div class="col-md-8">
            {!! Form::text('employee_designation', $value = $employeeDetails->designation, array('id'=>'employee_designation','readonly'=>'readonly', 'class' => 'form-control')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Functional Designation</label>
        <div class="col-md-8">
            {!! Form::text('functional_designation', $value = $employeeJd->functionalDesignation->designation ?? '', array('id'=>'functional_designation','readonly'=>'readonly', 'class' => 'form-control')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Branch Name<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('branch_name', $value = $employeeDetails->branch_name, array('id'=>'account_no','readonly'=>'readonly', 'class' => 'form-control')) !!}
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-4 control-label">Job Description<span class="required">*</span></label>
        <div class="col-md-8">
            {{$employeeJd->file_name}} <a href="{{ asset('uploads/employee-jd/'. $employeeJd->file_name) }}"
                                          target="_blank"><i class="fa fa-eye">View</i></a>
        </div>
    </div>
    @php
        $branch_head = $headOfDivOrBranchEmpId->employee_name ?? (!empty($headOfDivOrBranchEmpId) ? $headOfDivOrBranchEmpId : 'N/A');
    @endphp
    <div class="form-group">
        <label class="col-md-4 control-label">Approval<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('branch_head', $value = $branch_head , array('id'=>'banch_head','readonly'=>'readonly', 'class' => 'form-control')) !!}
        </div>
    </div>
    @if (in_array(auth()->user()->employee_id,[$employeeJd->approver_id]))
        <div class="form-group">
            <label class="col-md-4 control-label">Remarks<span class="required">*</span></label>
            <div class="col-md-8">
                {!! Form::text('remarks', $value=null, array('id'=>'remarks', 'class' => 'form-control')) !!}
            </div>
        </div>
    @endif
    @if (in_array(auth()->user()->employee_id,[$employeeDetails->employee_id]))
        <div class="form-group">
            <label class="col-md-4 control-label">Checked<span class="required">*</span></label>
            <div class="col-md-8">
                <input type="checkbox" id="status" name="status" value=2 required="required">
                <label>Do you agree to Terms & Conditions</label><br/><br/>
            </div>
        </div>
    @endif

    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            {{--{!! Form::submit('Checked', array('class' => "btn btn-primary",'name' => 'submit')) !!}
            {!! Form::submit('Approved', array('class' => "btn btn-primary",'name' => 'submit')) !!}--}}
            @if (in_array(auth()->user()->employee_id,[$employeeDetails->employee_id]))
                {!! Form::submit('Checked', array('class' => "btn btn-primary",'name' => 'submit')) !!}
            @endif
            @if (in_array(auth()->user()->employee_id,[$employeeJd->approver_id],'hradmin'))
                {!! Form::submit('Approved', array('class' => "btn btn-primary",'name' => 'submit')) !!}
            @endif
            <a href="{{  url('home') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>