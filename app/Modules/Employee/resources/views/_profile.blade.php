<h3 class="block">{{$employee->name}}'s profile details <br>
	<h4 class="block">Employee ID:{{$employee->employee_id}} <br>
		File NO:{{$employeeDetails->personal_file_no}}</h4>


<?php
$profileEmployeeID = null;
if(@$employee->employee_id)
	$profileEmployeeID = $employee->employee_id;
?>
{!! Form::hidden('profile_employee_id', $value = $profileEmployeeID, array('id'=>'profile_employee_id')) !!}

<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Father's Name<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::text('father_name', $value = @$employeeDetails->father_name, array('id'=>'father_name', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Mother's Name<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::text('mother_name', $value = @$employeeDetails->mother_name, array('id'=>'mother_name', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Marital Status<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::select('marital_status',['' => '--Please Select--']+$maritialList, @$employeeDetails->marital_status, ['id'=>'marital_status', 'class' => 'form-control js-example-basic-single', 'required'=>""]) !!}
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Spouse Name</label>
			<div class="col-md-8">
				<?php
				$spouse_required = '';
				if($employeeDetails->marital_status == 'Married')
					$spouse_required = 'required=""';
				?>
				{!! Form::text('spouse_name', $value = @$employeeDetails->spouse_name, array('id'=>'spouse_name', 'class' => 'form-control', $spouse_required)) !!}
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Marriage Date</label>
			<div class="col-md-8">
				<?php
				$marriage_date = null;

				if(@$employeeDetails->marriage_date != '') {
					$marriage_date = date('d/m/Y', strtotime($employeeDetails->marriage_date));
				}
				?>
				{!! Form::text('marriage_date', $value = @$marriage_date, array('id'=>'marriage_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker')) !!}
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Nationality<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::select('nationality',['' => '--Please Select--']+$nationalityList, @$employeeDetails->nationality, ['class' => 'form-control js-example-basic-single', 'id'=>'nationality', 'required'=>""]) !!}
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Birth Place<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::select('birth_place', $districtList, $value = @$employeeDetails->birth_place, array('id'=>'birth_place', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Gender<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::select('gender', ['' => '--Please Select--']+$genderList, $value = @$employeeDetails->gender, array('id'=>'gender', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Blood Group<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::select('blood_group',['' => '--Please Select--']+$bloodList, @$employeeDetails->blood_group, ['id'=>'blood_group', 'class' => 'form-control js-example-basic-single', 'required'=>""]) !!}
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Religion<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::select('religion',['' => '--Please Select--']+$religionList, @trim($employeeDetails->religion), ['id'=>'religion', 'class' => 'form-control js-example-basic-single', 'required'=>""]) !!}
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Phone Number<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::text('phone_no', $value = @$employeeDetails->phone_no, array('id'=>'phone_no', 'placeholder'=>'Phone Number', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-4 control-label">Date of Birth<span class="required">*</span></label>
			<div class="col-md-8">
				<?php
				$birthdate = null;

				if(@$employeeDetails->birth_date != '') {
					$birthdate = date('d/m/Y', strtotime($employeeDetails->birth_date));
				}
				?>
				{!! Form::text('birth_date', $value = $birthdate, array('id'=>'birth_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'required'=>"", 'readonly' => 'readonly')) !!}
			</div>
		</div>
	</div>
</div>

{{--
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Issue Date</label>
				<div class="col-md-8">
					<?php
					$ISSUE_DATE = null;

					if(@$employeeDetails->issue_date != '') {
						$ISSUE_DATE = date('d/m/Y', strtotime($employeeDetails->issue_date));
					}
					?>
					{!! Form::text('issue_date', $value = $ISSUE_DATE, array('id'=>'issue_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'readonly' => 'readonly')) !!}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Expiry Date</label>
				<div class="col-md-8">
					<?php
					$EXPIRE_DATE = null;

					if(@$employeeDetails->expire_date != '') {
						$EXPIRE_DATE = date('d/m/Y', strtotime($employeeDetails->expire_date));
					}
					?>
					{!! Form::text('expire_date', $value = @$EXPIRE_DATE, array('id'=>'expire_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'readonly' => 'readonly')) !!}
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Marriage Date</label>
				<div class="col-md-8">
					<?php
					$marriage_date = null;

					if(@$employeeDetails->marriage_date != '') {
						$marriage_date = date('d/m/Y', strtotime($employeeDetails->marriage_date));
					}
					?>
					{!! Form::text('marriage_date', $value = @$marriage_date, array('id'=>'marriage_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'readonly' => 'readonly')) !!} 
				</div>
			</div>
		</div>
	</div>
	--}}

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Appointment Issue Date</label>
				<div class="col-md-8">
					<?php
					$appointment_date = null;

					if(@$employeeDetails->appointment_date != '') {
						$appointment_date = date('d/m/Y', strtotime($employeeDetails->appointment_date));
					}
					?>
					{!! Form::text('appointment_date', $value = $appointment_date, array('id'=>'appointment_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'readonly' => 'readonly')) !!}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Appointment Ref. No.</label>
				<div class="col-md-8">
					{!! Form::text('appointment_ref_no', $value = $value = @$employeeDetails->appointment_ref_no, array('id'=>'appointment_ref_no', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
		@if (in_array(auth()->user()->role_id,['1','3']))
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Offered Post<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::select('offered_designation_id', $designations, @$employeeDetails->offered_designation_id, ['id'=>'offered_designation_id', 'class' => 'form-control', 'required'=>""]) !!}
				</div>
			</div>
		</div>
		@endif
		@if (in_array(auth()->user()->role_id,['21','2']))
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Offered Post<span class="required">*</span></label>

				<div class="col-md-8">
					{!! Form::text('designation', $value = @$employeeDetails->designation, array('id'=>'designation','readonly' => 'readonly', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
		@endif
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Current Designation<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::select('designation_id', $designations, @$employeeDetails->designation_id, ['id'=>'designation_id', 'class' => 'form-control', 'required'=>""]) !!}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">National ID<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('nid', $value = @$employeeDetails->nid, array('id'=>'nid', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">TIN</label>
				<div class="col-md-8">
					{!! Form::text('tin', $value = @$employeeDetails->tin, array('id'=>'tin', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>


	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Passport No</label>
				<div class="col-md-8">
					{!! Form::text('passport_no', $value = @$employeeDetails->passport_no, array('id'=>'passport_no', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Passport Issue Date</label>
				<div class="col-md-8">
					<?php
					$passport_issue_date = null;

					if(@$employeeDetails->passport_issue_date != '') {
						$passport_issue_date = date('d/m/Y', strtotime($employeeDetails->passport_issue_date));
					}
					?>
					{!! Form::text('passport_issue_date', $value = $passport_issue_date, array('id'=>'passport_issue_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker')) !!}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Passport Expiry Date</label>
				<div class="col-md-8">
					{!! Form::text('passport_expire_date', $value = @$employeeDetails->passport_expire_date, array('id'=>'passport_expire_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker')) !!}
				</div>
			</div>
		</div>


	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Recruitment Type<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::select('recruitment_type', $recruitmentType, @$employeeDetails->recruitment_type, ['id'=>'recruitment_type', 'class' => 'form-control', 'required'=>""]) !!}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Batch No for MTO</label>
				<div class="col-md-8">
					{!! Form::text('batch_no_for_mto', $value = @$employeeDetails->batch_no_for_mto, array('id'=>'batch_no_for_mto', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Identification Mark</label>
				<div class="col-md-8">
					{!! Form::text('identification_mark', $value = @$employeeDetails->identification_mark, array('id'=>'identification_mark', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>


	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Driving License</label>
				<div class="col-md-8">
					{!! Form::text('driving_license', $value = @$employeeDetails->driving_license, array('id'=>'driving_license', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
	</div>
		@if (in_array(auth()->user()->role_id,['1','3']))
			<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Status of Release Order</label>
				<div class="col-md-8">
					{!! Form::select('release_order_type', [""=>"--Please Select--"]+$releaseOrderTypes, @$employeeDetails->release_order_type, ['id'=>'release_order_type', 'class' => 'form-control']) !!}
				</div>
			</div>
		</div>
		<div class="hidden" id="releaseArea">
			<div class="col-md-4">
				<div class="form-group">
					<label class="col-md-4 control-label">Condition Start Date</label>
					<div class="col-md-8">

						<?php
						$cond_release_start_date = null;

						if(@$employeeDetails->cond_release_start_date != '') {
							$cond_release_start_date = date('d/m/Y', strtotime($employeeDetails->cond_release_start_date));
						}
						?>
                            {!! Form::text('cond_release_start_date', $value = @$employeeDetails->cond_release_start_date, array('id'=>'cond_release_start_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'readonly' => 'readonly')) !!}
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="col-md-4 control-label">Condition End Date</label>
					<div class="col-md-8">

						<?php
						$cond_release_end_date = null;

						if(@$employeeDetails->cond_release_end_date != '') {
							$cond_release_end_date = date('d/m/Y', strtotime($employeeDetails->cond_release_end_date));
						}
						?>
						{!! Form::text('cond_release_end_date', $value = @$employeeDetails->cond_release_end_date, array('id'=>'cond_release_end_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'readonly' => 'readonly')) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endif

	<div class="row">

		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">KINSHIP Declaration</label>
				<div class="col-md-8">
					<div class="mt-radio-inline">
						<label class="mt-radio">
							<input type="radio" name="kinship_declaration" id="kinship_declaration1" value="Yes"{{(@$employeeDetails->kinship_declaration == 'Yes') ? ' checked':''}} /> Yes
							<span></span>
						</label>
						<label class="mt-radio">
							<input type="radio" name="kinship_declaration" id="kinship_declaration2" value="No"{{(@$employeeDetails->kinship_declaration != 'Yes') ? ' checked':''}} /> No
							<span></span>
						</label>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row{{(@$employeeDetails->kinship_declaration == 'Yes') ? '':' hidden'}}" id="kinshipArea">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Relation</label>
				<div class="col-md-8">
					{!! Form::text('relation', $value = @$employeeKinship->relation, array('id'=>'relation', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Relative Employee ID</label>
				<div class="col-md-8">
					{!! Form::text('relative_employee_id', $value = @$employeeKinship->relative_employee_id, array('id'=>'relative_employee_id', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>

		<div class="col-md-4" id="employee_info">
		</div>
	</div>

	<h3 class="block">Permanent Address Information</h3>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Address<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('par_info_address', $value = @$employeeDetails->par_info_address, array('id'=>'par_info_address', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Village</label>
				<div class="col-md-8">
					{!! Form::text('par_info_village', $value = @$employeeDetails->par_info_village, array('id'=>'par_info_village', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Post Office<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('par_info_post_office', $value = @$employeeDetails->par_info_post_office, array('id'=>'par_info_post_office', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Division<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::select('par_info_division', $divisionList, $value = @$employeeDetails->par_info_division, array('id'=>'par_info_division', 'class' => 'form-control', 'required'=>"", 'onchange'=>"getEmployeeDistrictList(this.value, 'par_info_district')")) !!}
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">District<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::select('par_info_district', $districtList, $value = @$employeeDetails->par_info_district, array('id'=>'par_info_district', 'class' => 'form-control', 'required'=>"", 'onchange'=>"getEmployeeThanaList(this.value, 'par_info_thana')")) !!}
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Thana<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::select('par_info_thana', $thanaList, $value = @$employeeDetails->par_info_thana, array('id'=>'par_info_thana', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>
	</div>

	<h3 class="block">Present Address Information</h3>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Address<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('pre_info_address', $value = @$employeeDetails->pre_info_address, array('id'=>'pre_info_address', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Village</label>
				<div class="col-md-8">
					{!! Form::text('pre_info_village', $value = @$employeeDetails->pre_info_village, array('id'=>'pre_info_village', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Post Office<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('pre_info_post_office', $value = @$employeeDetails->pre_info_post_office, array('id'=>'pre_info_post_office', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Division<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::select('pre_info_division', $divisionList, $value = @$employeeDetails->pre_info_division, array('id'=>'pre_info_division', 'class' => 'form-control', 'required'=>"", 'onchange'=>"getEmployeeDistrictList(this.value, 'pre_info_district')")) !!}
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">District<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::select('pre_info_district', $districtList, $value = @$employeeDetails->pre_info_district, array('id'=>'pre_info_district', 'class' => 'form-control', 'required'=>"", 'onchange'=>"getEmployeeThanaList(this.value, 'pre_info_thana')")) !!}
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Thana<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::select('pre_info_thana', $thanaList, $value = @$employeeDetails->pre_info_thana, array('id'=>'pre_info_thana', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>
	</div>

	<h3 class="block">Children Information</h3>

	<div class="row">
		@if(!empty($employeeChildrens))
		<table class="table">
			<thead>
				<tr>
					<th width="20%">Name</th>
					<th width="20%">Age</th>
					<th width="20%">Gender</th>
					<th width="20%">Education</th>
					<th width="20%">Action</th>
				</tr>
			</thead>
			<?php $childRequiredStatus = 'required=""'; ?>
			@foreach($employeeChildrens as $employeeChildren)
			<?php $childRequiredStatus = ''; ?>
			<tr>
				<td width="20%"> {{ $employeeChildren->child_name }} </td>
				<td width="20%"> {{ $employeeChildren->child_age }} </td>
				<td width="20%"> {{ $employeeChildren->child_gender }} </td>
				<td width="20%"> {{ $employeeChildren->child_education }} </td>
				<td width="20%">
					<a href="javascript:;" onclick="childrenInfoModal('{{ $employeeChildren->id }}')"><i class="fa fa-pencil" aria-hidden="true"></i></a>
					<a href="{{ url('/deleteChildrenInfo/'.$employeeChildren->id) }}" style="color: red" onclick="return confirm('Are you sure?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
				</td>
			</tr>
			@endforeach
		</table>
		@endif

		<table class="table">
			<thead>
				<tr>
					<th width="5%"></th>
					<th width="20%">Name</th>
					<th width="20%">Age</th>
					<th width="20%">Gender</th>
					<th width="20%">Education</th>
					<th width="20%">Remarks</th>
				</tr>
			</thead>
		</table>
		<table class="table" id="childrenInfo">
			<tr>
				<th><input type="checkbox" /></th>
				<td width="20%">
					{!! Form::text('child_name[]', $value = null, array('id'=>'child_name', 'class' => 'form-control')) !!}
				</td>
				<td width="20%">
						@php
						$childbirthdate = '';

						if(@$employeeChildren->child_age != '') {
							$childbirthdate = date('d/m/Y', strtotime($employeeChildren->child_age));
						}
						@endphp
				{!! Form::text('child_age[]', $value = null, array('id'=>'child_age', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker')) !!}

				{{--{!! Form::text('child_age[]', $value = null, array('id'=>'child_age', 'class' => 'form-control')) !!}--}}
				</td>
				<td width="20%">
					{!! Form::select('child_gender[]', ['' => '--Please Select--']+$genderList, $value = null, array('id'=>'child_gender', 'class' => 'form-control')) !!}
				</td>
				<td width="20%">
					{!! Form::text('child_education[]', $value = null, array('id'=>'child_education', 'class' => 'form-control')) !!}
				</td>
				<td width="20%">
					{!! Form::text('child_remarks[]', $value = null, array('id'=>'child_remarks', 'class' => 'form-control')) !!}
				</td>
			</tr>
		</table>
		<div class="actionBar">
			<a onclick="tableAddRow('childrenInfo')" class="btn pull-right"><i class="fa fa-plus-square fa-2x" aria-hidden="true"></i></a>
			<a onclick="tableDeleteRow('childrenInfo')" class="btn pull-right"><i class="fa fa-minus-square fa-2x" aria-hidden="true" style="color: red"></i></a>
		</div>
	</div>

	<h3 class="block">Emergency Contact 1 Information</h3>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Name<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('emergency_contact_name', $value = @$employeeDetails->emergency_contact_name, array('id'=>'emergency_contact_name', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Address<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('emergency_contact_address', $value = @$employeeDetails->emergency_contact_address, array('id'=>'emergency_contact_address', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Relation<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('emergency_contact_relation', $value = @$employeeDetails->emergency_contact_relation, array('id'=>'emergency_contact_relation', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Mobile No.<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('emergency_contact_mobile', $value = @$employeeDetails->emergency_contact_mobile, array('id'=>'emergency_contact_mobile', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Email</label>
				<div class="col-md-8">
					{!! Form::text('emergency_contact_email', $value = @$employeeDetails->emergency_contact_email, array('id'=>'emergency_contact_email', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">NID</label>
				<div class="col-md-8">
					{!! Form::text('emergency_contact_nid', $value = @$employeeDetails->emergency_contact_nid, array('id'=>'emergency_contact_nid', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
	</div>

	<h3 class="block">Emergency Contact 2 Information</h3>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Name</label>
				<div class="col-md-8">
					{!! Form::text('emergency_contact_name2', $value = @$employeeDetails->emergency_contact_name2, array('id'=>'emergency_contact_name2', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Address</label>
				<div class="col-md-8">
					{!! Form::text('emergency_contact_address2', $value = @$employeeDetails->emergency_contact_address2, array('id'=>'emergency_contact_address2', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Relation</label>
				<div class="col-md-8">
					{!! Form::text('emergency_contact_relation2', $value = @$employeeDetails->emergency_contact_relation2, array('id'=>'emergency_contact_relation2', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Mobile No.</label>
				<div class="col-md-8">
					{!! Form::text('emergency_contact_mobile2', $value = @$employeeDetails->emergency_contact_mobile2, array('id'=>'emergency_contact_mobile2', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">Email</label>
				<div class="col-md-8">
					{!! Form::text('emergency_contact_email2', $value = @$employeeDetails->emergency_contact_email2, array('id'=>'emergency_contact_email2', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-4 control-label">NID</label>
				<div class="col-md-8">
					{!! Form::text('emergency_contact_nid2', $value = @$employeeDetails->emergency_contact_nid2, array('id'=>'emergency_contact_nid2', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
			<button type="button" class="btn btn-success" onclick="updateUserInfo()">Update</button>
			<a class="btn btn-primary" href="{{url('/employee') }}"> Cancel</a>
		</div>
	</div>