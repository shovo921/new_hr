{{Form::model($childrenInfo,['url'=>['childrenInfoUpdate',$childrenInfo->id],'method'=>'put', 'class' => 'form-horizontal'])}}

	<div class="form-body">
		<div class="form-group">
			<label class="col-md-4 control-label">Name<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::text('child_name', $value = null, array('id'=>'org_name', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">Age<span class="required">*</span></label>
			<div class="col-md-8">
				@php
					$childbirthdate = '';
                    if(@$childrenInfo->child_age != '') {
                        $childbirthdate = date('d/m/Y', strtotime($childrenInfo->child_age));
                    }
				@endphp

				{!! Form::text('child_age', $value = null, array('id'=>'child_age', 'placeholder'=>'dd/mm/yyyy', 'class' => 'form-control date-picker')) !!}
				{{--{!! Form::text('child_age', $value = null, array('id'=>'org_name', 'class' => 'form-control', 'required'=>"")) !!}--}}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">Gender<span class="required">*</span></label>
			<div class="col-md-8">
				{!! Form::select('child_gender', ['' => '--Please Select--']+$genderList, $value = null, array('id'=>'child_gender', 'class' => 'form-control', 'required'=>"")) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">Education</label>
			<div class="col-md-8">
				{!! Form::text('child_education', $value = null, array('id'=>'child_education', 'class' => 'form-control')) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">Remarks</label>
			<div class="col-md-8">
				{!! Form::text('child_remarks', $value = null, array('id'=>'child_remarks', 'class' => 'form-control')) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-4 col-md-8">
				{!! Form::submit('update', array('class' => "btn btn-primary")) !!} &nbsp;
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Back</button>
			</div>

		</div>
	</div>
	
{{Form::close()}}