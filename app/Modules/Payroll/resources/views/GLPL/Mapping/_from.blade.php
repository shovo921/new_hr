<div class="form-body">
    <div class="form-group hidden">
        <div class="col-md-8">
            {!! Form::text('id', $value = $data['glPlMapping']->id ?? null, array('id'=>'id', 'class' => 'form-control')) !!}
            @if($errors->has('id'))
                <span class="required">{{ $errors->first('id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Office</label>
        <div class="col-md-8">
            {!! Form::select('office',$data['office'], $value = $data['glPlMapping']->office ?? null, array('id'=>'office','required','placeholder'=>'Select Office', 'class' => 'form-control')) !!}
            @if($errors->has('office'))
                <span class="required">{{ $errors->first('office') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Debit Account<span class="required">*</span></label>
        <div class="col-md-8">

            {!! Form::select('dac_id',$data['glPlInfo'], $value = $data['glPlMapping']->dac_id ?? null, array('id'=>'dac_id','placeholder'=>'Debit Account Info', 'class' => 'form-control select2', 'required')) !!}
            @if($errors->has('dac_id'))
                <span class="required">{{ $errors->first('dac_id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Credit Account<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('cac_id',$data['glPlInfo'], $value = $data['glPlMapping']->cac_id ?? null, array('id'=>'cac_id','placeholder'=>'Credit Account Info', 'class' => 'form-control select2', 'required')) !!}
            @if($errors->has('cac_id'))
                <span class="required">{{ $errors->first('cac_id') }}</span>
            @endif

        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            @if(!empty($data['glPlMapping']))
                {!! Form::submit('Update', array('class' => "btn btn-primary")) !!}
            @else
                {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!}
            @endif
            <a href="{{  url('gl-pl-mapping') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>