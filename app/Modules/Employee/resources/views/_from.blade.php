<div id="wizard" class="form_wizard wizard_horizontal">
	<ul class="wizard_steps" style="padding-top: 10px;">
		@if(!isset($user->id))
			{{--@php
			dd(!isset($user->id));
			@endphp--}}
		<li>
			<a href="#step-1">
				<span class="step_no">1</span>
				<span class="step_descr">Account Setup</span>
			</a>
		</li>
		@endif
		<li>
			<a href="#step-2">
				<span class="step_no">2</span>
				<span class="step_descr">Profile Setup</span>
			</a>
		</li>

		<li>
			<a href="#step-3">
				<span class="step_no">3</span>
				<span class="step_descr">Education</span>
			</a>
		</li>

		<li>
			<a href="#step-4">
				<span class="step_no">4</span>
				<span class="step_descr">Skills</span>
			</a>
		</li>

		<!-- <li>
			<a href="#step-5">
				<span class="step_no">5</span>
				<span class="step_descr">Transfer / Posting</span>
			</a>
		</li> -->

		<li>
			<a href="#step-6">
				<span class="step_no">5</span>
				<span class="step_descr">Experience & Others</span>
			</a>
		</li>

		<li>
			<a href="#step-7">
				<span class="step_no">6</span>
				<span class="step_descr">Documents</span>
			</a>
		</li>
	</ul>

	<div id="step-1">
		<div class="col-md-12">
			<form action="#" id="employeeAccount" role="form" class="form-horizontal">
				@include('Employee::_account')
			</form>
		</div>
	</div>

	@if(isset($employee->employee_id))
	<div id="step-2">
		<div class="col-md-12">
			<form action="#" id="employeeProfile" role="form" class="form-horizontal" enctype ="multipart/form-data">
				@include('Employee::_profile')
			</form>
		</div>
	</div>

	<div id="step-3">
		<div class="col-md-12">
			<form action="#" id="employeeOtherInfo" role="form" class="form-horizontal">
				@include('Employee::_other')
			</form>
		</div>
	</div>

	<div id="step-4">
		<div class="col-md-12">
			<form action="#" id="employeeSkillInfo" role="form" class="form-horizontal">
				@include('Employee::_skills')
			</form>
		</div>
	</div>
	{{--
	<div id="step-5">
		<div class="col-md-12">
			<form action="#" id="employeeTransfer" role="form" class="form-horizontal">
				@include('Employee::_transfer')
			</form>
		</div>
	</div>
	--}}

	<div id="step-6">
		<div class="col-md-12">
			<form action="#" id="employeeExperience" role="form" class="form-horizontal">
				@include('Employee::_experience')
			</form>
		</div>
	</div>

	<div id="step-7">
		<div class="col-md-12">
			<form action="{{ route('file.upload.post') }}" id="employeeDocument" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				@include('Employee::_documents')
			</form>
		</div>
	</div>
	@endif
</div>