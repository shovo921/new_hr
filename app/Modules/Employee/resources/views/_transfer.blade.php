<h3 class="block">Transfer / Posting</h3>
<?php
$tarnsferEmployeeID = null;
if(@$employee->employee_id)
	$tarnsferEmployeeID = $employee->employee_id;
?>
{!! Form::hidden('transfer_employee_id', $value = $tarnsferEmployeeID, array('id'=>'transfer_employee_id', 'class' => 'form-control')) !!}

<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Job Status<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::select('job_status_id', $jobStatus, $value = @$employeePostings->job_status_id, array('id'=>'job_status_id', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Branch<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::select('branch_id', $branchList, @$employeePostings->branch_id, ['class' => 'form-control select2', 'id'=>'branch_id', 'required'=>"", 'onchange'=>"getBranchDivisionListEdit(this.value, 'division_id')"]) !!}
			</div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Branch Division<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::select('br_division_id', $branchDivisionList, @$employeePostings->br_division_id, ['class' => 'form-control', 'id'=>'division_id', 'required'=>"", 'onchange'=>"getBranchDivisionDepartmentListEdit(this.value, 'department_id')"]) !!}
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Department<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::select('br_department_id', $branchDepartmentList, @$employeePostings->br_department_id, array('id'=>'department_id', 'class' => 'form-control', 'required'=>"", 'onchange'=>"getBranchDivisionDepartmentUnitListEdit(this.value, 'unit_id')")) !!}
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Unit</label>
			<div class="col-md-8">
				{!! Form::select('br_unit_id', $branchUnitList, @$employeePostings->br_unit_id, array('id'=>'unit_id', 'class' => 'form-control')) !!}
			</div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Reporting Officer<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::select('reporting_officer', $employeeList, @$employeePostings->reporting_officer, ['class' => 'form-control', 'id'=>'reporting_officer', 'required'=>""]) !!}
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Accommodation<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::select('accommodation', ['' => '--Please Select--']+$confirmation, $value = @$employeePostings->accommodation, array('id'=>'accommodation', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Transfer Type<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::select('transfer_type_id', $transferType, @$employeePostings->transfer_type_id, ['class' => 'form-control', 'id'=>'transfer_type_id', 'required'=>""]) !!}
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Effective Date<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::text('effective_date', $value = @$employeePostings->effective_date, array('id'=>'effective_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'required'=>"", 'readonly' => 'readonly')) !!}
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Handover/Takeover Done<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::select('handover_status', ['' => '--Please Select--']+$confirmation, $value = @$employeePostings->handover_status, array('id'=>'handover_status', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="form-group">
			<label class="col-md-3 control-label">IPLA Flag <span class="required">*</span></label>
			<div class="col-md-9">
				<?php
				$ipla_flags = [];
				if(isset($employeePostings->ipal_flag)) {
					$ipla_flags = json_decode($employeePostings->ipal_flag);

				}
				?>
				<div class="mt-checkbox-inline">
					<label class="mt-checkbox">
						<input type="checkbox" id="inlineCheckbox1" value="increment" name="ipal_flag[]"{{ (in_array('increment', $ipla_flags)) ? ' checked="checked"':'' }}> Increment
						<span></span>
					</label>
					<label class="mt-checkbox">
						<input type="checkbox" id="inlineCheckbox2" value="pay-slip" name="ipal_flag[]"{{ (in_array('pay-slip', $ipla_flags)) ? ' checked="checked"':'' }}> Pay Slip
						<span></span>
					</label>
					<label class="mt-checkbox">
						<input type="checkbox" id="inlineCheckbox3" value="leave" name="ipal_flag[]"{{ (in_array('leave', $ipla_flags)) ? ' checked="checked"':'' }}>  Leave
						<span></span>
					</label>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Functional Designation </label>
			<div class="col-md-8">
				{!! Form::select('functional_designation', $functionalDesignations, @$employeePostings->functional_designation, ['class' => 'form-control', 'id'=>'functional_designation', 'onchange'=>'showClusterBranches()']) !!}
			</div>
		</div>
	</div>

	<div class="col-md-8<?php echo (@$employeePostings->cluster_branches != '') ? '':' hidden'; ?>" id="clusterBranchesArea">
		<div class="form-group">
			<label class="col-md-4 control-label">Select Branches</label>
			<div class="col-md-8">
				<?php
				$selectedBranches = [];
				if(@$employeePostings->cluster_branches != '') {
					$selectedBranches = json_decode($employeePostings->cluster_branches);
				}
				?>
				<select multiple="multiple" class="multi-select" id="my_multi_select2" name="cluster_branches[]">
					@foreach($allBranch as $branch)
					<option value="{{ $branch->id }}"{{ (in_array($branch->id, $selectedBranches)) ? " selected":""}}>
						{{ $branch->branch_name }}
					</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
		<button type="button" class="btn btn-success" onclick="updateTransferInfo()">Update</button>
		<a class="btn btn-primary" href="{{url('/employee') }}"> Cancel</a>
	</div>
</div>