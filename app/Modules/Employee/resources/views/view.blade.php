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

<div class="row">
	<div class="profile-userpic pull-right">
		<?php
				//$file_location = public_path() . '/uploads/'.$employeeProfilePhoto[0]->attachment;
		?>
		{{--@if(file_exists($file_location))--}}
		@if(!$employeeProfilePhoto->isEmpty())
        <img src="{{asset('uploads/'.$employeeProfilePhoto[0]->attachment )}}" class="img-responsive" alt="" width="150">
        @else
        <img src="{{asset('img/pro_avatar.png')}}" class="img-responsive" alt="" width="150">
        @endif
    </div>
	<div class="page-title">Employee Details View</div>

	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-gift"></i>Profile Information</div>
		</div>
		<div class="portlet-body">
			<table class="table">

				<tr>
					<th>Name</th>
					<td>{{$employee->employee_name }}</td>
					<th>Email</th>
					<td>{{$employee->email_id }}</td>
					<th>Employee ID</th>
					<td>{{$employee->employee_id }}</td>
					<th>Joining Date</th>
					<td>{{$employeeDetails->joining_date }}</td>
				</tr>
				<tr>

					<th>Personal File no</th>
					<td>{{ ((@$employeeDetails->prefix != '') ? @$employeeDetails->prefix.'-':'') . @$employeeDetails->personal_file_no }}</td>
					<th>Staff Type</th>
					<td>{{ @$employeeDetails->staff_type }}</td>
					<th>Mobile No.</th>
					<td>{{ @$employee->phone_no }}</td>
					<th>Employment Type</th>
					<td>{{ @$employeeDetails->employmentType->employment_type ?? '' }}</td>
				</tr>
				<tr>
					<th>Employment Period Start Date</th>
					<td>{{ @$employeeDetails->period_start_date }}</td>
					<th>Employment Period End Date</th>
					<td>{{ @$employeeDetails->period_end_date }}</td>
					<th>Father's Name</th>
					<td>{{ @$employeeDetails->father_name }}</td>
					<th>Mother's Name</th>
					<td>{{ @$employeeDetails->mother_name }}</td>
				</tr>
				<tr>
					{{--@php
					dd($employeeDetails);
					@endphp--}}
					<th>Marital Status</th>
					<td>{{ @$employeeDetails->marital_status }}</td>
					<th>Spouse Name</th>
					<td>{{ @$employeeDetails->spouse_name }}</td>
					<th>Marriage Date</th>
					<td>{{ @$employeeDetails->marriage_date }}</td>
					<th>Nationality</th>
					<td>{{ @$employeeDetails->nationality }}</td>
				</tr>
				<tr>
					<th>Birth Place</th>
					<td>{{ @$employeeDetails->empBirthPlace->name }}</td>
					<th>Gender</th>
					<td>{{ @$employeeDetails->gender }}</td>
					<th>Blood Group</th>
					<td>{{ @$employeeDetails->blood_group }}</td>
					<th>Religion</th>
					<td>{{ @$employeeDetails->religion }}</td>
				</tr>
				<tr>
					<th>Date of Birth</th>
					<td>{{ @$employeeDetails->birth_date }}</td>
					<th>Appointment Issue Date</th>
					<td>{{ @$employeeDetails->appointment_date }}</td>
					<th>Appointment Ref. No.</th>
					<td>{{ @$employeeDetails->appointment_ref_no }}</td>
					<th>Offered Post</th>
					<td>{{ @$employeeDetails->offered_designation ?? '' }}</td>
					<th>Current Designation</th>
					<td>{{ @$employeeDetails->designationInfo->designation }}</td>
				</tr>
				<tr>
					<th>National ID</th>
					<td>{{ @$employeeDetails->nid }}</td>
					<th>TIN</th>
					<td>{{ @$employeeDetails->tin }}</td>
					<th>Passport No</th>
					<td>{{ @$employeeDetails->passport_no }}</td>
					<th>Passport Issue Date</th>
					<td>{{ @$employeeDetails->passport_issue_date }}</td>
				</tr>
				<tr>
					<th>Passport Expire Date</th>
					<td>{{ @$employeeDetails->passport_expire_date }}</td>
					<th>Recruitment Type</th>
					<td>{{ @$employeeDetails->recruitment_type }}</td>
					<th>Batch No for MTO</th>
					<td>{{ @$employeeDetails->batch_no_for_mto }}</td>
					<th>Identification Mark</th>
					<td>{{ @$employeeDetails->identification_mark }}</td>
				</tr>
				<tr>
					<th>Driving License</th>
					<td>{{ @$employeeDetails->driving_license }}</td>
					<th>Status of Release Order</th>
					<td>{{ @$employeeDetails->release_order_type }}</td>
					<th>KINSHIP Declaration</th>
					<td>{{ @$employeeDetails->kinship_declaration }}</td>
					<th>KINSHIP Relation</th>
					<td>{{ @$employeeKinship->relation }}</td>
				</tr>
				<tr>
					<th>Relative Employee ID</th>
					<td>{{ @$employeeKinship->relative_employee_id }}</td>
				</tr>
			</table>
			<h3>Permanent Address Information</h3>
			<table class="table">
				<tr>
					<th>Address</th>
					<td>{{ @$employeeDetails->par_info_address }} </td>
					<th>Village</th>
					<td>{{  @$employeeDetails->par_info_village }} </td>
					<th>Post Office</th>
					<td>{{  @$employeeDetails->par_info_post_office }} </td>
					<th>Division</th>
					<td>{{ @$employeeDetails->par_division->name }} </td>
				</tr>
				<tr>
					<th>District</th>
					<td>{{ @$employeeDetails->par_district->name }} </td>
					<th>Thana</th>
					<td>{{ @$employeeDetails->par_thana->name }} </td>
					{{--<th>Phone No.</th>
					<td>{{  @$employeeDetails->par_info_phone }} </td>
					<th>Mobile No.</th>
					<td>{{  @$employeeDetails->par_info_mobile }}</td>--}}
				</tr>
			</table>
			<h3>Present Address Information</h3>
			<table class="table">
				<tr>
					<th>Address</th>
					<td>{{ @$employeeDetails->pre_info_address }} </td>
					<th>Village</th>
					<td>{{  @$employeeDetails->pre_info_village }} </td>
					<th>Post Office</th>
					<td>{{  @$employeeDetails->pre_info_post_office }} </td>
					<th>Division</th>
					<td>{{ @$employeeDetails->pre_division->name }} </td>
				</tr>
				<tr>
					<th>District</th>

					<td>{{ @$employeeDetails->pre_district->name }} </td>
					<th>Thana</th>
					<td>{{ @$employeeDetails->pre_thana->name }} </td>
					{{--<th>Phone No.</th>
					<td>{{  @$employeeDetails->pre_info_phone }} </td>
					<th>Mobile No.</th>
					<td>{{  @$employeeDetails->pre_info_mobile }}</td>--}}
				</tr>
			</table>

			<h3 class="block">Children Information</h3>

			<table class="table">
				<thead>
					<tr>
						<th width="20%">Name</th>
						<th width="20%">Age</th>
						<th width="20%">Gender</th>
						<th width="20%">Education</th>
					</tr>
				</thead>
				@foreach($employeeChildrens as $employeeChildren)
				<tr>
					<td width="20%"> {{ $employeeChildren->child_name }} </td>
					<td width="20%"> {{ $employeeChildren->child_age }} </td>
					<td width="20%"> {{ $employeeChildren->child_gender }} </td>
					<td width="20%"> {{ $employeeChildren->child_education }} </td>
				</tr>
				@endforeach
			</table>

			<h3>Emergency Contact 1 Information</h3>

			<table class="table">
				<tr>
					<th>Name</th>
					<td>{{ @$employeeDetails->emergency_contact_name }} </td>
					<th>Address</th>
					<td>{{  @$employeeDetails->emergency_contact_address }} </td>
					<th>Relation</th>
					<td>{{  @$employeeDetails->emergency_contact_relation }} </td>
				</tr>
				<tr>
					<th>Mobile No.</th>
					<td>{{ @$employeeDetails->emergency_contact_mobile }} </td>
					<th>Email</th>
					<td>{{ @$employeeDetails->emergency_contact_email }} </td>
					<th>NID</th>
					<td>{{ @$employeeDetails->emergency_contact_nid }} </td>
				</tr>
			</table>

			<h3>Emergency Contact 2 Information</h3>
			<table class="table">
				<tr>
					<th>Name</th>
					<td>{{ @$employeeDetails->emergency_contact_name2 ?? ''}} </td>
					<th>Address</th>
					<td>{{  @$employeeDetails->emergency_contact_address2 ?? ''}} </td>
					<th>Relation</th>
					<td>{{  @$employeeDetails->emergency_contact_relation2 ?? ''}} </td>
				</tr>
				<tr>
					<th>Mobile No.</th>
					<td>{{ @$employeeDetails->emergency_contact_mobile2 ?? ''}} </td>
					<th>Email</th>
					<td>{{ @$employeeDetails->emergency_contact_email2 ?? ''}} </td>
					<th>NID</th>
					<td>{{ @$employeeDetails->emergency_contact_nid2 ?? ''}} </td>
				</tr>
			</table>
		</div>
	</div>
	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-gift"></i>Employee Posting History</div>
		</div>
		<div class="portlet-body">
			<table class="table">
				<thead>
				<tr>
					<th class="all">Transfer Type</th>
					<th class="min-phone-l">Posting Branch</th>
					<th class="desktop">Date From</th>
					<th class="desktop">Date To</th>
					<th class="desktop">Status</th>
				</tr>
				</thead>
				<tbody>

				@foreach($postingList as $posting)
					<tr>
							<?php /*dd('$posting->designation',$posting->designation->designation) */?>
						<td>{{ $posting->transferType->transfer_type ?? '' }}</td>
						<td>{{ $posting->branch->branch_name ??'' }}</td>
						<td>{{ date('d-m-Y', strtotime($posting->effective_date))  ?? '' }}</td>
						<td>{{$posting->effective_date_to ?? ''}}</td>
						<td>{!! ($posting->posting_status == 1) ? 'Approved' : 'Pending' !!}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>

	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-gift"></i>Employee Promotion History</div>
		</div>
		<div class="portlet-body">
			<table class="table">
				<thead>
				<tr>

					<th class="all">Branch/Division</th>
					<th class="min-phone-l">Previous Designation</th>
					<th class="min-phone-l">Promotion Designation</th>
					<th class="desktop">Promotion Date</th>
					<th class="desktop">Status</th>
				</tr>
				</thead>
				<tbody>
				@foreach($promotionHistoryList as $promotionHistory)
					<tr>
						<td>{{ $promotionHistory->employee->branch_name }}</td>
						<td>{{ $promotionHistory->pre_designation->designation }}</td>
						<td>{{ $promotionHistory->prom_designation->designation }}</td>
						<td>{{ $promotionHistory->promotion_date }}</td>
						<td>
							{!! ($promotionHistory->authorize_status == 1) ? 'Authorized' : 'Not Authorized' !!}
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-gift"></i>Education Information</div>
		</div>
		<div class="portlet-body">
			<table class="table">
				<thead>
					<tr>
						<th>Level</th>
						<th>Exam</th>
						<th>Group/ Subject</th>
						<th>Institute Type</th>
						<th>Board/ Institute</th>
						<th>Passing Year</th>
						<th>Result Type</th>
						<th>Result</th>
						<th>OUT OF</th>
					</tr>
				</thead>
				<tbody>
				<?php /*dd($employeeEducations) */?>
					@foreach($employeeEducations as $employeeEducation)
					<tr>
						<td> {{ $employeeEducation->eduLevel->name ?? '' }} </td>
						<td> {{ $employeeEducation->eduExam->examination ?? '' }} </td>
						<td> {{ $employeeEducation->group->group_subject_major ?? '' }} </td>
						<td> {{ $employeeEducation->institute_type ?? '' }} </td>
						<td> {{ $employeeEducation->board->board_university_institute ?? '' }} </td>
						<td> {{ $employeeEducation->passing_year ?? '' }} </td>
						<td> {{ $employeeEducation->result_type  ?? ''}} </td>
						<td> {{ $employeeEducation->result ?? ''}} </td>
						<td> {{ $employeeEducation->out_of ?? ''}} </td>
					</tr>
					@endforeach
				</tbody>
			</table>

			<h3 class="block">Professional Degree/Diploma Information</h3>

			<table class="table">
				<thead>
					<tr>
						<th width="10%">Institute Name</th>
						<th width="10%">Course/Subject</th>
						<th width="10%">Start Date</th>
						<th width="10%">End Date</th>
						<th width="10%">Passed Date</th>
						<th width="10%">Result</th>
						<th width="10%">Location</th>
						<th width="10%">Remarks</th>
					</tr>
				</thead>
				@foreach($EmployeeProfessionalDegrees as $professionalDegree)
				<tr>
					<td width="10%"> {{ $professionalDegree->profInstitue->institute_name ?? ''}} </td>
					<td width="10%"> {{ $professionalDegree->course?? '' }} </td>
					<td width="10%"> {{ $professionalDegree->course_start_date ?? ''}} </td>
					<td width="10%"> {{ $professionalDegree->course_end_date ?? ''}} </td>
					<td width="10%"> {{ $professionalDegree->course_passed_date ?? ''}} </td>
					<td width="10%"> {{ $professionalDegree->course_result ?? '' }} </td>
					<td width="10%"> {{ $professionalDegree->course_location ?? ''}} </td>
					<td width="10%"> {{ $professionalDegree->course_remarks ?? ''}} </td>
				</tr>
				@endforeach
			</table>

			<h3 class="block">Professional Training Information</h3>

			<table class="table">
				<thead>
					<tr>
						<th width="10%">Organization Name</th>
						<th width="10%">Subject</th>
						<th width="10%">Start Date</th>
						<th width="10%">End Date</th>
						<th width="10%">Passed Date</th>
						<th width="10%">Training Type</th>
						<th width="10%">Venue</th>
					</tr>
				</thead>
				@foreach($employeeTrainings as $employeeTraining)
				<tr>
					<td width="10%"> {{ $employeeTraining->orgName->organization_name ?? ''}} </td>
					<td width="10%"> {{ $employeeTraining->subjectName->subject_name ?? ''}} </td>
					<td width="10%"> {{ $employeeTraining->start_date ?? ''}} </td>
					<td width="10%"> {{ $employeeTraining->end_date ?? ''}} </td>
					<td width="10%"> {{ $employeeTraining->passed_date ?? ''}} </td>
					<td width="10%"> {{ $employeeTraining->traning_type ?? ''}} </td>
					<td width="10%"> {{ $employeeTraining->venue ?? ''}} </td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>

	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-gift"></i>Skill Information</div>
		</div>
		<div class="portlet-body">
			
			<h3 class="block">Skills</h3>

			<table class="table">
				<tr>
					<th>Computer Skill</th>
					<td>{{ @implode(',', json_decode($employeeDetails->computer_skills)) }}</td>
					<th>Technical Skill</th>
					<td>{{ @implode(',', json_decode($employeeDetails->technical_skills)) }}</td>
				</tr>
				<tr>
					<th>Special Qualification</th>
					<td>{{ @$employeeDetails->special_qualification }}</td>
					<th>&nbsp;</th>
					<td>&nbsp;</td>
				</tr>
			</table>


			<h3 class="block">Language Proficiency</h3>

			<table class="table">
				<thead>
					<tr>
						<th width="10%">Language</th>
						<th width="10%">Reading</th>
						<th width="10%">Writing</th>
						<th width="10%">Listening</th>
						<th width="10%">Speaking</th>
					</tr>
				</thead>
				<?php
				$bnReading = null;
				$bnWriting = null;
				$bnListening = null;
				$bnSpeaking = null;

				$enReading = null;
				$enWriting = null;
				$enListening = null;
				$enSpeaking = null;

				if(isset($employeeLanguages[0]->reading)) {
					$bnReading = $employeeLanguages[0]->reading;
					$bnWriting = $employeeLanguages[0]->writing;
					$bnListening = $employeeLanguages[0]->listening;
					$bnSpeaking = $employeeLanguages[0]->speaking;
				}
				if(isset($employeeLanguages[1]->reading)) {
					$enReading = $employeeLanguages[1]->reading;
					$enWriting = $employeeLanguages[1]->writing;
					$enListening = $employeeLanguages[1]->listening;
					$enSpeaking = $employeeLanguages[1]->speaking;
				}
				?>
				<tr>
					<td width="10%">
						<input type="hidden" name="language[]" value="Bangla" />
						Bangla
					</td>
					<td width="10%">
						{{ $bnReading }}
					</td>
					<td width="10%">
						{{ $bnWriting }}
					</td>
					<td width="10%">
						{{ $bnListening }}
					</td>
					<td width="10%">
						{{ $bnSpeaking }}
					</td>
				</tr>
				<tr>
					<td width="10%">
						<input type="hidden" name="language[]" value="English" />
						English
					</td>
					<td width="10%">
						{{ $enReading }}
					</td>
					<td width="10%">
						{{ $enWriting }}
					</td>
					<td width="10%">
						{{ $enListening }}
					</td>
					<td width="10%">
						{{ $enSpeaking }}
					</td>
				</tr>
			</table>

			<h3 class="block">Project Works / Publications</h3>

			<table class="table">
				<thead>
					<tr>
						<th width="30%">Project  / Publication Title</th>
						<th width="30%">Details</th>
						<th width="30%">Completion Date</th>
					</tr>
				</thead>
				@foreach($employeeProjects as $employeeProject)
				<tr>
					<td width="30%"> {{ $employeeProject->project_title ?? ''}} </td>
					<td width="30%"> {{ $employeeProject->details ?? ''}} </td>
					<td width="30%"> {{ $employeeProject->completion_date ?? ''}} </td>
				</tr>
				@endforeach
			</table>

			<h3 class="block">Specialization</h3>

			<table class="table">
				<thead>
					<tr>
						<th width="45%">Specialization</th>
						<th width="45%">Details</th>
					</tr>
				</thead>
				@foreach($employeeSpecializations as $employeeSpecialization)
				<tr>
					<td width="45%"> {{ $employeeSpecialization->specialize->specialization_area ?? ''}} </td>
					<td width="45%"> {{ $employeeSpecialization->details ?? ''}} </td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>

	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-gift"></i>Transfer/Posting Information</div>
		</div>
		<div class="portlet-body">
			<table class="table">
				<tr>

					<th>Job Status</th>
					<td>{{ @$employeePostings->jobStatusInfo->job_status ?? ''}}</td>
					<th>Designation</th>
					<td>{{ @$employeePostings->designation_id }}</td>
					<th>Branch</th>
					<td>{{ @$employeePostings->branchInfo->branch_name ?? '' }}</td>
					<th>Branch Division</th>
					<td>{{ @$employeePostings->br_division_id }}</td>
					<th>Department</th>
					<td>{{ @$employeePostings->br_department_id }}</td>
				</tr>
				<tr>
					<th>Unit</th>
					<td>{{ @$employeePostings->br_unit_id }}</td>
					<th>Functional Designation</th>
					<td>{{ @$employeePostings->functionalDesignation->designation }}</td>
					<th>Accommodation</th>
					<td>{{ @$employeePostings->accommodation }}</td>
					<th>Reporting Officer</th>
					<td>{{ @$employeePostings->reporting_officer }}</td>
					<th>Transfer Type</th>
					<td>{{ @$employeePostings->transferType->transfer_type ?? ''}}</td>
				</tr>
				<tr>
					<th>Effective Date</th>
					<td>{{ @$employeePostings->effective_date }}</td>
					<th>Handover/Takeover Done</th>
					<td>{{ @$employeePostings->handover_status }}</td>
					<th>IPAL Flag</th>
					<td>{{ @$employeePostings->ipal_flag }}</td>
					<th></th>
					<td></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-gift"></i>Experience & Others Information</div>
		</div>
		<div class="portlet-body">
			<h3 class="block">Professional Experience</h3>
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
				</tr>
				@endforeach
			</table>
			<h3 class="block">Extracurriculum Activity</h3>
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Activitie</th>
					</tr>
				</thead>
				<?php $i = 1; ?>
				@foreach($employeeActivities as $employeeActivitie)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{ $employeeActivitie->activity_name }}</td>
				</tr>
				@endforeach
			</table>

			<h3 class="block">Reference Information</h3>

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
					</tr>
				</thead>
				@foreach($employeeReferences as $employeeReference)
				<tr>
					<td> {{ $employeeReference->ref_name }} </td>
					<td> {{ $employeeReference->ref_address }} </td>
					<td> {{ $employeeReference->ref_phone }} </td>
					<td> {{ $employeeReference->ref_organization }} </td>
					<td> {{ $employeeReference->ref_designation }} </td>
					<td> {{ $employeeReference->ref_department }} </td>
					<td> {{ $employeeReference->ref_email }} </td>
				</tr>
				@endforeach
			</table>

			<h3 class="block">Nominee Information</h3>

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
					</tr>
				</thead>
				@foreach($employeeNominees as $employeeNominee)
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
				</tr>
				@endforeach
			</table>
		</div>
	</div>

	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-gift"></i>Documents Information</div>
		</div>
		<div class="portlet-body">
			<table class="table">
				<thead>
					<tr>
						<th>Document Name</th>
						<th>Document</th>
						<th>Receive Date</th>
						<th>Remarks</th>
						<th>Action</th>
					</tr>
				</thead>
				@foreach($employeeDocuments as $employeeDocument)
				<tr>
					<td>{{ $employeeDocument->document->document_type ?? '' }}</td>
					<td>{{ $employeeDocument->attachment }}</td>
					<td>{{ $employeeDocument->received_date }}</td>
					<td>{{ $employeeDocument->remarks }}</td>
					<td><a href="{{ asset('uploads/'.$employeeDocument->attachment) }}" target="_blank"><i class="fa fa-eye"></i></a></td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>



</div>
</div>
@stop