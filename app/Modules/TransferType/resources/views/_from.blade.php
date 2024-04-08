<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Transfer Types<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('TRANSFER_TYPE', $value = null, array('id'=>'TRANSFER_TYPE', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('TRANSFER_TYPE'))<span class="required">{{ $errors->first('TRANSFER_TYPE') }}</span>@endif
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Status<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('STATUS', $status, $value = null, array('id'=>'STATUS', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('STATUS'))<span class="required">{{ $errors->first('STATUS') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
			<a href="{{  url('/transfer-type') }}" class="btn btn-success">Back</a>
		</div>

	</div>
</div>