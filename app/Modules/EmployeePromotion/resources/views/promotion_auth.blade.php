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
						<span class="caption-subject bold uppercase">Employee Increment Authorization List</span>
					</div>
					<div class="tools"> </div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
						<thead>
							<tr>
								<th class="all">Employee</th>
								<th class="all">Branch/Division</th>
								<th class="min-phone-l">Previous Designation</th>
								<th class="min-phone-l">Promotion Designation</th>
								<th class="desktop">Promotion Date</th>
								<th class="desktop">Status</th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							@foreach($promotionHistoryInfo as $promotionHistory)                                  
							<tr>
								<td>{{$promotionHistory->employee->employee_name}} - {{ (($promotionHistory->employee->prefix != '') ? $promotionHistory->employee->prefix.'-':'') . $promotionHistory->employee_id }}</td>
								<td>{{ $promotionHistory->employee->branch_name??'' }}</td>
								<td>{{ $promotionHistory->pre_designation->designation?? '' }}</td>
								<td>{{ $promotionHistory->prom_designation->designation??'' }}</td>
								<td>{{ $promotionHistory->promotion_date??'' }}</td>
								<td> 
									{!! ($promotionHistory->authorize_status == 1) ? 'Authorized' : 'Not Authorized' !!}
								</td>
								<td>
									<a href="{{ url('authorizedPromotionView/'.$promotionHistory->employee_id.'') }}" class="btn btn-circle btn green btn-sm purple pull-left" onclick="return confirm('Are you sure?')">
										<i class="fa fa-check"></i> Authorized</a>

									<a href="{{ url('cancelPromotion/'.$promotionHistory->employee_id.'') }}" class="btn btn-circle btn green btn-sm red pull-left" onclick="return confirm('Are you sure?')">
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
