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
                <span>Attendance</span>
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
                @if (session('msg_success'))
                    <div class="alert alert-success">
                        {{ session('msg_success') }}
                    </div>
                @endif
                @if (session('msg_error'))
                    <div class="alert alert-error">
                        {{ session('msg_error') }}
                    </div>
                @endif
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet blue box">
                    <div class="portlet-title">
                        @if (in_array(auth()->user()->role_id,['1','2']))
                            <a href="{{  url('/attendance/create') }}" class="btn btn-default pull-right"
                               style="margin-top: 3px;">
                                <i class="fa fa-plus"></i>
                                Add New Attendance
                            </a>
                        @endif

                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">Employee Attendance List</span>
                        </div>
                        <div class="tools"></div>
                    </div>

                    <div class="portlet-body">
                        <div class="form-group">
                            {{Form::open(['url'=>'attendance','method'=>'get'])}}
                            @if (in_array(auth()->user()->role_id,['1','2','3']))
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label for="FromDate" class="control-label">Employee ID:</label>
                                    {!! Form::select('employee_id', $employeeList, $value = null, array('id'=>'employee_id', 'class' => 'form-control select2')) !!}
                                    {{-- @if($errors->has('employee_id'))<span class="required">{{ $errors->first('employee_id') }}</span>@endif--}}
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label for="FromDate" class="control-label">Branch / Division:</label>
                                    {!! Form::select('branch', $branchList, $value = null, array('id'=>'branch', 'class' => 'form-control select2')) !!}
                                    {{-- @if($errors->has('employee_id'))<span class="required">{{ $errors->f   irst('employee_id') }}</span>@endif--}}
                                </div>

                            @endif
                            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                <label for="FromDate" class="control-label">Form Date:</label>
                                {{Form::text('from_date',request('from_date'),['class'=>'form-control date-picker', 'readonly'=>'readonly'])}}
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                <label for="ToDate" class="control-label">To Date:</label>
                                {{Form::text('to_date',request('to_date'),['class'=>'form-control date-picker', 'readonly'=>'readonly'])}}
                            </div>

                            <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary form-control">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                            {{Form::close()}}
                        </div>
                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                               id="sample_5">
                            <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Employee ID</th>
                                <th class="min-phone-l">Employee Name</th>
                                <th class="min-phone-l">Designation</th>
                                <th class="min-phone-l">Branch / Division</th>
                                <th class="min-phone-l">Attendance Date</th>
                                <th class="min-phone-l">IN Time</th>
                                <th class="min-phone-l">OUT Time</th>
                                <th class="min-phone-l">IN Gate</th>
                                <th class="min-phone-l">Out Gate</th>
                                <th class="min-phone-l">Verify Type</th>
                                <th class="min-phone-l">Remarks</th>
                                @if (in_array(auth()->user()->role_id,['1','3']))
                                    <th class="min-phone-l">Status</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0 ?>
                            @foreach($attendanceInfo as $attendance)
                                    <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>

                                    {{--<td>{{ $attendance['EMPLOYEE_ID'] }}</td>--}}
                                    <td>{{ $attendance->employee_id }}</td>
                                    <td>{{ $attendance->employee_name }}</td>
                                    <td>{{ $attendance->designation }}</td>
                                    <td>{{ $attendance->branch_name }}</td>
                                    <td>{{ $attendance->attendance_date }}</td>
                                    <td>{{ $attendance->in_time }}</td>
                                    <td>{{ $attendance->out_time }}</td>
                                    <td>{{ $attendance->in_gate }}</td>
                                    <td>{{ $attendance->out_gate }}</td>
                                    <td>{{ $attendance->verify_type }}</td>
                                    {{--<td>
                                        @if($attendance->verify_type == null)
                                            <font color="red">N/A</font>
                                        @elseif($attendance->verify_type == 4)
                                            <font color="green">Card</font>
                                        @elseif($attendance->verify_type == 15)
                                            <font color="green">Face</font>
                                        @elseif($attendance->verify_type == 1)
                                            <font color="green">FP</font>
                                        @else
                                            <font color="green">Manual Attendance</font>
                                        @endif
                                    </td>--}}
                                    <td>{!! ($attendance->remarks === 'Absent') ? '<font color="red">ABSENT</font>':($attendance->remarks) !!}</td>
                                    @if (in_array(auth()->user()->role_id,['1','3']))
{{--                                        <td>{!! ($attendance->in_time < '09:00:00') ? '<font color="green">Normal</font>':'<font color="red">Late In</font>'!!}</td>--}}
                                        <td>{!! $attendance->late_in ? $attendance->late_in : '<font color="green">Normal</font>' !!}</td>
                                    @endif

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
