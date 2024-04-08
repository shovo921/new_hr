{{Form::model($nomineeInfo,['url'=>['nomineeInfoUpdate',$nomineeInfo->id],'method'=>'put', 'class' => 'form-horizontal'])}}

<div class="form-body">
	{{--<div class="form-group">
		<label class="col-md-4 control-label">Nominee No<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('nominee_no', $value = null, array('id'=>'nominee_no', 'class' => 'form-control', 'required'=>"")) !!}
		</div>
	</div>--}}

	<div class="form-group">
		<label class="col-md-4 control-label">Name<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('nominee_name', $value = null, array('id'=>'nominee_name', 'class' => 'form-control', 'required'=>"")) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Relation<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('relation', $value = null, array('id'=>'relation', 'class' => 'form-control', 'required'=>"")) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Mobile No.<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('mobile_no', $value = null, array('id'=>'mobile_no', 'class' => 'form-control', 'required'=>"")) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">NID / Passport / Birth Certificate No<span class="required">*</span></label>
		<div class="col-md-8">
			{!! Form::text('nid_birth_cert_pass', $value = null, array('id'=>'nid_birth_cert_pass', 'class' => 'form-control', 'required'=>"")) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Address</label>
		<div class="col-md-8">
			{!! Form::text('address', $value = null, array('id'=>'address', 'class' => 'form-control')) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Birth Date</label>
		<div class="col-md-8">
			{!! Form::text('nominee_birth_date', $value = null, array('id'=>'nominee_birth_date_edit', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker', 'readonly' => 'readonly')) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Age</label>
		<div class="col-md-8">
			{!! Form::text('nominee_age', $value = null, array('id'=>'nominee_age_edit', 'class' => 'form-control')) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Distribution</label>
		<div class="col-md-8">
			{!! Form::text('distribution_percent', $value = null, array('id'=>'distribution_percent', 'class' => 'form-control')) !!}
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			{!! Form::submit('Update', array('class' => "btn btn-primary")) !!} &nbsp;
			<button type="button" class="btn dark btn-outline" data-dismiss="modal">Back</button>
		</div>

	</div>
</div>

<script type="text/javascript">
	$('#nominee_birth_date_edit').bind('blur change keyup keydown', function(e){
		var birthDayDate = $('#nominee_birth_date_edit').val();
		var from = birthDayDate.split("/");
		var birthdateTimeStamp = new Date(from[2], from[1] - 1, from[0]);
		var cur = new Date();
		var diff = cur - birthdateTimeStamp;
		var currentAge = Math.floor(diff/31557600000);

		$('#nominee_age_edit').val(currentAge);
	});
</script>
{{Form::close()}}