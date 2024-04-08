<h3 class="block">{{$employee->name}}'s Skill Information <br>
	<h4 class="block">Employee ID:{{$employee->employee_id}} <br>
		File NO:{{$employeeDetails->personal_file_no}}</h4>
<h3 class="block">Computer Skill</h3>
<?php
$skillEmployeeID = null;
if(@$employee->employee_id)
	$skillEmployeeID = $employee->employee_id;
?>
{!! Form::hidden('skill_employee_id', $value = $skillEmployeeID, array('id'=>'skill_employee_id', 'class' => 'form-control')) !!}
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="col-md-4 control-label">General Skill</label>
			<div class="col-md-8">
				<?php
				$selectedItems = [];
				if(@$employeeDetails->computer_skills != '') {
					$selectedItems = json_decode($employeeDetails->computer_skills);
				}
				?>
				<select multiple="multiple" class="multi-select" id="my_multi_select1" name="computer_skills[]">
					@foreach($computerGeneralSkills as $generalSkill)
					<option value="{{$generalSkill->skill_name}}"{{ (in_array($generalSkill->skill_name, $selectedItems)) ? " selected":""}}>{{$generalSkill->skill_name}}</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="col-md-3 control-label">Technical Skill</label>
			<div class="col-md-9">
				<?php
				$selectedItems = [];
				if(@$employeeDetails->technical_skills != '') {
					$selectedItems = json_decode($employeeDetails->technical_skills);
				}
				?>
				<select multiple="multiple" class="multi-select" id="my_multi_select2" name="technical_skills[]">
					@foreach($computerTechnicalSkills as $technicalSkill)
					<option value="{{$technicalSkill->skill_name}}"{{ (in_array($technicalSkill->skill_name, $selectedItems)) ? " selected":""}}>{{$technicalSkill->skill_name}}</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-11">
		<div class="form-group">
			<label class="col-md-2 control-label">Special Qualification</label>
			<div class="col-md-10">
				{!! Form::textarea('special_qualification', $value = @$employeeDetails->special_qualification, array('id'=>'special_qualification', 'class' => 'form-control', 'rows' => '5')) !!}
			</div>
		</div>
	</div>
</div>

<h3 class="block">Language Proficiency</h3>

<div class="row">
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
				{!! Form::select('reading[]', [""=>"--Please Select--"]+$proficiency_level, $value = $bnReading, array('id'=>'reading', 'class' => 'form-control')) !!}
			</td>
			<td width="10%">
				{!! Form::select('writing[]', [""=>"--Please Select--"]+$proficiency_level, $value = $bnWriting, array('id'=>'writing', 'class' => 'form-control')) !!}
			</td>
			<td width="10%">
				{!! Form::select('listening[]', [""=>"--Please Select--"]+$proficiency_level, $value = $bnListening, array('id'=>'listening', 'class' => 'form-control')) !!}
			</td>
			<td width="10%">
				{!! Form::select('speaking[]', [""=>"--Please Select--"]+$proficiency_level, $value = $bnSpeaking, array('id'=>'speaking', 'class' => 'form-control')) !!}
			</td>
		</tr>
		<tr>
			<td width="10%">
				<input type="hidden" name="language[]" value="English" />
				English
			</td>
			<td width="10%">
				{!! Form::select('reading[]', [""=>"--Please Select--"]+$proficiency_level, $value = $enReading, array('id'=>'reading', 'class' => 'form-control')) !!}
			</td>
			<td width="10%">
				{!! Form::select('writing[]', [""=>"--Please Select--"]+$proficiency_level, $value = $enWriting, array('id'=>'writing', 'class' => 'form-control')) !!}
			</td>
			<td width="10%">
				{!! Form::select('listening[]', [""=>"--Please Select--"]+$proficiency_level, $value = $enListening, array('id'=>'listening', 'class' => 'form-control')) !!}
			</td>
			<td width="10%">
				{!! Form::select('speaking[]', [""=>"--Please Select--"]+$proficiency_level, $value = $enSpeaking, array('id'=>'speaking', 'class' => 'form-control')) !!}
			</td>
		</tr>
	</table>
</div>

<h3 class="block">Project Works / Publications</h3>

<div class="row">
	<table class="table">
		<thead>
			<tr>
				<th width="30%">Project  / Publication Title</th>
				<th width="30%">Details</th>
				<th width="30%">Completion / Publication Date</th>
				<th width="30%">Action</th>
			</tr>
		</thead>

		<?php 
		//$proRequiredStatus = 'required=""';
		$proRequiredStatus = '';
		?>
		@foreach($employeeProjects as $employeeProject)
		<?php $proRequiredStatus = ''; ?>
		<tr>
			<td width="30%"> {{ $employeeProject->project_title }} </td>
			<td width="30%"> {{ $employeeProject->details }} </td>
			<td width="30%"> {{ $employeeProject->completion_date }} </td>
			<td>
				<a href="javascript:;" onclick="projectModal('{{ $employeeProject->id }}')"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				<a href="{{ url('/deleteProject/'.$employeeProject->id) }}" style="color: red" onclick="return confirm('Are you sure?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
			</td>
		</tr>
		@endforeach
	</table>
	<table class="table">
		<thead>
			<tr>
				<th width="5%"></th>
				<th width="30%">Project Title<span class="required">*</span></th>
				<th width="30%">Details<span class="required">*</span></th>
				<th width="30%">Completion Date<span class="required">*</span></th>
			</tr>
		</thead>
	</table>
	<table class="table" id="projectInfo">
		<tr>
			<th width="5%"><input type="checkbox" /></th>
			<td width="30%">
				{!! Form::text('project_title[]', $value = null, array('id'=>'project_title', 'class' => 'form-control', $proRequiredStatus)) !!}
			</td>
			<td width="30%">
				{!! Form::text('details[]', $value = null, array('id'=>'details', 'class' => 'form-control', $proRequiredStatus)) !!}
			</td>
			<td width="30%">
				{!! Form::text('completion_date[]', $value = null, array('id'=>'completion_date', 'class' => 'form-control date-picker', 'readonly' => 'readonly', $proRequiredStatus)) !!}
			</td>
		</tr>
	</table>
	<div class="actionBar">
		<a onclick="tableAddRow('projectInfo')" class="btn pull-right"><i class="fa fa-plus-square fa-2x" aria-hidden="true"></i></a>
		<a onclick="tableDeleteRow('projectInfo')" class="btn pull-right"><i class="fa fa-minus-square fa-2x" aria-hidden="true" style="color: red"></i></a>
	</div>
</div>

<h3 class="block">Specialization</h3>

<div class="row">
	<table class="table">
		<thead>
			<tr>
				<th width="45%">Specialization</th>
				<th width="45%">Details</th>
				<th width="30%">Action</th>
			</tr>
		</thead>
		<?php 
		//$spRequiredStatus = 'required=""';
		$spRequiredStatus = '';
		?>
		@foreach($employeeSpecializations as $employeeSpecialization)
		<?php $spRequiredStatus = ''; ?>
		<tr>
			<td width="30%"> {{ @$employeeSpecialization->specialize->specilized_area }} </td>
			<td width="30%"> {{ $employeeSpecialization->details }} </td>
			<td>
				<a href="javascript:;" onclick="specializationModal('{{ $employeeSpecialization->id }}')"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				<a href="{{ url('/deleteSpecialization/'.$employeeSpecialization->id) }}" style="color: red" onclick="return confirm('Are you sure?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
			</td>
		</tr>
		@endforeach
	</table>

	<table class="table">
		<thead>
			<tr>
				<th width="5%"></th>
				<th width="30%">Specialization<span class="required">*</span></th>
				<th width="30%">Details(Specify Core Concentration)<span class="required">*</span></th>
			</tr>
		</thead>
	</table>
	<table class="table" id="specializationInfo">
		<tr>
			<th width="5%"><input type="checkbox" /></th>
			<td width="45%">
				{!! Form::select('specialization_area[]', $specializationArea, $value = null, array('id'=>'specialization_area', 'class' => 'form-control', $spRequiredStatus)) !!}
			</td>
			<td width="45%">
				{!! Form::text('specialization_details[]', $value = null, array('id'=>'specialization_details', 'class' => 'form-control')) !!}
			</td>
		</tr>
	</table>
	<div class="actionBar">
		<a onclick="tableAddRow('specializationInfo')" class="btn pull-right"><i class="fa fa-plus-square fa-2x" aria-hidden="true"></i></a>
		<a onclick="tableDeleteRow('specializationInfo')" class="btn pull-right"><i class="fa fa-minus-square fa-2x" aria-hidden="true" style="color: red"></i></a>
	</div>
</div>

<div class="form-group">
	<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
		<button type="button" class="btn btn-success" onclick="updateUserSkillInfo()">Update</button>
		<a class="btn btn-primary" href="{{url('/employee') }}"> Cancel</a>
	</div>
</div>