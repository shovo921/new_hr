<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Job Status<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('job_status', $value = null, array('id'=>'job_status', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('job_status'))<span class="required">{{ $errors->first('job_status') }}</span>@endif
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
			<a href="{{  url('/job-status') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>