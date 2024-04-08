<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Holiday Date<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::date('holiday_date', $value = null, array('id'=>'holiday_date', 'class' => 'form-control ', 'required'=>"")) !!}
			@if($errors->has('holiday_date'))<span class="required">{{ $errors->first('holiday_date') }}</span>@endif
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Holiday Description<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::textarea('description', $value = null, array('id'=>'description', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('description'))<span class="required">{{ $errors->first('description') }}</span>@endif
		</div>
	</div>


	
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/holiday') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>