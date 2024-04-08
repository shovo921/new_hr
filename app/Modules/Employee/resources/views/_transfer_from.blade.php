<div class="form-body" >

    <div class="form-group">
        <label class="col-md-4 control-label">Employee Name<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('employee_id', $employeeList, $value = null, array('id'=>'employee_id', 'class' => 'form-control select2', 'required'=>"" ,'onchange'=>"getBranchEmployeesByEmp(this.value, 'cr_branch_reliever')",'placeholder'=>'Select a Employee')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Current Branch Reliever</label>
        <div class="col-md-8">
            {!! Form::select('cr_branch_reliever', $employeeList, $value = null, array('id'=>'cr_branch_reliever', 'class' => 'form-control select2')) !!}
        </div>
    </div>

{{--for Aro And Bro--}}
 
<div class="form-group">
    <label class="col-md-4 control-label">Working At</label>
    <div class="col-md-8">
        {!! Form::select('working_at', $branch, $value = null, ['id' => 'working_at', 'class' => 'form-control select2']) !!}
    </div>
</div>


    <div class="form-group">
        <label class="col-md-4 control-label">Job Status<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('job_status_id', $jobStatus, $value = null, array('id'=>'job_status_id', 'class' => 'form-control select2', 'required'=>"")) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Transfer to Branch/Division<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('branch_id', $branchList, $value = null, ['class' => 'form-control select2', 'id'=>'branch_id','placeholder'=>'Please Select', 'onchange'=>"getBranchDivisionList(this.value, 'division_id');getCurrentBranchEmployees(this.value, 'reporting_officer')"]) !!}
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-4 control-label">Transfer to Division</label>
        <div class="col-md-8">
            {{--{!! Form::select('br_division_id', $branchDivisionList, $value = null, ['class' => 'form-control', 'id'=>'division_id', 'required'=>"", 'onchange'=>"getBranchDivisionDepartmentList(this.value, 'department_id')"]) !!}--}}
            {!! Form::select('br_division_id', ['' => '--Please Select--']+$branchDivisionList, $value = null, ['class' => 'form-control','placeholder'=>'Please Select', 'id'=>'division_id', 'onchange'=>"getBranchDivisionDepartmentList(this.value, 'department_id')"]) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Transfer to Department</label>
        <div class="col-md-8">
            {!! Form::select('br_department_id', ['' => '--Please Select--']+$branchDepartmentList, $value = null, array('id'=>'department_id','placeholder'=>'Please Select', 'class' => 'form-control')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Transfer to Unit</label>
        <div class="col-md-8">
            {!! Form::select('br_unit_id', ['' => '--Please Select--']+$branchUnitList, $value = null, array('id'=>'unit_id','placeholder'=>'Please Select', 'class' => 'form-control',)) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Posted Branch Reporter</label>
        <div class="col-md-8">
            {!! Form::select('reporting_officer', $employeeList, $value = null, array('id'=>'reporting_officer', 'class' => 'form-control select2')) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Accommodation<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('accommodation', ['' => '--Please Select--']+$confirmation, $value = null, array('id'=>'accommodation', 'class' => 'form-control', 'required'=>"")) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Transfer Type<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('transfer_type_id', $transferType, $value = null, ['class' => 'form-control select2', 'id'=>'transfer_type_id', 'required'=>""]) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Transfer Reference</label>
        <div class="col-md-8">
            {!! Form::text('transfer_reference', $value = null, ['class' => 'form-control', 'id'=>'transfer_reference']) !!}
        </div>
    </div>

    @php
        $effective_date = null;
        if(@$empPostingInfo->effective_date != '')
        $effective_date = date('d/m/Y', strtotime($empPostingInfo->effective_date));
    @endphp
    <div class="form-group">
        <label class="col-md-4 control-label">Effective Date<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('effective_date', $value = $effective_date, array('id'=>'effective_date', 'autocomplete'=>'off', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'required'=>"")) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Handover/Takeover Done</label>
        <div class="col-md-8">
            {!! Form::select('handover_status', ['' => '--Please Select--']+$confirmation, $value = null, array('id'=>'handover_status', 'class' => 'form-control', 'required'=>"")) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">IPLA Flag<span class="required">*</span></label>
        <div class="col-md-8">
            <?php
            $ipla_flags = [];
            $br_head = null;
            $cluster_head = null;
            $dept_head = null;

            if (isset($empPostingInfo->ipal_flag)) {
                $ipla_flags = json_decode($empPostingInfo->ipal_flag);
            }
            if (isset($empPostingInfo->br_head)) {
                $br_head = $empPostingInfo->br_head;
            }
            if (isset($empPostingInfo->cluster_head)) {
                $cluster_head = $empPostingInfo->cluster_head;
            }
            if (isset($empPostingInfo->dept_head)) {
                $dept_head = $empPostingInfo->dept_head;
            }

            ?>
            <div class="mt-checkbox-inline">
                <label class="mt-checkbox">
                    {{--<input class="checkboxes" type="checkbox" id="inlineCheckbox1" value="increment" name="ipal_flag[]">Increment--}}
                    <input type="checkbox" id="inlineCheckbox1" value="increment"
                           name="ipal_flag[]"{{ (in_array('increment', $ipla_flags)) ? ' checked="checked"':'' }}>
                    Increment
                    <span></span>
                </label>
                <label class="mt-checkbox">
                    {{--<input class="checkboxes" type="checkbox" id="inlineCheckbox2" value="pay-slip" name="ipal_flag[]">Pay Slip--}}
                    <input type="checkbox" id="inlineCheckbox2" value="pay-slip"
                           name="ipal_flag[]"{{ (in_array('pay-slip', $ipla_flags)) ? ' checked="checked"':'' }}> Pay
                    Slip
                    <span></span>
                </label>
                <label class="mt-checkbox">
                    {{--<input class="checkboxes" type="checkbox" id="inlineCheckbox3" value="leave" name="ipal_flag[]">Leave--}}
                    <input type="checkbox" id="inlineCheckbox3" value="leave"
                           name="ipal_flag[]"{{ (in_array('leave', $ipla_flags)) ? ' checked="checked"':'' }}> Leave
                    <span></span>
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Head</label>
        <div class="col-md-8">
            <div class="mt-checkbox-inline">
                <label class="mt-checkbox">
                    <input type="checkbox" id="checkbox" value="1"
                           name="br_head"{{ $br_head == '1' ? ' checked="checked"':'' }}> Branch/Division
                    {{--<input class="checkboxes" type="checkbox" id="br_head" name="br_head" value="1"> Branch/Division--}}
                    <span></span>
                </label>
                <label class="mt-checkbox">
                    <input class="checkbox" type="checkbox" id="cluster_head" name="cluster_head" value="1"
                            {{ $cluster_head == '1' ? ' checked="checked"':'' }}> Cluster
                    <span></span>
                </label>
                <label class="mt-checkbox">
                    <input class="checkbox" type="checkbox" id="dept_head" name="dept_head" value="1"
                            {{ $dept_head == '1' ? ' checked="checked"':'' }}> Department
                    <span></span>
                </label>

            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Functional Designation/Role</label>
        <div class="col-md-8">
            {!! Form::select('functional_designation', $functionalDesignations, $value = null, ['class' => 'form-control', 'id'=>'functional_designation','placeholder'=>'Select Functional Designation', 'onchange'=>'showClusterBrancheArea()']) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Transfer Order</label>
        <div class="col-md-8">
            {!! Form::file(str_replace(" ", "_",'t_order_file'), $value = null, array('id'=>'t_order_file','class' => 'form-control')) !!}
            {{--<a href="{{ asset('uploads/employeedata/' . ($leaveApplication->employee_id ?? '') . '/leave/'.($leaveApplication->leaveAttachment->attachment ?? '') ) }}" target="_blank"><i class="fa fa-eye">View File</i></a>--}}
            @if($errors->has('t_order_file'))<span>{{ $errors->first('t_order_file') }}</span>@endif
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button type="submit" class="btn btn-success">Submit</button>
        <a class="btn btn-primary" href="{{url('/employeeTransfer') }}"> Cancel</a>
    </div>
</div>
