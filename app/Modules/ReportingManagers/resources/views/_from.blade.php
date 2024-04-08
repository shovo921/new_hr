<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Branch Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('branch_id', $branchList, $value = null, array('id'=>'branch_id', 'class' => 'form-control select2', 'required'=>"")) !!}
			@if($errors->has('branch_id'))<span class="required">{{ $errors->first('branch_id') }}</span>@endif
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Reporting To MD<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('md', $permission, $value =null, array('id'=>'md', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('md'))<span class="required">{{ $errors->first('md') }}</span>@endif
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Reporting To DMD & CRO<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('dmd_cro', $permission, $value =null, array('id'=>'dmd_cro', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('dmd_cro'))<span class="required">{{ $errors->first('dmd_cro') }}</span>@endif
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Reporting To DMD & COO<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('dmd_coo', $permission, $value =null, array('id'=>'dmd_coo', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('dmd_coo'))<span class="required">{{ $errors->first('dmd_coo') }}</span>@endif
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/reporting-heads') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>