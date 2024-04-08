<div class="form-body">

    <div class="form-group">
        <label class="col-md-4 control-label">Office<span class="required">*</span></label>
        <div class="col-md-8">
            @if($branch->head_office==2)
                {!! Form::text('head_office', $value = 'Branch', array('id'=>'head_office', 'class' => 'form-control', "readonly"=>"")) !!}
            @else
                {!! Form::text('head_office', $value = 'Head Office', array('id'=>'head_office', 'class' => 'form-control', "readonly"=>"")) !!}
            @endif
            @if($errors->has('head_office'))
                <span class="required">{{ $errors->first('head_office') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Branch Type<span class="required">*</span></label>
        <div class="col-md-8">
            @if($branch->parent_branch==null)
                {!! Form::text('branch_type', $value = 'Main Branch', array('id'=>'branch_type', 'class' => 'form-control', "readonly"=>"")) !!}
            @else
                {!! Form::text('branch_type', $value = 'Sub Branch', array('id'=>'branch_type', 'class' => 'form-control', "readonly"=>"")) !!}
            @endif
            @if($errors->has('branch_type'))
                <span class="required">{{ $errors->first('branch_type') }}</span>
            @endif
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-4 control-label">Main Branch Name<span class="required">*</span></label>
        <div class="col-md-8">
            @if($branch->parent_branch==null)
                {!! Form::text('branch_type', $value = 'No Main Branch Found', array('id'=>'branch_type', 'class' => 'form-control', "readonly"=>"")) !!}
            @else
                {!! Form::text('branch_type', $value = $branch->parent_branch_name->branch_name, array('id'=>'branch_type', 'class' => 'form-control', "readonly"=>"")) !!}
            @endif
            @if($errors->has('branch_type'))
                <span class="required">{{ $errors->first('branch_type') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">CBS Branch Code<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::number('cbs_branch_code', $value = $branch->cbs_branch_code, array('id'=>'cbs_branch_code', 'class' => 'form-control', "readonly"=>"")) !!}
            @if($errors->has('cbs_branch_code'))
                <span class="required">{{ $errors->first('cbs_branch_code') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Branch Location<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('br_loc', $value = $branch->br_loc, array('id'=>'br_loc', 'class' => 'form-control', "readonly"=>"")) !!}
            @if($errors->has('br_loc'))
                <span class="required">{{ $errors->first('br_loc') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group ">
        <label class="col-md-4 control-label">Cluster Name<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('cluster_id', $value = $branch->cluster_name->cluster_name ?? '', array('id'=>'cluster_id', 'class' => 'form-control', "readonly"=>"")) !!}
            @if($errors->has('cluster_id'))
                <span class="required">{{ $errors->first('cluster_id') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group ">
        <label class="col-md-4 control-label">Branch Short Form<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('br_st', $value = $branch->br_st, array('id'=>'br_st', 'class' => 'form-control')) !!}
            @if($errors->has('br_st'))
                <span class="required">{{ $errors->first('br_st') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Name<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('branch_name', $value = $branch->branch_name, array('id'=>'branch_name', 'class' => 'form-control')) !!}
            @if($errors->has('branch_name'))
                <span class="required">{{ $errors->first('branch_name') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Address<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('address', $value = $branch->address, array('id'=>'address', 'class' => 'form-control')) !!}
            @if($errors->has('address'))
                <span class="required">{{ $errors->first('address') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Status<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('active_status',$status, $value = $branch->active_status, array('id'=>'active_status', 'class' => 'form-control')) !!}
            @if($errors->has('active_status'))
                <span class="required">{{ $errors->first('active_status') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
            <a href="{{  url('/branch') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>

