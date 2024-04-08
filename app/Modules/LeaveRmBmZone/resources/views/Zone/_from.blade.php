<div class="form-body">
    <div class="form-group hidden">
        <div class="col-md-8">
            {!! Form::text('id', $value = $data['zone']->id ?? null, array('id'=>'id', 'class' => 'form-control')) !!}
            @if($errors->has('id'))
                <span class="required">{{ $errors->first('id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Name</label>
        <div class="col-md-8">
            {!! Form::text('zone_name', $value = $data['zone']->name ?? null, array('id'=>'zone_name','placeholder'=>'zone name', 'class' => 'form-control')) !!}
            @if($errors->has('zone_name'))
                <span class="required">{{ $errors->first('zone_name') }}</span>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Address</label>
        <div class="col-md-8">
            {!! Form::textarea('zone_address', $value = $data['zone']->address ?? null, array('id'=>'zone_address','placeholder'=>'Zone Address', 'class' => 'form-control')) !!}
            @if($errors->has('zone_address'))
                <span class="required">{{ $errors->first('zone_address') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Status</label>
        <div class="col-md-8">
            @php
                $data['status'] = [''=>'please select',1=>'Active',2=>'Inactive']
            @endphp
            {!! Form::select('status',$data['status'], $value = $data['zone']->status ?? null, array('id'=>'status','placeholder'=>'Status', 'class' => 'form-control')) !!}
            @if($errors->has('status'))
                <span class="required">{{ $errors->first('status') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            @if(!empty($data['zone']))
                {!! Form::submit('Update', array('class' => "btn btn-primary")) !!}
            @else
                {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!}
            @endif

            <a href="{{  route('bills-type.index') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>