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
		<div class="page-title">Leave Application Edit</div>
		<div class="col-md-9">
			{!! Form::model($leaveApplication, array('url' => 'leave/'.$leaveApplication->id, 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal')) !!}

			@include('Leave::_form')

			{!! Form::close() !!}
		</div>
	</div>

@endsection


@section('script')

	<script src="{{ asset('assets/my_scripts/leave.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
		var getLeaveTotalDays = '../../getLeaveTotalDays';

		$('.date-picker').datepicker({
			autoclose: true,
			todayHighlight: true,
			format: 'mm/dd/yyyy'
		});

		$(document).ready(function(){
			$("#leave_type_id" ).change(function() {
				var leave_type_id = $('#LEAVE_TYPE_ID').val();
				checkLeaveConditions(leave_type_id);
			}).change();
		});
		$('.date-picker1').datepicker({
			autoclose: true,
			todayHighlight: true,
			format: 'mm/dd/yyyy',
			endDate:  new Date()
		});




	</script>

	<script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
@stop