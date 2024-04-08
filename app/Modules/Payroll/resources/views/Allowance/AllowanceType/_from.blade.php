<div class="form-body">

    <div class="form-group">
        <label class="col-md-4 control-label">Allowance Type<span class="required">*</span></label>
        <div class="col-md-8">

            {!! Form::text('allowance_type', $value = $data['allowanceType']->allowance_type ?? null, array('id'=>'allowance_type','placeholder'=>'Please Give Allowance Type', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('allowance_type'))
                <span
                        class="required">{{ $errors->first('allowance_type') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Status<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('status', $data['status'] ,$value =$data['allowanceType']->status ??  null, array('id'=>'status', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('status'))
                <span class="required">{{ $errors->first('status') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
            <a href="{{  url('allowance-type') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>