<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Designation<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('designation', $value = null, array('id'=>'designation', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('designation'))<span class="required">{{ $errors->first('designation') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Shortcode<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('shortcode', $value = null, array('id'=>'shortcode', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('shortcode'))<span class="required">{{ $errors->first('shortcode') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Employment Type<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('employment_type', $employmentType, $value = null, array('id'=>'employment_type', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('employment_type'))<span class="required">{{ $errors->first('employment_type') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Sorting Order<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('sorting_order', $value = null, array('id'=>'sorting_order', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('sorting_order'))<span class="required">{{ $errors->first('sorting_order') }}</span>@endif
		</div>
	</div>

	
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/designation') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>