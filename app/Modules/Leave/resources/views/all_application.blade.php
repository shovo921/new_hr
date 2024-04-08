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
                <span>Leave</span>
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
                            <span class="caption-subject bold uppercase">All Employee Leave Applications</span>
                        </div>
                        <div class="tools"></div>
                    </div>
                    <div class="portlet-body">

{{--                        Search Bar--}}
                        <div class="form-group">
                            {{Form::open(['url'=>'allApplication','method'=>'get'])}}
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                <label for="FromDate" class="control-label">Employee ID:</label>
                                {!! Form::select('employee_id', $allEmployees, $value = null, array('id'=>'employee_id', 'class' => 'form-control select2', 'placeholder'=>'Select a Employee')) !!}
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                <label for="FromDate" class="control-label">Leave Applied Date:</label>
                                {{Form::text('applied_date',request('applied_date'),['class'=>'form-control date-picker'])}}
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                <label for="FromDate" class="control-label">Form Date:</label>
                                {{Form::text('from_date',request('from_date'),['class'=>'form-control date-picker'])}}
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                <label for="ToDate" class="control-label">To Date:</label>
                                {{Form::text('to_date',request('to_date'),['class'=>'form-control date-picker'])}}
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">Leave Type:</label>
                                {!! Form::select('leave_type', $leaveTypes, request('leave_type'), array('id'=>'leave_type', 'class' => 'form-control')) !!}
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">Leave Status:</label>
                                {!! Form::select('leave_status', $leave_status, request('leave_status'), array('id'=>'leave_status', 'class' => 'form-control')) !!}
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
                            <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Employee ID</th>
                                <th class="min-phone-l">Employee Name</th>
                                <th class="min-phone-l">Branch Name</th>
                                <th class="desktop">Applied Date</th>
                                <th class="desktop">Start Date</th>
                                <th class="desktop">End Date</th>
                                <th class="desktop">Next Joining Date</th>
                                <th class="desktop">Responsible Person</th>
                                <th class="desktop">Approval Waiting For</th>
                                <th class="desktop">Total Days</th>
                                <th class="desktop">Type</th>
                                <th> Action</th>
                                {{--                                --}}{{--Log Button--}}
                            </tr>
                            </thead>
                            <tbody>

                            <?php $i = 0 ?>

                            @foreach($allLeaveApplications as $application)
                                <?php $i++; ?>
                                {{--@inject('leaveController', ' App\Modules\Leave\Http\Controllers\LeaveController')--}}

                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $application->employee_id }}</td>
                                    <td>{{ $application->employeeName->employee_name ?? '' }}</td>
                                    {{-- <td>{{ $leaveController::getEmpBranchInfo($application->employee_id)->branch_name ?? '' }}</td>--}}
                                    <td>{{ @$application->branch->branch_name ??  '' }}</td>
                                    <td>{{ date('d-m-Y h:i:s', strtotime($application->created_at)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($application->start_date)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($application->end_date))  }}</td>
                                    <td>{{ date('d-m-Y', strtotime($application->next_joining_date))  }}</td>
                                    <td>{{ @$application->leaveReliever->name ?? '' }}</td>
                                    <td>{{ @$application->employee->name ?? '' }}</td>
                                    <td>{{ $application->total_days }}</td>
                                    <td>{{ $application->leave_type->leave_type }}</td>
                                    <td>
                                        @if($application->leave_status == '1' && in_array(auth()->user()->role_id,['21','2']))
                                            <a href="{{ url('leave/'.$application->id.'/edit') }}"
                                               class="btn btn-circle btn green btn-sm purple pull-left"><i
                                                        class="fa fa-edit"></i> Edit</a>
                                        @elseif($application->leave_status == '2')
                                            {{ 'Processing' }}
                                        @elseif($application->leave_status == '5')
                                            {{ 'Waiting For HR Officer' }}
                                        @elseif($application->leave_status == '6')
                                            {{ 'Waiting For Deputy Head HR' }}
                                        @elseif($application->leave_status == '7')
                                            {{ 'Waiting For HR Head ' }}
                                        @elseif($application->leave_status == '8')
                                            {{ 'Waiting For Managing Director' }}
                                        @elseif($application->leave_status == '4')
                                            {{ 'Canceled' }}
                                        @elseif($application->leave_status == '3')
                                            {{ 'Approved' }}
                                        @else
                                            {{ 'Pending' }}
                                        @endif
                                        {{--<a href="{{ url('leave-form/'.$application->id) }}"
                                           class="btn btn-circle btn green btn-sm purple pull-left" target="_blank"><i
                                                    class="fa fa-print"></i> Print</a>--}}
                                        <a href="{{ url('http://192.168.200.145:8080/jasperserver/flow.html?_flowId=viewReportFlow&ParentFolderUri=%2FHRM_Report&reportUnit=%2FHRM_Report%2FEmployee_Leave_Application_Form&decorate=no&j_username=hr_report&j_password=hr_report&type=pdf&standAlone=true&leaveId='.$application->id) }}"
                                           class="btn btn-circle btn green btn-sm purple pull-left" target="_blank"><i
                                                    class="fa fa-print"></i> Print</a>
                                        @if (in_array(auth()->user()->role_id,['1','3','5','2','21']))
                                            <a href="{{ url('leave-application-log/'.$application->id) }} "
                                               class="btn btn-circle btn blue btn-sm pull-left" target="_blank"><i
                                                        class="fa fa-eye"></i>View Log</a>
                                        @endif
                                    </td>
                                    {{--Log Button --}}
                                    {{--                                    <td>--}}
                                    {{--                                        <a href="{{ url('leave-application-log/'.$application->id) }} "class="btn btn-circle btn green btn-sm purple pull-right">Check Log</a>--}}
                                    {{--                                    </td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($allLeaveApplications->count()>0)
                            {{$allLeaveApplications->appends($_REQUEST)->render()}}
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
    <script type="text/javascript">
        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });


    </script>
    <script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>

@endsection