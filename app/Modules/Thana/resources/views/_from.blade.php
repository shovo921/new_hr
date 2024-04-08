<div class="form-body">
    <body onload="getDistrictList()">
    <div class="form-group">
        <label class="col-md-4 control-label">Select a Division<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('division_id', $divisionList, $value = null, array('id'=>'division_id', 'class' => 'form-control', 'required'=>"", 'onchange'=>"getDistrictList(this.value)")) !!}
            @if($errors->has('division_id'))<span class="required">{{ $errors->first('division_id') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Select a District<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('district_id', $districtList, $value = null, array('id'=>'district_id', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('district_id'))<span class="required">{{ $errors->first('district_id') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Thana Name<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('name', $value = null, array('id'=>'name', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('name'))<span class="required">{{ $errors->first('name') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
            <a href="{{  url('/thana') }}" class="btn btn-success">Back</a>
        </div>

    </div>
    </body>
</div>