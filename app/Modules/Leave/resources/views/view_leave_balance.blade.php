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
			<span>Leave List</span>
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
	<div class="col-md-12" style="margin-top:20px;">                
		<div class="table-responsive">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet blue box">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-settings"></i>
						<span class="caption-subject bold uppercase">Employee Leave Balance</span>
					</div>
					<div class="tools"> </div>
				</div>
				<div class="portlet-body"> 
					<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
						<thead>
							<tr>
								<th class="all">SI No</th>
								<th class="desktop">Employee Name/ID</th>
								<th class="desktop">Leave Type</th>
								<th class="desktop">Leave Balance</th>
								<th class="desktop">Leave Taken</th>
								<th class="desktop">Last Forwarded</th>
								<th class="desktop">Future Apply</th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>

							<?php $i =0 ?> 
							@foreach($employeeLeaves as $employeeLeave)   
							<?php $i++; ?>                                           
							<tr>
								<td>{{ $i }}</td>
								<td>{{ $employeeLeave->employeeName->employee_name.'('.$employeeLeave->employee_id.')' ??''}}</td>
								<td>{{ $employeeLeave->leaveType->leave_type ?? '' }}</td>

								<td>{{ $employeeLeave->leave_balance }}</td>
								<td>{{ $employeeLeave->leave_taken }}</td>
								<td>{{ $employeeLeave->last_forwarded_leave }}</td>
								<td>{!! ($employeeLeave->future_apply == 2) ? '<font color="red">No</font>':'<font color="green">Yes</font>'!!}</td>
{{--								<td>{!! ( $employeeLeave->future_apply ==1 ?'Yes': $employeeLeave->future_apply ==2 ?'No' : 'N/A') !!}</td>--}}

								<td>
									<a href="{{ url('edit-employee-leave/'.$employeeLeave->id) }}" class="btn btn-circle btn green btn-sm purple pull-left">
										<i class="fa fa-edit"></i> Edit
									</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>
<!-- END CONTENT BODY -->


@endsection