<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Document Type<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('document_type', $value = null, array('id'=>'document_type', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('document_type'))<span class="required">{{ $errors->first('document_type') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Is Required<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('is_required', $isRequired, $value = null, array('id'=>'is_required', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('is_required'))<span class="required">{{ $errors->first('is_required') }}</span>@endif
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/document') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>