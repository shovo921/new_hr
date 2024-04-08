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

<div class="modal fade" id="salOrIncrementAuthModal" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Employee Increment Authorization</h4>
			</div>
			<div class="modal-body" id="salOrIncrementAuth">
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

@stop

@section('css')
<link href="{{ asset('assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('script')
<script src="{{ asset('assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}" type="text/javascript"></script>
{{--<script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
<script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>--}}

<script src="{{ asset('assets/global/scripts/jquery.smartWizard.js') }}" type="text/javascript"></script>


<script type="text/javascript">

	var base_url = "{{ URL::to('/') }}";

	$('.date-picker').datepicker({
		autoclose: true,
        todayHighlight: true,
        format: 'dd/mm/yyyy',
        orientation: "bottom",
        maxDate: '0'
	});
</script>

<script src="{{ asset('assets/my_scripts/employee_increment.js') }}" type="text/javascript"></script>

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