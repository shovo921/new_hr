
{{Form::model($employeeProfDegree,['url'=>['employeeProfEducationUpdate',$employeeProfDegree->id],'method'=>'put', 'class' => 'form-horizontal'])}}

<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Institute Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('institute_name', $professionalInstitue, $value = null, array('id'=>'institute_name', 'class' => 'form-control', 'required'=>"")) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Course/Subject<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('course', $value = null, array('id'=>'course', 'class' => 'form-control', 'required'=>"")) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Start Date<span class="required">*</span></label>
		<div class="col-md-8">
			<?php
			$course_start_date = date('d/m/Y', strtotime($employeeProfDegree->course_start_date));
			$course_end_date = date('d/m/Y', strtotime($employeeProfDegree->course_end_date));
			$course_passed_date = date('d/m/Y', strtotime($employeeProfDegree->course_passed_date));
			?>
			{!! Form::text('course_start_date', @$course_start_date, array('id'=>'course_start_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'required'=>"", 'readonly' => 'readonly')) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">End Date<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('course_end_date', @$course_end_date, array('id'=>'course_end_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'required'=>"", 'readonly' => 'readonly')) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Passed Date<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('course_passed_date', @$course_passed_date, array('id'=>'course_passed_date', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'required'=>"", 'readonly' => 'readonly')) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Result<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('course_result', $value = null, array('id'=>'course_result', 'class' => 'form-control', 'required'=>"")) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Location</label>
		<div class="col-md-8">
			{!! Form::text('course_location', $value = null, array('id'=>'course_location', 'class' => 'form-control')) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Remarks</label>
		<div class="col-md-8">
			{!! Form::text('course_remarks', $value = null, array('id'=>'course_remarks', 'class' => 'form-control')) !!}
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
