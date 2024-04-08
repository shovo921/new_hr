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
                <a href="{{ url('/all-sal') }}">Employee Salary list</a>
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
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <div class="row">
        <div class="col-md-12" style="margin-top:20px;">
            <div class="table-responsive">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet blue box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">All Employee Salary</span>
                        </div>
                        <div class="tools"></div>
                    </div>
                    <div class="portlet-body">

                        <div class="form-group">
                            {{Form::open(['url'=>'all-sal','method'=>'get'])}}
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                <label for="FromDate" class="control-label">Employee ID:</label>
                                {!! Form::select('employee_id', $allEmployees, $value = null, array('id'=>'employee_id', 'class' => 'form-control select2', 'placeholder'=>'Select a Employee')) !!}
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                <label for="FromDate" class="control-label">Branch/Division:</label>
                                {!! Form::select('branch', $branchList, $value = null, array('id'=>'branch', 'class' => 'form-control select2', 'placeholder'=>'Select a Branch/Division')) !!}
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                <label for="FromDate" class="control-label">Designation:</label>
                                {!! Form::select('designation_id', $designationList, $value = null, array('id'=>'designation_id', 'class' => 'form-control select2', 'placeholder'=>'Select a Employee')) !!}
                            </div>
                            <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary form-control">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                            {{Form::close()}}
                        </div>

                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%">
                            {{--<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">--}}
                            <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Employee ID & Name</th>
                                <th class="min-phone-l">Designation</th>
                                <th class="min-phone-l">Branch Name</th>
                                <th class="desktop">Basic</th>
{{--                                <th class="min-phone-l">Slab No.</th>
                                <th class="desktop">Basic</th>
                                <th class="desktop">House Rent</th>
                                <th class="desktop">Medical</th>
                                <th class="desktop">Conveyance</th>
                                <th class="desktop">House Maintenance</th>
                                <th class="desktop">Utility</th>
                                <th class="desktop">LFA</th>
                                <th class="desktop">Others</th>
                                <th class="desktop">PF</th>
                                <th class="desktop">Car Maintenance</th>
                                <th class="desktop">Consolidated Salary</th>--}}
                                <th class="desktop">Gross Total</th>
                                <th class="desktop">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $i = 0 ?>

                            @foreach($allEmployeeSalary as $application)
                                <?php  $i++;  ?>

                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $application->employee_id }}{{" - "}}{{ @$application->employee->employee_name ?? '' }}</td>
                                    <td>{{ @$application->employee->designation ?? '' }}</td>
                                    <td>{{ @$application->employee->branch_name ??  '' }}</td>
                                    <td>{{ @$application->current_basic ??  '' }}</td>
{{--                                    <td>{{ @$application->current_inc_slave ??  '' }}</td>
                                    <td>{{ @$application->current_basic ??  '' }}</td>
                                    <td>{{ @$application->house_rent ??  '' }}</td>
                                    <td>{{ @$application->medical ??  '' }}</td>
                                    <td>{{ @$application->conveyance ??  '' }}</td>
                                    <td>{{ @$application->house_maintenance ??  '' }}</td>
                                    <td>{{ @$application->utility ??  '' }}</td>
                                    <td>{{ @$application->lfa ??  '' }}</td>
                                    <td>{{ @$application->others ??  '' }}</td>
                                    <td>{{ @$application->pf ??  '' }}</td>
                                    <td>{{ @$application->car_maintenance ??  '' }}</td>
                                    <td>{{ @$application->consolidated_salary ??  '' }}</td>--}}
                                    <td>{{ @$application->gross_total ??  '' }}</td>
                                    <td>
                                        <a href="{{ url('view-promotion-history/'.$application->employee_id) }}" class="btn btn-circle btn green btn-sm purple pull-left">
                                            <i class="fa fa-list"></i>
                                            Promotion History</a>
                                        <a href="{{ url('view-detail-salary/'.$application->employee_id.'') }}" class="btn btn-circle btn default btn-sm pull-left"><i class="fa fa-list"></i>Detail Salary</a>
                                        <a href="{{ url('viewPosting/'.$application->employee_id.'') }}" class="btn btn-circle btn blue btn-sm pull-left"><i class="fa fa-eye"></i>Posting Info</a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($allEmployeeSalary->count()>0)
                            {{$allEmployeeSalary->appends($_REQUEST)->render()}}
                        @endif
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->

@endsection
@section('script')

    <script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>

@endsection