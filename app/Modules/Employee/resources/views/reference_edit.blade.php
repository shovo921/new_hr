{{Form::model($referenceInfo,['url'=>['referenceInfoUpdate',$referenceInfo->id],'method'=>'put', 'class' => 'form-horizontal'])}}

	<div class="form-body">
		<div class="form-group">
			<label class="col-md-4 control-label">Name<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::text('ref_name', $value = null, array('id'=>'ref_name', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">Address<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::text('ref_address', $value = null, array('id'=>'ref_address', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">Phone<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::text('ref_phone', $value = null, array('id'=>'ref_phone', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">Organization<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::text('ref_organization', $value = null, array('id'=>'ref_organization', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">Designation<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::text('ref_designation', $value = null, array('id'=>'ref_designation', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">Department</label>
			<div class="col-md-8">
				{!! Form::text('ref_department', $value = null, array('id'=>'ref_department', 'class' => 'form-control')) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">E-Mail</label>
			<div class="col-md-8">
				{!! Form::text('ref_email', $value = null, array('id'=>'ref_email', 'class' => 'form-control')) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">Comments</label>
			<div class="col-md-8">
				{!! Form::text('ref_comments', $value = null, array('id'=>'ref_comments', 'class' => 'form-control')) !!}
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