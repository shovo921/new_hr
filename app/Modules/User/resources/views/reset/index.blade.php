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
                <span>User Password Reset</span>
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
        <div class="page-title">Employee Password  Reset</div>
        <div class="col-md-8 col-md-offset-1">
            {!! Form::open(array('url' => route('reset.password'), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) !!}

            <div class="form-group">
                <label class="col-md-4 control-label">Employee ID</label>
                <div class="col-md-8">
                    {!! Form::select('employee_id',$employeeList,$value = $employeeList, array('id'=>'employee_id', 'class' => 'form-control select2','onchange'=>"getEmployeeBasicInfo(this.value)",'placeholder'=>'Employee Id', 'required'=>"")) !!}
{{--                    {!! Form::select('employee_id', ['' => 'Please select employee ID'] + $employeeList->toArray(), null, ['id' => 'employee_id', 'class' => 'form-control select2', 'onchange' => "getEmployeeBasicInfo(this.value)", 'required' => true]) !!}--}}

                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Employee Name</label>
                <div class="col-md-8">
                    {!! Form::text('employee_name', $value = null, array('id'=>'employee_name','readonly'=>'readonly','placeholder'=>'Employee Name', 'class' => 'form-control')) !!}
                    @if($errors->has('employee_name'))
                        <span class="required">{{ $errors->first('employee_name') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Branch/Division</label>
                <div class="col-md-8">
                    {!! Form::text('employee_branch', $value = null, array('id'=>'employee_branch','readonly'=>'readonly','placeholder'=>'Branch/Division', 'class' => 'form-control')) !!}
                    @if($errors->has('employee_branch'))
                        <span class="required">{{ $errors->first('employee_branch') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Designation</label>
                <div class="col-md-8">
                    {!! Form::text('employee_designation', $value = null, array('id'=>'employee_designation','readonly'=>'readonly','placeholder'=>'Designation', 'class' => 'form-control')) !!}
                    @if($errors->has('employee_designation'))
                        <span class="required">{{ $errors->first('employee_designation') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Password Type</label>
                <div class="col-md-8">
                    {!! Form::select('password_type', ['1' => 'Default', '2' => 'Custom'], null, ['class' => 'form-control select2', 'id' => 'password-type-select']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Password</label>
                <div class="col-md-8">
                    {!! Form::text('password', $value = null, array('id'=>'password','required'=>"",'placeholder'=>'password', 'class' => 'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-4 col-md-8">
                    {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
                </div>

            </div>

            {!! Form::close() !!}
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/my_scripts/custom.js?n=1') }}" type="text/javascript"></script>

    <script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        let employee_id = $('#employee_id').val();
        getEmployeeBasicInfo(employee_id);
    </script>

    <script>
        $(document).ready(function () {
            updatePasswordField();
            $('#password-type-select').on('change', function () {
                updatePasswordField();
            });

            function updatePasswordField() {
                var passwordType = $('#password-type-select').val();
                var passwordField = $('#password');

                if (passwordType === '1') {
                    passwordField.val('12345678').prop('readonly', true);
                } else {
                    passwordField.val('').prop('readonly', false);
                    passwordField.val('');
                }
            }
        });
    </script>
@stop