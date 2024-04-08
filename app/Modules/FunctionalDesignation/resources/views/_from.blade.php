<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Functional Designation<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('designation', $value = null, array('id'=>'designation', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('designation'))<span class="required">{{ $errors->first('designation') }}</span>@endif
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-md-4 control-label">Disciplinary Category Status<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('status', array('1'=>'Active', '2'=>'Inactive'), $value = null,  array('id'=>'status', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('status'))<span class="required">{{ $errors->first('status') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/functional-designation') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>