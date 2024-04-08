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
                <span>Employee Bill Setup</span>
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
        <div class="page-title">Employee Bill Setup</div>

        <div class="col-md-8 col-md-offset-1">
            {!! Form::open(array('url' => route('emp-bills.updateTmpBill'), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) !!}

            @include('Payroll::Bills.EmployeeBills._tmp_from')

            {!! Form::close() !!}
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('assets/my_scripts/custom.js?n=1') }}" type="text/javascript"></script>

    <script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        let employee_id = $('#employee_id').val();
        if (employee_id !== null) {
            getEmployeeBasicInfo(employee_id);
        }

        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

        $('.date-picker-month').datepicker({
            autoclose: true,
            todayHighlight: true,
            changeMonth: true,
            changeYear: true,
            format: 'yyyy-MM',
        });
    </script>
@stop
