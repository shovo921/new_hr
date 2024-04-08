{{Form::model($specializationInfo,['url'=>['specializationUpdate',$specializationInfo->id],'method'=>'put', 'class' => 'form-horizontal'])}}

	<div class="form-body">
		<div class="form-group">
			<label class="col-md-4 control-label">Specialization<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::select('specialization_area', $specializationArea, $value = null, array('id'=>'specialization_area', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">Details<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::text('details', $value = null, array('id'=>'details', 'class' => 'form-control', 'required'=>"")) !!}
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