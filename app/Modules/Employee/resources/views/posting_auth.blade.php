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
			<span>Employee</span>
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
						<span class="caption-subject bold uppercase">Employee posting Authorization List</span>
					</div>
					<div class="tools"> </div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
						<thead>
							<tr>
								<th class="all">Employee ID</th>
								<th class="all">Employee Name</th>
								<th class="all">Designation</th>
								<th class="all">Functional Designation</th>
								<th class="all">Transfer Type</th>
								<th class="min-phone-l">Posting Branch</th>
								<th class="desktop">Effective Date</th>
								<th class="desktop">Status</th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							@foreach($postingInfo as $posting)

							<tr>

								<td>{{ (($posting->employee->prefix != '') ? $posting->employee->prefix.'-':'') . $posting->employee_id }}</td>
								<td>{{ $posting->employee->employee_name ?? '' }}</td>
								<td>{{ $posting->designation->designation ?? '' }}</td>
								<td>{{ @$posting->functionalDesignation->designation }}</td>
								<td>{{ $posting->transferType->transfer_type ?? '' }}</td>
								<td>{{ $posting->branch->branch_name ?? '' }}</td>
								<td>{{ $posting->effective_date}}</td>
								<td>
									@if($posting->posting_status == 1)
										Approved
									@elseif($posting->posting_status == 2)
										Pending
									@elseif($posting->posting_status == 3)
										Canceled
									@endif
								</td>
								<td>
									<a href="{{ url('viewPostingHistory/'.$posting->employee_id.'') }}" class="btn btn-circle btn blue btn-sm pull-left"><i class="fa fa-eye"></i> View</a>

									<a href="{{ url('authorizedPosting/'.$posting->employee_id.'') }}" class="btn btn-circle btn btn-sm purple pull-left" onclick="return confirm('Are you sure?')"><i class="fa fa-check"></i> Approve</a>

									<a href="{{ url('postingHistory/'.$posting->employee_id.'') }}" class="btn btn-circle btn default btn-sm pull-left"><i class="fa fa-check"></i> History</a>


									<a href="{{ url('cancelPosting/'.$posting->employee_id.'') }}" class="btn btn-circle btn btn-sm red pull-left" onclick="return confirm('Are you sure?')">
										<i class="fa fa-trash" aria-hidden="true"></i> Cancel</a> 
								</td>

							</tr>
							@endforeach
						</tbody>
					</table></div>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
		</div>
	</div>
	<!-- END CONTENT BODY -->
@stop
