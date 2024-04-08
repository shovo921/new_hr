<div class="form-body">
    <div class="form-group hidden">
        <div class="col-md-8">
            {!! Form::text('id', $value = $data['billsSetup']->id ?? null, array('id'=>'id', 'class' => 'form-control')) !!}
            @if($errors->has('id'))
                <span class="required">{{ $errors->first('id') }}</span>
            @endif
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-4 control-label">Bill Type</label>
        <div class="col-md-8">
            {!! Form::select('bill_type_id',$data['billsType'] ,$value = $data['billsSetup']->bill_type_id ?? null, array('id'=>'bill_type_id','placeholder'=>'Bill Type', 'class' => 'form-control select2')) !!}
            @if($errors->has('bill_type_id'))
                <span class="required">{{ $errors->first('bill_type_id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Designation</label>
        <div class="col-md-8">
            {!! Form::select('designation_id',$data['designation'] ,$value = $data['billsSetup']->designation_id ?? null, array('id'=>'designation_id','placeholder'=>'Designation', 'class' => 'form-control select2')) !!}
            @if($errors->has('designation_id'))
                <span class="required">{{ $errors->first('designation_id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Bill Amount<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::number('bill_amount', $value = $data['billsSetup']->bill_amount ?? null, array('id'=>'bill_amount','placeholder'=>'Bill Amount', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('bill_amount'))
                <span class="required">{{ $errors->first('bill_amount') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Status<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('status', $data['status'] ,$value =$data['billsSetup']->status ??  null, array('id'=>'status', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('status'))
                <span class="required">{{ $errors->first('status') }}</span>
            @endif
        </div>
    </div>


    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            @if(!empty($data['billsSetup']))
                {!! Form::submit('Update', array('class' => "btn btn-primary")) !!}
            @else
                {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!}
            @endif
            <a href="{{  route('bill-setup.index') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>