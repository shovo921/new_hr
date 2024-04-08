<div class="form-body">

    <div class="form-group">
        <label class="col-md-4 control-label">Payment Type Description<span class="required">*</span></label>
        <div class="col-md-8">

            {!! Form::text('description', $value = $payType_list->description, array('id'=>'description', 'class' => 'form-control', 'required'=>"")) !!}

            @if($errors->has('description'))<span
                    class="required">{{ $errors->first('description') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Status<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('status', $status, $value = $payType_list->status, array('id'=>'status', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('status'))<span class="required">{{ $errors->first('status') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
            <a href="{{  url('pay-type') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>