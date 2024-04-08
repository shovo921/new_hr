<div class="form-body">

	<div class="form-group">
		<label class="col-md-4 control-label">Office<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('head_office',$head, $value = null, array('id'=>'head_office', 'class' => 'form-control','onchange'=>"getBranch(this.value)")) !!}
			@if($errors->has('head_office'))<span class="required">{{ $errors->first('head_office') }}</span>@endif
		</div>
	</div>

	<div class="form-group hidden" id="branchType" >
		<label class="col-md-4 control-label">Branch Type<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('branch_type',$branchType, $value = null, array('id'=>'branch_type', 'class' => 'form-control','onchange'=>"getSubBranch(this.value)")) !!}
			@if($errors->has('branch_type'))<span class="required">{{ $errors->first('branch_type') }}</span>@endif

		</div>
	</div>

	<div class="form-group hidden" id="subBranchType" >
		<label class="col-md-4 control-label">Select Main Branch<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('parent_branch',$branchList, $value = null, array('id'=>'parent_branch', 'class' => 'form-control select2')) !!}
			@if($errors->has('parent_branch'))<span class="required">{{ $errors->first('parent_branch') }}</span>@endif
		</div>
	</div>

	<div class="form-group hidden" id="cbsCode">
		<label class="col-md-4 control-label">CBS Branch Code<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::number('cbs_branch_code', $value = null, array('id'=>'cbs_branch_code', 'class' => 'form-control')) !!}
			@if($errors->has('cbs_branch_code'))<span class="required">{{ $errors->first('cbs_branch_code') }}</span>@endif
		</div>
	</div>

	<div class="form-group hidden" id="brLoc">
		<label class="col-md-4 control-label">Branch Location<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('br_loc',$branchLocation, $value = null, array('id'=>'br_loc', 'class' => 'form-control')) !!}
			@if($errors->has('br_loc'))<span class="required">{{ $errors->first('br_loc') }}</span>@endif
		</div>
	</div>

	<div class="form-group hidden" id="clusterId">
		<label class="col-md-4 control-label">Select Cluster <span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('cluster_id',$clusterList, $value = null, array('id'=>'cluster_id', 'class' => 'form-control')) !!}
			@if($errors->has('cluster_id'))<span class="required">{{ $errors->first('cluster_id') }}</span>@endif
		</div>
	</div>

	<div class="form-group ">
		<label class="col-md-4 control-label">Branch Short Form<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('br_st', $value = null, array('id'=>'br_st', 'class' => 'form-control')) !!}
			@if($errors->has('br_st'))<span class="required">{{ $errors->first('br_st') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('branch_name', $value = null, array('id'=>'branch_name', 'class' => 'form-control')) !!}
			@if($errors->has('branch_name'))<span class="required">{{ $errors->first('branch_name') }}</span>@endif
		</div>
	</div>


	<div class="form-group">
		<label class="col-md-4 control-label">Address<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('address', $value = null, array('id'=>'address', 'class' => 'form-control')) !!}
			@if($errors->has('address'))<span class="required">{{ $errors->first('address') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Status<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('active_status',$status, $value = null, array('id'=>'active_status', 'class' => 'form-control')) !!}
			@if($errors->has('active_status'))<span class="required">{{ $errors->first('active_status') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/branch') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>