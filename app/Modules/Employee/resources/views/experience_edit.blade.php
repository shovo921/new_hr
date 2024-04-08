{{Form::model($experienceInfo,['url'=>['experienceUpdate',$experienceInfo->id],'method'=>'put', 'class' => 'form-horizontal'])}}

<div class="form-body">
	<div class="row">
		{{--<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">Serial<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('serial', $value = null, array('id'=>'serial', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>--}}

		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">Industry Type<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::select('industry_type_id', $industryTypeList, $value = null, array('id'=>'industry_type_id', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">Designation<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('designation', $value = null, array('id'=>'designation', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>

		<?php
		$start_date = '';
		$end_date = '';
		if($experienceInfo->start_date != '')
			$start_date = date('d/m/Y', strtotime($experienceInfo->start_date));
		if($experienceInfo->end_date != '')
			$end_date = date('d/m/Y', strtotime($experienceInfo->end_date));
		?>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">Start Date<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('start_date', @$start_date, array('id'=>'start_date', 'class' => 'form-control date-picker', 'required'=>"", 'readonly' => 'readonly')) !!}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">End Date<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('end_date', @$end_date, array('id'=>'end_date', 'class' => 'form-control date-picker', 'required'=>"", 'readonly' => 'readonly')) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">Duration<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('duration', $value = null, array('id'=>'duration', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">Job Description<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('job_description', $value = null, array('id'=>'job_description', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">Organization Name<span class="required">*</span></label>
				<div class="col-md-8">
					{!! Form::text('organization_name', $value = null, array('id'=>'organization_name', 'class' => 'form-control', 'required'=>"")) !!}
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">Organization Address</label>
				<div class="col-md-8">
					{!! Form::text('organization_address', $value = null, array('id'=>'organization_address', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">Supervisor Name</label>
				<div class="col-md-8">
					{!! Form::text('supervisor_name', $value = null, array('id'=>'supervisor_name', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">Supervisor Note</label>
				<div class="col-md-8">
					{!! Form::text('supervisor_note', $value = null, array('id'=>'supervisor_note', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">Contact Number</label>
				<div class="col-md-8">
					{!! Form::text('contact_number', $value = null, array('id'=>'contact_number', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">Position Reports To</label>
				<div class="col-md-8">
					{!! Form::text('position_reports_to', $value = null, array('id'=>'position_reports_to', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">Last Salary</label>
				<div class="col-md-8">
					{!! Form::text('last_salary', $value = null, array('id'=>'last_salary', 'class' => 'form-control')) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Update', array('class' => "btn btn-primary")) !!} &nbsp;
			<button type="button" class="btn dark btn-outline" data-dismiss="modal">Back</button>
		</div>

	</div>
</div>

{{Form::close()}}