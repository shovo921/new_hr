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
                <span>Employee Salary Process Edit</span>
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
        <div class="page-title">Employee Salary Process Edit</div>
        <div class="col-md-8 col-md-offset-1">
            {!! Form::open(array('url' => route('salaryProcess.storeOrUpdate')/*'salary-process/update/'.$paidDayEdit->id*/, 'method' => 'PUT', 'role' => 'form', 'class' => 'form-horizontal')) !!}

            @include('Payroll::SalaryProcess._form_update')

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

        $('.date-picker-format').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });


        $('.date-picker-month').datepicker({
            autoclose: true,
            todayHighlight: true,
            changeMonth: true,
            changeYear: true,
            format: 'MM-yyyy',
        });


        /************* Day Count Calculation Started *****************/
        function getDayCount() {
            let startDate = $('#default_date').val();
            let endDate = $('#end_date').val();
            const diffInMs = new Date(endDate) - new Date(startDate)
            const diffInDays = (diffInMs / (1000 * 60 * 60 * 24) + 1);
            $('#day_count').val(diffInDays);
        }

        /************* Day Count Calculation End *****************/

    </script>
@stop