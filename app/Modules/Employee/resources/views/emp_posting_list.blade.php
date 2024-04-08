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
                <a href="{{ url('/all-sal') }}">Employee Posting Information List</a>
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
                        @if (in_array(auth()->user()->role_id,['1']))
                            <a href="{{  url('/employeeTransfer') }}" class="btn btn-default pull-right" style="margin-top: 3px;">
                                <i class="fa fa-plus"></i>
                                Add New Posting Info
                            </a>
                        @endif
                            &nbsp;
                                @if (in_array(auth()->user()->role_id,['1']))
                                    <a href="{{  url('/brdivhead') }}" class="btn btn-default pull-right" style="margin-top: 3px;">
                                        Branch/Division Head List
                                    </a>
                                @endif


                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">All Employee Posting Information</span>

                        </div>
                        <div class="tools">
                        </div>
                    </div>
                    <div class="portlet-body">

                    <div class="form-group">
                            {{Form::open(['url'=>'postinglist','method'=>'get'])}}
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
                        {{-- <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">--}}
                            <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Employee ID</th>
                                <th class="min-phone-l">Employee Name</th>
                                <th class="min-phone-l">File No.</th>
                                <th class="min-phone-l">Designation</th>
                                <th class="min-phone-l">Branch/Division Name</th>
                                <th class="min-phone-l">BR Division</th>
                                <th class="min-phone-l">Department</th>
                                <th class="desktop">Unit</th>
                                <th class="desktop">Functional Designation</th>
                                <th class="desktop">Effective From</th>
                                <th class="desktop">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $i = 0 ?>

                            @foreach($allEmployeePosting as $application)
                                <?php $i++;?>

                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $application->employee_id }}</td>
                                    <td>{{ @$application->employee->employee_name ?? '' }}</td>
                                    <td>{{ @$application->employee->personal_file_no ?? '' }}</td>
                                    <td>{{ @$application->employee->designation ?? '' }}</td>
                                    <td>{{ @$application->branch->branch_name ??  '' }}</td>
                                    <td>{{ @$application->division->br_name ??  '' }}</td>
                                    <td>{{ @$application->department->dept_name ??  '' }}</td>
                                    <td>{{ @$application->unit->unit_name ??  '' }}</td>
                                    <td>{{ @$application->functionalDesignation->designation ??  '' }}</td>
                                    <td>{{ date('d-m-Y', strtotime($application->effective_date)) }}</td>
                                    <td>
                                        <a href="{{ url('posting-edit/'.$application->id) }}" class="btn btn-circle green btn-sm purple pull-left"><i class="fa fa-edit"></i>Edit</a>
                                        <a href="{{ url('viewPosting/'.$application->employee_id.'') }}" class="btn btn-circle btn blue btn-sm pull-left"><i class="fa fa-eye"></i>Detail View</a>
                                        <a href="{{ url('postingHistory/'.$application->employee_id.'') }}" class="btn btn-circle btn default btn-sm pull-left"><i class="fa fa-check"></i> History</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                       @if($allEmployeePosting->count()>0)
                            {{$allEmployeePosting->appends($_REQUEST)->render()}}
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