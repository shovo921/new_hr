<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Specilized Area<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('specilized_area', $value = null, array('id'=>'specilized_area', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('specilized_area'))<span class="required">{{ $errors->first('specilized_area') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/specialization') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>