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
                <span>employee leave information view</span>
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
        <div class="page-title">Employee Leave Information View</div>

        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-gift"></i>Profile Information</div>
            </div>
            <div class="portlet-body">
                <table class="table">
                    <tr>
                       {{-- @php
                        dd($leave_applied);
                        @endphp--}}
                        <th>Name</th>
                        <td>{{ @$leave_applied->employeeName->employee_name ?? '' }}</td>
                        <th>Leave Type</th>
                        <td>{{ @$leave_applied->leave_type->leave_type ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Designation</th>
                        <td>{{ @$leave_applied->employeeName->designation ?? ''}}</td>
                        <th>Branch</th>
                        <td>{{ @$leave_applied->employeeName->branch_name }}</td>
                    </tr>
                    <tr>
                        <th>Leave Start Date</th>
                        <td>{{ date('d-m-Y', strtotime($leave_applied->start_date)) }}</td>
                        <th>Leave End Date</th>
                        <td>{{ date('d-m-Y', strtotime($leave_applied->end_date)) }}</td>
                    </tr>
                    <tr>
                        <th>Current Leave Status</th>
                        @if($leave_applied->leave_status ==3)
                            <td>Leave Approved By {{ $leave_applied->employee->name ?? '' }} ({{ $leave_applied->waiting_for ?? '' }})</td>
                        @elseif($leave_applied->leave_status == 4)
                            <td>Leave Cancelled By {{ $leave_applied->employee->name ?? '' }} ({{ $leave_applied->waiting_for ?? '' }})</td>
                        @else
                            <td>Leave Approval Waiting for {{ $leave_applied->employee->name ?? '' }} ({{ $leave_applied->waiting_for ?? '' }})</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Attachment</th>
                        @if(!empty($leave_attachment->attachment))
                            <td> {{$leave_attachment->attachment}} <a href="{{ asset('uploads/employeedata/'. $leave_applied->employeeName->employee_id . '/leave/'. $leave_attachment->attachment) }}" target="_blank"><i class="fa fa-eye"></i></a></td>
                        @else
                            <td>"No Attachment Found"</td>
                        @endif
                    </tr>
                </table>

            </div>
        </div>

        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-gift"></i> Leave Log Information</div>
            </div>
            <div class="portlet-body">
                <table class="table" width="100%">
                    <thead>
                    <tr>
                        <th>Leave Reliever Name</th>
                        <th>Leave Reliever ID</th>
                        <th>Remarks</th>
                        <th>Updated Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($leave_id as $item)
                        <tr>
                            <td>{{ $item->user->name ?? ' '  }}</td>
                            <td>{{ $item->leave_reliever ?? '' }}</td>
                            <td>{{ $item->remarks ?? ''}}</td>
                            <td>{{ $item->updated_at ?? ''}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

@stop
