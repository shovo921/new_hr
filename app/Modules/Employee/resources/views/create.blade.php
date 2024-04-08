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

@section('css')
	<style type="text/css">
		.form_wizard .stepContainer {
			min-height: 400px!important;
		}
	</style>
@stop
@section('content')

	<div class="row">
		<div class="page-title">Employee Create</div>

		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i>Employee Information</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"> </a>
					<a href="javascript:;" class="reload"> </a>
				</div>
			</div>
			<div class="portlet-body form">
				@include('Employee::_from')
			</div>
		</div>
	</div>
	</div>

@stop
@section('script')
	<script src="{{ asset('assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/scripts/jquery.smartWizard.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/my_scripts/employee.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
		var getUpdatedEmployeeID = '../getUpdatedEmployeeID';
		var getEmployeeFileNumber = '../getEmployeeFileNumber';
		var getDistricts = '../getDistricts';
		var getThanas = '../getThanas';
		var createEmployee = '../createEmployee';


		var base_url = "{{ URL::to('/') }}";

		$('.date-picker').datepicker({
			autoclose: true,
			todayHighlight: true,
			format: 'dd/mm/yyyy',
			orientation: "bottom",
			maxDate: '0'
		});
	</script>

	<script>
		$(document).ready(function () {
			$('#wizard').smartWizard({
				selected: 0,  // Selected Step, 0 = first step
				keyNavigation: false,
				transitionEffect: 'fade',
				enableAllSteps: false,
				enableURLhash: true,
				onLeaveStep:leaveAStepCallback
			});

			function leaveAStepCallback(obj, context){
				// alert("Leaving step " + context.fromStep + " to go to step " + context.toStep);
				return validateSteps(context.fromStep); // return false to stay on step and true to continue navigation
			}

			function validateSteps(stepnumber){
				var isStepValid = true;
				// validate step 1
				/*if(stepnumber == 1){

                }*/

				return false;
			}

			$('.buttonPrevious').addClass('btn btn-primary');
			$('.buttonNext').addClass('btn btn-success');
			$('.buttonFinish').addClass('btn btn-default');
			$('.buttonFinish').remove();
		});
	</script>
@stop
