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
								<th class="all">Employee ID</th>
								<th class="all">Employee Name</th>
								<th class="all">Designation</th>
								<th class="all">Branch/Division</th>
								<th class="min-phone-l">Increment Slab NO</th>
								<th class="desktop">Increment Date</th>
								<th class="desktop">Status</th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							@foreach($incrementHistoryInfo as $incrementHistory)                                  
							<tr>
								{{--<td>{{ (($incrementHistory->employee->prefix != '') ? $incrementHistory->employee->prefix.'-':'') . $incrementHistory->employee_id }}</td>--}}
								<td>{{ $incrementHistory->employee_id }}</td>
								<td>{{ $incrementHistory->employee->employee_name }}</td>
								<td>{{ $incrementHistory->employee->designation }}</td>
								<td>{{ $incrementHistory->employee->branch_name }}</td>
								<td>{{ $incrementHistory->inc_slave_no  == 19 ? 'No Scale' : $incrementHistory->inc_slave_no}}</td>
								<td>{{ $incrementHistory->increment_date }}</td>
								<td> 
									{!! ($incrementHistory->authorize_status == 1) ? 'Authorized' : 'Not Authorized' !!}
								</td>
								<td>
									<a href="{{ url('incrementAuthorizationView/'.$incrementHistory->employee_id.'/'.$incrementHistory->inc_slave_no.'') }}" class="btn btn-circle btn green btn-sm purple pull-left">
										<i class="fa fa-check"></i> View</a>
									{{--<a href="javascript:;" onclick="authorizeViewModal('{{ $incrementHistory->employee_id}}')" class="btn btn-circle btn green btn-sm purple pull-left">
										<i class="fa fa-check"></i> View</a>--}}


									{{--<a href="{{ url('authorizedIncrement/'.$incrementHistory->employee_id.'') }}" class="btn btn-circle btn green btn-sm purple pull-left" onclick="return confirm('Are you sure?')">
										<i class="fa fa-check"></i> Authorized</a>--}}


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

@section('css')
	<link href="{{ asset('assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
@stop


@section('script')
<script src="{{ asset('assets/my_scripts/employee_increment.js') }}" type="text/javascript"></script>


<script src="{{ asset('assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/jquery.smartWizard.js') }}" type="text/javascript"></script>
<script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

<script>
	$(document).ready(function () {
		$('#wizard').smartWizard({
			selected: 0,  // Selected Step, 0 = first step
			keyNavigation: false,
			transitionEffect: 'fade',
			enableAllSteps: true,
			enableURLhash: true,
			onLeaveStep:leaveAStepCallback
		});

		function leaveAStepCallback(obj, context){
			var stepAlertConfim = confirm("Are you sure to leaving this step");
			if(stepAlertConfim) {
				return validateSteps(context.fromStep); // return false to stay on step and true to continue navigation
			}
		}

		function validateSteps(stepnumber){
			var isStepValid = true;

			return isStepValid;
		}

		$('.buttonPrevious').addClass('btn btn-primary');
		$('.buttonNext').addClass('btn btn-success');
		$('.buttonFinish').addClass('btn btn-default');
		$('.buttonFinish').remove();

	});
</script>
@stop