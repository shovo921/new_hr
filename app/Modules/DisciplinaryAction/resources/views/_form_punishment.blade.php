<div class="form-body">

    <div class="form-group">
        <label class="col-md-4 control-label">Punishment Description<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('punishments', $value = null, array('id'=>'punishments', 'class' => 'form-control', 'required'=>"", 'placeholder'=>'Enter Punishment Description')) !!}
            @if($errors->has('punishments'))<span class="required">{{ $errors->first('punishments') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Type<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('type', $type, $value = null, array('id'=>'type', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('type'))<span class="required">{{ $errors->first('type') }}</span>@endif
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
            <a href="{{  url('/punishments') }}" class="btn btn-success">Back</a>
        </div>
    </div>

</div>