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
                            <span class="caption-subject bold uppercase">All Employee Leave Information</span>
                        </div>
                        <div class="tools"></div>
                    </div>
                    <div class="portlet-body">

                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                               id="sample_5">
                            <thead>
                            <tr>

                                <th class="all">SI No</th>
                                <th class="min-phone-l">Employee ID</th>
                                <th class="min-phone-l">Employee Name</th>
                                @if (in_array(auth()->user()->role_id,['21','2']))
                                    <th class="desktop">Leave Type</th>
                                    <th class="desktop">Leave Balance</th>
                                @endif
                                @if (in_array(auth()->user()->role_id,['1']))
                                    <th> Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0 ?>
                            @foreach($employeeLeaves as $employeeLeave)
                                    <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $employeeLeave->employee_id }}</td>
                                    <td>{{ @$employeeLeave->employeeName->employee_name ?? '' }}</td>
                                    @if (in_array(auth()->user()->role_id,['21','2']))
                                        <td>{{ @$employeeLeave->leaveType->leave_type }}</td>
                                        <td>{{ $employeeLeave->last_forwarded_leave }}</td>
                                    @endif
                                    @if (in_array(auth()->user()->role_id,['1']))
                                        <td>
                                            <a href="{{ url('view-employee-leave/'.$employeeLeave->employee_id) }}"
                                               class="btn btn-circle btn green btn-sm purple pull-left">
                                                <i class="fa fa-eye"></i> Details
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->

@endsection