<div class="form-body">


	<div class="form-group">
		<label class="col-md-4 control-label">Education Level<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('edu_level', $educationExamLevels, $value = null, array('id'=>'edu_level', 'class' => 'form-control select2', 'required'=>"")) !!}
			@if($errors->has('edu_level'))<span class="required">{{ $errors->first('edu_level') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Exam Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('examination', $value = null, array('id'=>'examination', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('examination'))<span class="required">{{ $errors->first('examination') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Status<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('status', $status,$value = null, array('id'=>'status', 'class' => 'form-control select2', 'required'=>"")) !!}
			@if($errors->has('status'))<span class="required">{{ $errors->first('status') }}</span>@endif
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/education-exam') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>