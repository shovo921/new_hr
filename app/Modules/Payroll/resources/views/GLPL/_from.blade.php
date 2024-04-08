<div class="form-body">

	<div class="form-group">
		<label class="col-md-4 control-label">Head Type<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('head_type', $head_type, $value = null, array('id'=>'head_type', 'class' => 'form-control', 'required'=>"",'onchange'=>"getHead(this.value)")) !!}
			@if($errors->has('head_type'))<span class="required">{{ $errors->first('head_type') }}</span>@endif
		</div>
	</div>

	<div class="form-group hidden" id="payTypeArea">
		<label class="col-md-4 control-label">Pay Type Head<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('ptype_id',$pay_type_list, $value = null, array('id'=>'ptype_id', 'class' => 'form-control')) !!}
			@if($errors->has('ptype_id'))<span class="required">{{ $errors->first('ptype_id') }}</span>@endif
		</div>
	</div>

	<div class="form-group hidden" id="deductTypeArea">
		<label class="col-md-4 control-label">Deduction Type Head<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('dtype_id',$deduction_type_list, $value = null, array('id'=>'dtype_id', 'class' => 'form-control')) !!}
			@if($errors->has('dtype_id'))<span class="required">{{ $errors->first('dtype_id') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">GLPL<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('gl_pl', $gl_pl, $value = null, array('id'=>'gl_pl', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('gl_pl'))<span class="required">{{ $errors->first('gl_pl') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">GLPL Number<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::number('gl_pl_no', $value = null, array('id'=>'gl_pl_no','placeholder'=>'Please Give GLPL Number', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('gl_pl_no'))<span
					class="required">{{ $errors->first('gl_pl_no') }}</span>@endif
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
			<a href="{{  url('gl-pl') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>