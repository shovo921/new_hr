
<div class="form-body">
	<div class="form-group">
		<label class="col-md-4 control-label">Designation<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::select('designation_id', $designations, $value = null, array('id'=>'designation_id', 'class' => 'form-control select2', 'required'=>"")) !!}
			@if($errors->has('designation_id'))<span class="required">{{ $errors->first('designation_id') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Basic Salary<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('basic_salary', $value = null, array('id'=>'basic_salary', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('basic_salary'))<span class="required">{{ $errors->first('basic_salary') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">House Rent<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('house_rent', $value = null, array('id'=>'house_rent', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('house_rent'))<span class="required">{{ $errors->first('house_rent') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Increment Amount<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('increment_amount', $value = null, array('id'=>'increment_amount', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('increment_amount'))<span class="required">{{ $errors->first('increment_amount') }}</span>@endif
		</div>
	</div>


	<div class="form-group">
		<label class="col-md-4 control-label">Medical<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('medical', $value = null, array('id'=>'medical', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('medical'))<span class="required">{{ $errors->first('medical') }}</span>@endif
		</div>
	</div>


	<div class="form-group">
		<label class="col-md-4 control-label">Conveyance<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('conveyance', $value = null, array('id'=>'conveyance', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('conveyance'))<span class="required">{{ $errors->first('conveyance') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">House Maintenance<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('house_maintenance', $value = null, array('id'=>'house_maintenance', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('house_maintenance'))<span class="required">{{ $errors->first('house_maintenance') }}</span>@endif

		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Utility<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('utility', $value = null, array('id'=>'utility', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('utility'))<span class="required">{{ $errors->first('utility') }}</span>@endif
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Leave Fare Assistance<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('lfa', $value = null, array('id'=>'lfa', 'class' => 'form-control', 'required'=>"")) !!}
			@if($errors->has('lfa'))<span class="required">{{ $errors->first('lfa') }}</span>@endif
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Car Allowance</label>
		<div class="col-md-8">
			{!! Form::text('car_allowance', $value = null, array('id'=>'car_allowance', 'class' => 'form-control', )) !!}
			@if($errors->has('car_allowance'))<span class="required">{{ $errors->first('car_allowance') }}</span>@endif
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Consolidated Amount</label>
		<div class="col-md-8">
			{!! Form::text('consolidated_amount', null, array('id'=>'consolidated_amount', 'class' => 'form-control', )) !!}
			@if($errors->has('consolidated_amount'))<span class="required">{{ $errors->first('consolidated_amount') }}</span>@endif
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
			<a href="{{  url('/salary-slave') }}" class="btn btn-success">Back</a>
		</div>

	</div>
