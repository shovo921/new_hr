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
	<div class="page-title">Employee Salary</div>
	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-gift"></i>Employee Salary Information</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"> </a>
					<a href="javascript:;" class="reload"> </a>
				</div>
			</div>
		</div>
		<div class="portlet-body form">
			<div class="col-md-8">
				{!! Form::open(array('url' => 'employeeSalaryStore', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) !!}
				
					{!! Form::hidden('employee_id', $value = @$EmployeeDetailsInfo->employee_id, array('id'=>'employee_id', 'class' => 'form-control', 'required'=>"")) !!}


				<div class="form-group">
					<label class="col-md-4 control-label">Employee Designation</label>
					<div class="col-md-8">{{ @$EmployeeDetailsInfo->designationInfo->designation }}</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">Salary Status</label>
					<div class="col-md-8">
						@if(@$employeeSalaryData->authorize_status == '1')
							<span style="color:green; font-weight: bold;">Authorized</span>
						@else
							<span style="color:red; font-weight: bold;">Not Authorized</span>
						@endif
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">Current Increment Slab<span class="required">*</span></label>
					<div class="col-md-8">
						{!! Form::select('current_inc_slave', $incrementSlave, $value = @$employeeSalaryData->current_inc_slave, array('id'=>'current_inc_slave', 'class' => 'form-control', 'required'=>"", 'onchange'=>'calculateUpdateBasic(this.value, '.$EmployeeDetailsInfo->designation_id.')')) !!}

						@if($errors->has('current_inc_slave'))<span class="required">{{ $errors->first('current_inc_slave') }}</span>@endif
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">Basic Salary<span class="required">*</span></label>
					<div class="col-md-8">
						<?php
						$basic = 0;
						$houseRent = 0;

						if(@$employeeSalaryData->current_basic) {
							$basic = $employeeSalaryData->current_basic;
							$houseRent = $basic / 2;
						} else {
							$basic = $salaryBasicInfo->basic_salary;
							$houseRent = $basic / 2;
						}
						?>
						{!! Form::text('current_basic', $value = @$basic, array('id'=>'current_basic', 'class' => 'form-control', 'required'=>"", 'readonly'=>'')) !!}
						@if($errors->has('current_basic'))<span class="required">{{ $errors->first('current_basic') }}</span>@endif
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">House Rent<span class="required">*</span></label>
					<div class="col-md-8">
						{!! Form::text('house_rent', $value = @$houseRent, array('id'=>'house_rent', 'class' => 'form-control', 'required'=>"", 'readonly'=>'readonly')) !!}
						@if($errors->has('house_rent'))<span class="required">{{ $errors->first('house_rent') }}</span>@endif
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">Medical<span class="required">*</span></label>
					<div class="col-md-8">
						{!! Form::text('medical', $value = @$salaryBasicInfo->medical, array('id'=>'medical', 'class' => 'form-control', 'required'=>"", 'readonly'=>'readonly')) !!}
						@if($errors->has('medical'))<span class="required">{{ $errors->first('medical') }}</span>@endif
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">Conveyance</label>
					<div class="col-md-8">
						{!! Form::text('conveyance', $value = @$salaryBasicInfo->conveyance, array('id'=>'conveyance', 'class' => 'form-control', 'readonly'=>'readonly')) !!}
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">House Maintenance<span class="required">*</span></label>
					<div class="col-md-8">
						{!! Form::text('house_maintenance', $value = @$salaryBasicInfo->house_maintenance, array('id'=>'house_maintenance', 'class' => 'form-control', 'required'=>"", 'readonly'=>'readonly')) !!}

						@if($errors->has('house_maintenance'))<span class="required">{{ $errors->first('house_maintenance') }}</span>@endif
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">Utility<span class="required">*</span></label>
					<div class="col-md-8">
						{!! Form::text('utility', $value = @$salaryBasicInfo->utility, array('id'=>'utility', 'class' => 'form-control', 'required'=>"", 'readonly'=>'readonly')) !!}
						@if($errors->has('utility'))<span class="required">{{ $errors->first('utility') }}</span>@endif
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">LFA<span class="required">*</span></label>
					<div class="col-md-8">
						{!! Form::text('lfa', $value = @$salaryBasicInfo->lfa, array('id'=>'lfa', 'class' => 'form-control', 'required'=>"", 'readonly'=>'readonly')) !!}
						@if($errors->has('lfa'))<span class="required">{{ $errors->first('lfa') }}</span>@endif
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">OTHERS</label>
					<div class="col-md-8">
						<?php
						$others_amount = 0;
						if(@$employeeSalaryData->others) {
							$others_amount = $employeeSalaryData->others;
						}
						?>
						{!! Form::number('others', $value = $others_amount, array('id'=>'others', 'class' => 'form-control', 'onkeyup'=>'calculateGrossTotal()')) !!}
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">Gross Salary<span class="required">*</span></label>
					<div class="col-md-8">
						{!! Form::text('gross_total', $value = null, array('id'=>'gross_total', 'class' => 'form-control', 'required'=>"", 'readonly'=>'readonly')) !!}
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-4 col-md-8">
						{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
						<a href="{{  url('/employee') }}" class="btn btn-success">Back</a>
					</div>
				</div>

				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@stop

@section('script')

<script src="{{ asset('assets/my_scripts/employee.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	var getEmployeeSalarySlaveInfo = '../getEmployeeSalarySlaveInfo';

	$(document).ready(function () {
		calculateGrossTotal();
	});
</script>

@stop
