<h3 class="block">{{$employee->name}}'s Experience Information <br>
	<h4>Employee ID:{{$employee->employee_id}} <br>
		File NO:{{$employeeDetails->personal_file_no}}</h4>

<h3 class="block">Professional Experience</h3>
<?php
$experienceEmployeeID = null;
if(@$employee->employee_id)
	$experienceEmployeeID = $employee->employee_id;
?>
{!! Form::hidden('experience_employee_id', @$experienceEmployeeID, array('id'=>'experience_employee_id', 'class' => 'form-control')) !!}

<table class="table">
	<thead>
		<tr>
			<th>Serial</th>
			<th>Industry Type</th>
			<th>Designation</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Duration</th>
			<th>Job Desc</th>
			<th>Org. Name</th>
			<th>Org. Address</th>
			<th>Action</th>
		</tr>
	</thead>
	@foreach($employeeExperiences as $employeeExperience)
	<tr>
		<td>{{ $employeeExperience->serial }}</td>
		<td>{{ $employeeExperience->industryType->industry_type ?? '' }}</td>
		<td>{{ $employeeExperience->designation }}</td>
		<td>{{ $employeeExperience->start_date }}</td>
		<td>{{ $employeeExperience->end_date }}</td>
		<td>{{ $employeeExperience->duration }}</td>
		<td>{{ $employeeExperience->job_description }}</td>
		<td>{{ $employeeExperience->organization_name }}</td>
		<td>{{ $employeeExperience->organization_address }}</td>
		<td>
			<a href="javascript:;" onclick="experienceModal('{{ $employeeExperience->id }}')"><i class="fa fa-pencil" aria-hidden="true"></i></a>
			<a href="{{ url('/deleteExperience/'.$employeeExperience->id) }}" style="color: red" onclick="return confirm('Are you sure?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
		</td>
	</tr>
	@endforeach
</table>

{{--
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Serial</label>
			<div class="col-md-8">
				{!! Form::text('serial', $value = null, array('id'=>'serial', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>
	</div>
	--}}

	<div class="row">
		<table class="table" id="experienceInfo">
			<tr>
				<th width="2%"><input type="checkbox" /></th>
				<td>
					<table class="table">
						<tr>
							<td>
								<div class="form-group">
									<label class="col-md-4 control-label">Industry Type</label>
									<div class="col-md-8">
										{!! Form::select('industry_type_id[]', $industryTypeList, $value = null, array('id'=>'industry_type_id', 'class' => 'form-control')) !!}
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="col-md-4 control-label">Designation</label>
									<div class="col-md-8">
										{!! Form::text('designation[]', $value = null, array('id'=>'designation', 'class' => 'form-control')) !!}
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="col-md-4 control-label">Start Date</label>
									<div class="col-md-8">
										{!! Form::text('exp_start_date[]', $value = null, array('id'=>'exp_start_date', 'class' => 'form-control date-picker', 'autocomplete' => 'off', 'readonly' => 'readonly')) !!}
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label class="col-md-4 control-label">End Date</label>
									<div class="col-md-8">
										{!! Form::text('exp_end_date[]', $value = null, array('id'=>'exp_end_date', 'class' => 'form-control date-picker', 'autocomplete' => 'off', 'readonly' => 'readonly')) !!}
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="col-md-4 control-label">Duration</label>
									<div class="col-md-8">
										{!! Form::text('duration[]', $value = null, array('id'=>'duration', 'class' => 'form-control')) !!}
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="col-md-4 control-label">Job Description</label>
									<div class="col-md-8">
										{!! Form::text('job_description[]', $value = null, array('id'=>'job_description', 'class' => 'form-control')) !!}
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label class="col-md-4 control-label">Organization Name</label>
									<div class="col-md-8">
										{!! Form::text('organization_name[]', $value = null, array('id'=>'organization_name', 'class' => 'form-control')) !!}
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="col-md-4 control-label">Organization Address</label>
									<div class="col-md-8">
										{!! Form::text('organization_address[]', $value = null, array('id'=>'organization_address', 'class' => 'form-control')) !!}
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="col-md-4 control-label">Line Manager Note</label>
									<div class="col-md-8">
										{!! Form::text('supervisor_note[]', $value = null, array('id'=>'supervisor_note', 'class' => 'form-control')) !!}
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label class="col-md-4 control-label">Contact Number</label>
									<div class="col-md-8">
										{!! Form::text('contact_number[]', $value = null, array('id'=>'contact_number', 'class' => 'form-control')) !!}
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="col-md-4 control-label">Position Reports To</label>
									<div class="col-md-8">
										{!! Form::text('position_reports_to[]', $value = null, array('id'=>'position_reports_to', 'class' => 'form-control')) !!}
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="col-md-4 control-label">Last Salary</label>
									<div class="col-md-8">
										{!! Form::text('last_salary[]', $value = null, array('id'=>'last_salary', 'class' => 'form-control')) !!}
									</div>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<div class="actionBar">
			<a onclick="tableAddRow('experienceInfo')" class="btn pull-right"><i class="fa fa-plus-square fa-2x" aria-hidden="true"></i></a>
			<a onclick="tableDeleteRow('experienceInfo')" class="btn pull-right"><i class="fa fa-minus-square fa-2x" aria-hidden="true" style="color: red"></i></a>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
		<div class="form-group">
			<label class="col-md-4 control-label">Extracurriculum Activity</label>
			<div class="col-md-8">
				<?php
				$empSelectedItems = [];
				if(!empty($employeeActivities)) {
					foreach ($employeeActivities as $empActivity) {
						array_push($empSelectedItems, $empActivity->activity_name);
					}
				}
				?>
				<select multiple="multiple" class="multi-select" id="my_multi_select3" name="extra_activity[]">
					@foreach($extracurriculumActivity as $curriculumActivity)
					<option value="{{$curriculumActivity->activity_name}}"{{ (in_array($curriculumActivity->activity_name, $empSelectedItems)) ? " selected":""}}>{{$curriculumActivity->activity_name}}</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>
	</div>

	<h3 class="block">Reference Information</h3>

	<div class="row">
		<table class="table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Address</th>
					<th>Phone</th>
					<th>Organization</th>
					<th>Designation</th>
					<th>Department</th>
					<th>E-mail</th>
					<th>Action</th>
				</tr>
			</thead>
			<?php $refRequiredStatus = 'required=""'; ?>
			@foreach($employeeReferences as $employeeReference)
			<?php $refRequiredStatus = ''; ?>
			<tr>
				<td> {{ $employeeReference->ref_name }} </td>
				<td> {{ $employeeReference->ref_address }} </td>
				<td> {{ $employeeReference->ref_phone }} </td>
				<td> {{ $employeeReference->ref_organization }} </td>
				<td> {{ $employeeReference->ref_designation }} </td>
				<td> {{ $employeeReference->ref_department }} </td>
				<td> {{ $employeeReference->ref_email }} </td>
				<td>
					<a href="javascript:;" onclick="referenceInfoModal('{{ $employeeReference->id }}')"><i class="fa fa-pencil" aria-hidden="true"></i></a>
					<a href="{{ url('/deleteReferenceInfo/'.$employeeReference->id) }}" style="color: red" onclick="return confirm('Are you sure?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
				</td>
			</tr>
			@endforeach
		</table>


		<table class="table">
			<thead>
				<tr>
					<th width="5%"></th>
					<th width="10%">Name</th>
					<th width="10%">Address</th>
					<th width="10%">Phone</th>
					<th width="10%">Organization</th>
					<th width="10%">Designation</th>
					<th width="10%">Department</th>
					<th width="10%">E-mail</th>
					<th width="10%">Comment</th>
				</tr>
			</thead>
		</table>
		<table class="table" id="referenceInfo">
			<tr>
				<th width="2%"><input type="checkbox" /></th>
				<td width="10%">
					{!! Form::text('ref_name[]', $value = null, array('id'=>'ref_name', 'class' => 'form-control')) !!}
				</td>
				<td width="10%">
					{!! Form::text('ref_address[]', $value = null, array('id'=>'ref_address', 'class' => 'form-control')) !!}
				</td>
				<td width="10%">
					{!! Form::text('ref_phone[]', $value = null, array('id'=>'ref_phone', 'class' => 'form-control')) !!}
				</td>
				<td width="10%">
					{!! Form::text('ref_organization[]', $value = null, array('id'=>'ref_organization', 'class' => 'form-control')) !!}
				</td>
				<td width="10%">
					{!! Form::text('ref_designation[]', $value = null, array('id'=>'ref_designation', 'class' => 'form-control')) !!}
				</td>
				<td width="10%">
					{!! Form::text('ref_department[]', $value = null, array('id'=>'ref_department', 'class' => 'form-control')) !!}
				</td>
				<td width="10%">
					{!! Form::text('ref_email[]', $value = null, array('id'=>'ref_email', 'class' => 'form-control')) !!}
				</td>
				<td width="10%">
					{!! Form::text('ref_comments[]', $value = null, array('id'=>'ref_comments', 'class' => 'form-control')) !!}
				</td>
			</tr>
		</table>
		<div class="actionBar">
			<a onclick="tableAddRow('referenceInfo')" class="btn pull-right"><i class="fa fa-plus-square fa-2x" aria-hidden="true"></i></a>
			<a onclick="tableDeleteRow('referenceInfo')" class="btn pull-right"><i class="fa fa-minus-square fa-2x" aria-hidden="true" style="color: red"></i></a>
		</div>
	</div>

	<h3 class="block">Nominee Information</h3>

	<div class="row">
		<table class="table">
			<thead>
				<tr>
					<th>Nominee No</th>
					<th>Nominee Name</th>
					<th>Relation</th>
					<th>Mobile No</th>
					<th>NID / Passport / Birth Certificate No</th>
					<th>Date of Birth</th>
					<th>Age</th>
					<th>Address</th>
					<th>Distribution</th>
					<th>Action</th>
				</tr>
			</thead>
			<?php $nomRequiredStatus = 'required=""'; ?>
			@foreach($employeeNominees as $employeeNominee)
			<?php $nomRequiredStatus = ''; ?>
			<tr>
				<td> {{ $employeeNominee->nominee_no }} </td>
				<td> {{ $employeeNominee->nominee_name }} </td>
				<td> {{ $employeeNominee->relation }} </td>
				<td> {{ $employeeNominee->mobile_no }} </td>
				<td> {{ $employeeNominee->nid_birth_cert_pass }} </td>
				<td> {{ $employeeNominee->nominee_birth_date }} </td>
				<td> {{ $employeeNominee->nominee_age }} </td>
				<td> {{ $employeeNominee->address }} </td>
				<td> {{ $employeeNominee->distribution_percent }} </td>
				<td>
					<a href="javascript:;" onclick="nomineeInfoModal('{{ $employeeNominee->id }}')"><i class="fa fa-pencil" aria-hidden="true"></i></a>
					<a href="{{ url('/deleteNomineeInfo/'.$employeeNominee->id) }}" style="color: red" onclick="return confirm('Are you sure?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
				</td>
			</tr>
			@endforeach
		</table>

		<table class="table">
			<thead>
				<tr>
					<th width="4%"></th>
					<th width="10%">Nominee Name<span class="required">*</span></th>
					<th width="10%">Relation<span class="required">*</span></th>
					<th width="10%">Mobile No<span class="required">*</span></th>
					<th width="10%">NID / Passport / Birth Certificate No<span class="required">*</span></th>
					<th width="10%">Date of Birth</th>
					<th width="5%">Age</th>
					<th width="10%">Address</th>
					<th width="10%">Distribution</th>
				</tr>
			</thead>
		</table>
		<table class="table" id="nomineeInfo">
			<tr>
				<th width="2%"><input type="checkbox" /></th>
				<td width="10%">
					{!! Form::text('nominee_name[]', $value = null, array('id'=>'nominee_name', 'class' => 'form-control', $nomRequiredStatus)) !!}
				</td>
				<td width="10%">
					{!! Form::text('relation[]', $value = null, array('id'=>'relation', 'class' => 'form-control', $nomRequiredStatus)) !!}
				</td>
				<td width="10%">
					{!! Form::text('nominee_mobile_no[]', $value = null, array('id'=>'nominee_mobile_no', 'class' => 'form-control')) !!}
				</td>
				<td width="10%">
					{!! Form::text('nid_birth_cert_pass[]', $value = null, array('id'=>'nid_birth_cert_pass', 'class' => 'form-control')) !!}
				</td>
				<td width="10%">
					{!! Form::text('nominee_birth_date[]', $value = null, array('id'=>'nominee_birth_date', 'class' => 'form-control nominee_birth_date date-picker', 'autocomplete' => 'off', 'readonly' => 'readonly')) !!}
				</td>
				<td width="5%">
					{!! Form::text('nominee_age[]', $value = null, array('id'=>'nominee_age', 'class' => 'form-control', 'readonly' => 'readonly')) !!}
				</td>
				<td width="10%">
					{!! Form::text('address[]', $value = null, array('id'=>'address', 'class' => 'form-control')) !!}
				</td>
				<td width="10%">
					{!! Form::text('distribution_percent[]', $value = null, array('id'=>'distribution_percent', 'class' => 'form-control')) !!}
				</td>
			</tr>
		</table>
		<div class="actionBar">
			<a onclick="tableAddRow('nomineeInfo')" class="btn pull-right"><i class="fa fa-plus-square fa-2x" aria-hidden="true"></i></a>
			<a onclick="tableDeleteRow('nomineeInfo')" class="btn pull-right"><i class="fa fa-minus-square fa-2x" aria-hidden="true" style="color: red"></i></a>
		</div>
	</div>


	<div class="form-group">
		<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
			<button type="button" class="btn btn-success" onclick="updateExperienceInfo()">Update</button>
			<a class="btn btn-primary" href="{{url('/employee') }}"> Cancel</a>
		</div>
	</div>