<div class="form-body">

	<div class="form-group">
		<label class="col-md-4 control-label">Deduction Type Description<span class="required">*</span></label>
		<div class="col-md-8">

			{!! Form::text('description', $value = null, array('id'=>'description','placeholder'=>'Please Give DeductionType Description', 'class' => 'form-control', 'required'=>"")) !!}

			@if($errors->has('description'))<span
					class="required">{{ $errors->first('description') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Status<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('status', $status, $value = null, array('id'=>'status', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('status'))<span class="required">{{ $errors->first('status') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('deduction-type') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>