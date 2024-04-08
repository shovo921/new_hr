<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Subject Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('subject_name', $value = null, array('id'=>'subject_name', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('subject_name'))<span class="required">{{ $errors->first('subject_name') }}</span>@endif
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/training-subject') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>