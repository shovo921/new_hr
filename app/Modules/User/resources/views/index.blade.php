@extends('layouts.app')
@include('layouts.menu')
@section('breadcrumb')
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Profile Edit</span>
            </li>
        </ul>
        <div class="page-toolbar">
            <div class="pull-right">
                <i class="icon-calendar"></i>&nbsp;
                <span class="thin uppercase hidden-xs">{{ date('D, M d, Y') }}</span>&nbsp;
            </div>
        </div>
    </div>
    <!-- END PAGE BAR -->
@stop
@section('content')
    <div class="row">
        <div class="page-title">Profile Edit</div>

        <div class="col-md-8 col-md-offset-1">
            {!! Form::open(array('url' => 'profile', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) !!}

            <div class="form-body">

                <div class="form-group">
                    <label class="col-md-4 control-label">Name<span class="required"></span></label>
                    <div class="col-md-8">
                        {!! Form::text('name', $user->name, array('id'=>'name', 'class' => 'form-control', 'required'=>"", 'readonly'=>"readonly")) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Employee Username<span class="required"></span></label>
                    <div class="col-md-8">
                        {!! Form::text('employee_id', $user->employee_id, array('id'=>'employee_id', 'class' => 'form-control', 'required'=>"", 'readonly'=>"readonly")) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Current Password<span class="required">*</span></label>
                    <div class="col-md-8">
                        {{Form::password('current_password',['class'=>'form-control','required','autocomplete'=>'off','id'=>'current_password'])}}
                    </div>
                </div> <div class="form-group">
                    <label class="col-md-4 control-label">New Password :<span class="required">*</span></label>
                    <div class="col-md-8">
                        {{Form::password('password',['class'=>'form-control','required','id'=>'password'])}}
                    </div>
                </div>



                <div class="form-group">
                    <div class="col-md-offset-4 col-md-8">
                        {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
                        <a href="{{  url('/home') }}" class="btn btn-success">Back</a>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>

@endsection

