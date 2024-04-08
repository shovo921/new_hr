<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Salary Head<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('salary_head', $value = null, array('id'=>'salary_head', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('salary_head'))<span class="required">{{ $errors->first('salary_head') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Is Variable?<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('is_variable', $variable_status, $value = null, array('id'=>'is_variable', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('is_variable'))<span class="required">{{ $errors->first('is_variable') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Parent Salary Head</label>
		<div class="col-md-8">
			{!! Form::select('parent_head_id', $salary_heads, $value = null, array('id'=>'parent_head_id', 'class' => 'form-control')) !!}
		</div>
	</div>


	<div class="form-group">
		<label class="col-md-4 control-label">Percentage<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('percentage', $value = null, array('id'=>'percentage', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('percentage'))<span class="required">{{ $errors->first('percentage') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Head Type<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('head_type', $head_types, $value = null, array('id'=>'head_type', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('head_type'))<span class="required">{{ $errors->first('head_type') }}</span>@endif
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
			<a href="{{  url('/salary-head') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>