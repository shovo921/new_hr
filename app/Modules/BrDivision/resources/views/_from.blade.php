<div class="form-body">
	

	<div class="form-group">
		<label class="col-md-4 control-label">Branch Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('br_id', $branchList, $value = null, array('id'=>'br_id', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('br_id'))<span class="required">{{ $errors->first('br_id') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Division Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('br_name', $value = null, array('id'=>'br_name', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('br_name'))<span class="required">{{ $errors->first('br_name') }}</span>@endif
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Division Details<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('br_details', $value = null, array('id'=>'br_details', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('br_details'))<span class="required">{{ $errors->first('br_details') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Status<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('br_status', $status, $value = null, array('id'=>'br_status', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('br_status'))<span class="required">{{ $errors->first('br_status') }}</span>@endif
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/br-division') }}" class="btn btn-success">Back</a>
		</div>
	</div>
</div>