<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Institute Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('institute_name', $value = null, array('id'=>'institute_name', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('institute_name'))<span class="required">{{ $errors->first('institute_name') }}</span>@endif
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/professional-institue') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>