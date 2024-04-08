{{Form::model($projectInfo,['url'=>['projectUpdate',$projectInfo->id],'method'=>'put', 'class' => 'form-horizontal'])}}

	<div class="form-body">
		<div class="form-group">
			<label class="col-md-4 control-label">Project Title<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::text('project_title', $value = null, array('id'=>'project_title', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">Details<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::text('details', $value = null, array('id'=>'details', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">Completion Date</label>
			<div class="col-md-8">
				{!! Form::text('completion_date', @$projectInfo->completion_date, array('id'=>'completion_date', 'class' => 'form-control date-picker', 'required'=>"", 'readonly' => 'readonly')) !!}
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