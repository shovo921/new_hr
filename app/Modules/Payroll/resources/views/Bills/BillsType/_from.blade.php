<div class="form-body">
    <div class="form-group hidden">
        <div class="col-md-8">
            {!! Form::text('id', $value = $data['billsType']->id ?? null, array('id'=>'id', 'class' => 'form-control')) !!}
            @if($errors->has('id'))
                <span class="required">{{ $errors->first('id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Bill Type</label>
        <div class="col-md-8">
            {!! Form::text('bill_type', $value = $data['billsType']->bill_type ?? null, array('id'=>'bill_type','placeholder'=>'Bill Type', 'class' => 'form-control')) !!}
            @if($errors->has('bill_type'))
                <span class="required">{{ $errors->first('bill_type') }}</span>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Status</label>
        <div class="col-md-8">
            @php
                $data['status'] = [''=>'please select',1=>'Active',2=>'Inactive']
            @endphp
            {!! Form::select('status',$data['status'], $value = $data['billsType']->status ?? null, array('id'=>'status','placeholder'=>'Status', 'class' => 'form-control')) !!}
            @if($errors->has('status'))
                <span class="required">{{ $errors->first('status') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            @if(!empty($data['billsType']))
                {!! Form::submit('Update', array('class' => "btn btn-primary")) !!}
            @else
                {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!}
            @endif

            <a href="{{  route('bills-type.index') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>