<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Tour Types<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('tour_types', $value = null, array('id'=>'tour_types', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('tour_types'))<span class="required">{{ $errors->first('tour_types') }}</span>@endif
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
			<a href="{{  url('/tour-type') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>