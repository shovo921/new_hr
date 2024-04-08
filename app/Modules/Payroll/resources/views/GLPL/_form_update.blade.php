<div class="form-body">

    <div class="form-group" >
        <label class="col-md-4 control-label">Head Type<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('head_type',$head_type, $value = $gl_pl_list->head_type, array('id'=>'head_type', 'class' => 'form-control ', 'disabled'=>"true")) !!}
            @if($errors->has('head_type'))<span class="required">{{ $errors->first('head_type') }}</span>@endif
        </div>
    </div>

    @if($gl_pl_list->head_type=="P")
    <div class="form-group " id="payTypeArea">
        <label class="col-md-4 control-label">Pay Type Head<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('ptype_id',$pay_type_list, $value = $gl_pl_list->head_id, array('id'=>'ptype_id', 'class' => 'form-control')) !!}
            @if($errors->has('ptype_id'))<span class="required">{{ $errors->first('ptype_id') }}</span>@endif
        </div>
    </div>
    @else
    <div class="form-group " id="deductTypeArea">
        <label class="col-md-4 control-label">Deduction Type Head<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('dtype_id',$deduction_type_list, $value = $gl_pl_list->head_id, array('id'=>'dtype_id', 'class' => 'form-control')) !!}
            @if($errors->has('dtype_id'))<span class="required">{{ $errors->first('dtype_id') }}</span>@endif
        </div>
    </div>
    @endif

    <div class="form-group">
        <label class="col-md-4 control-label">GLPL<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('gl_pl', $gl_pl, $value = $gl_pl_list->gl_pl, array('id'=>'gl_pl', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('gl_pl'))<span class="required">{{ $errors->first('gl_pl') }}</span>@endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">GLPL Number<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::number('gl_pl_no', $value = $gl_pl_list->gl_pl_no, array('id'=>'gl_pl_no','placeholder'=>'Please Give GLPL Number', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('gl_pl_no'))<span
                    class="required">{{ $errors->first('gl_pl_no') }}</span>@endif
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-4 control-label">Status<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('status', $status, $value = $gl_pl_list->status, array('id'=>'status', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('status'))<span class="required">{{ $errors->first('status') }}</span>@endif
        </div>
    </div>


    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
            <a href="{{  url('gl-pl') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>