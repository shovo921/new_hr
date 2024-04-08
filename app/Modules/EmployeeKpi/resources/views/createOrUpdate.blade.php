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
                <span>Employee KPI Information</span>
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
        <div class="page-title">Employee KPI Information</div>
        <div class="col-md-8 col-md-offset-1">
            {!! Form::open(array('url' => route('employee-kpi.createOrUpdate'), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) !!}
            @include('EmployeeKpi::_from')
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


        $('.date-picker-year').datepicker({
            autoclose: true,
            todayHighlight: true,
            changeMonth: true,
            changeYear: true,
            format: 'yyyy',
            minViewMode: 'years' // Display only the year
        });
    </script>
@stop

