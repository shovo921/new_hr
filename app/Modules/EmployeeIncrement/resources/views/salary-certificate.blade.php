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
            <span>Employee Salary Certificate</span>
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
    <div class="page-title">Employee Salary Certificate</div>
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>Employee Salary Certificate</div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>
                    <a href="javascript:;" class="reload"> </a>
                </div>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="col-md-8">
                {!! Form::open(array('url' => 'generateSalaryCertificate', 'method' => 'get', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'salaryIncriment')) !!}
                <div class="form-group">
                    <label class="col-md-4 control-label">Employee Name<span class="required">*</span></label>
                    <div class="col-md-8">
                        {!! Form::select('employee_id', $employeeList, $value = null, array('id'=>'employee_id', 'class' => 'form-control select2', 'required'=>"", 'placeholder'=>'Select a Employee', 'onchange'=>'getEmployeeCurrentSalary(this.value)')) !!}
                        @if($errors->has('employee_id'))<span class="required">{{ $errors->first('employee_id') }}</span>@endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-4 col-md-8">
                        {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
                        <a href="{{  url('/employee') }}" class="btn btn-success">Back</a>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/my_scripts/employee_increment.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    var getEmployeeCurrentSalaryInfo = 'getEmployeeCurrentSalaryInfo';
    var getEmployeeSalarySlaveInfo = 'getEmployeeSalarySlaveInfo';

    $(document).ready(function () {
        calculateGrossTotal();
    });
</script>

@stop
