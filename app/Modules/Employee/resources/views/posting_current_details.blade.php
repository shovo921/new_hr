@extends('layouts.app')
@include('layouts.menu')
@section('breadcrumb')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{ url('/') }}">Home</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<span>employee</span>
		</li>
	</ul>
	<div class="page-toolbar">
		<div class="pull-right">
			<i class="icon-calendar"></i>&nbsp;
			<span class="thin uppercase hidden-xs">{{ date('D, M d, Y') }}</span>&nbsp;
		</div>
	</div>
</div>
<!-- END PAGE BAR -->
@stop

@section('content')

<div class="row">
	<div class="page-title">Employee Details View</div>

	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-gift"></i>Profile Information</div>
		</div>
		<div class="portlet-body">
			<table class="table">
				<tr>
					<th>Name</th>
					<td>{{ @$employee->name }}</td>
					<th>Email</th>
					<td>{{ @$employee->email }}</td>
				</tr>
				<tr>
					<th>Employee ID</th>
					<td>{{ ((@$employee->prefix != '') ? @$employee->prefix.'-':'') . @$employee->employee_id }}</td>
					<th>Mobile No.</th>
					<td>{{ @$employee->mobile_no }}</td>
				</tr>
			</table>
			
		</div>
	</div>

	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-gift"></i>Transfer/Posting Information</div>
		</div>
		<?php /*dd($employeePostings) */?>
		<div class="portlet-body">
			<table class="table">
				<tr>
					<th>Job Status</th>
					<td>{{ $employeePostings->jobStatusInfo->job_status ?? ''}}</td>
				</tr>
				<tr>
					<th>Designation</th>
					<td>{{ @$employeePostings->employee->designation ?? ''}}</td>
				</tr>
				<tr>
					<th>Branch</th>
					<td>{{ @$employeePostings->branch->branch_name ?? ''}}</td>
				</tr>
				<tr>
					<th>Branch Division</th>
					<td>{{ @$employeePostings->division->br_name }}</td>
				</tr>
				<tr>
					<th>Department</th>
					<td>{{ @$employeePostings->department->dept_name }}</td>
				</tr>
				<tr>
					<th>Unit</th>
					<td>{{ @$employeePostings->unit->unit_name }}</td>
				</tr>
				<tr>
					<th>Functional Designation</th>
					<td>{{ @$employeePostings->functionalDesignation->designation }}</td>
				</tr>
				{{--<tr>
					<th>Cluster Branches</th>
					<td>
						<?php
						$cluser_branches = '';
						$branchList = json_decode(@$employeePostings->cluster_branches);
						if(!empty($branchList)) {
							for ($i = 0; $i < sizeof($branchList); $i++) {
								$branch_name = getBranchNameByID($branchList[$i]);

								$cluser_branches .= $branch_name.', ';
							}
							echo rtrim($cluser_branches, ", ");
						}
						?>
					</td>
				</tr>--}}
				<tr>
					<th>Accommodation</th>
					<td>{{ $employeePostings->accommodation }}</td>
				</tr>
				<tr>
					<th>Reporting Officer</th>
					<td>{{ $employeePostings->reporting_officer }}</td>
				</tr>
				<tr>
					<th>Transfer Type</th>
					<td>{{ $employeePostings->transferType->transfer_type }}</td>
				</tr>
				<tr>
					<th>Effective Date</th>
					<td>{{ $employeePostings->effective_date }}</td>
				</tr>
				<tr>
					<th>Handover/Takeover Done</th>
					<td>{{ $employeePostings->handover_status }}</td>
				</tr>
				<tr>
					<th>Branch/Division Head</th>
					<td>{{ $employeePostings->br_head == 1 ? 'Yes': 'No' }}</td>
				</tr>
				<tr>
					<th>Cluster Head</th>
					<td>{{ $employeePostings->cluster_head == 1 ? 'Yes': 'No' }}</td>
				</tr>
				<tr>
					<th>IPAL Flag</th>
					<td>{{ $employeePostings->ipal_flag }}</td>
				</tr>
				@if($employeePostings->working_at)
					<tr>
						<th>Working At</th>
						<td>{{ $employeePostings->branch_name->branch_name }}</td>
					</tr>
				@endif

			</table>
		</div>
	</div>
</div>
</div>

@stop