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
                <span>Employee</span>
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
        <div class="col-md-12" style="margin-top:20px;">
            <div class="table-responsive">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet blue box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">Employee Transfer Transit List</span>
                        </div>
                        <div class="tools"></div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                               id="sample_5">
                            <thead>
                            <tr>
                                <th class="all">Employee</th>
                                <th class="min-phone-l">Current Br/Div</th>
                                <th class="min-phone-l">Current Reporter</th>
                                <th class="min-phone-l">Posting Br/Div</th>
                                <th class="min-phone-l">Posted Reporter</th>
                                <th class="min-phone-l">Responsible</th>
                                <th class="min-phone-l">Tr. Order</th>
                                <th class="min-phone-l">Handover File</th>
                                <th class="min-phone-l">Joining Letter</th>
                                <th class="desktop">Effective Date</th>
                                <th class="desktop">Status</th>
                                <th> Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['transitInfo'] as $transit)
                                @foreach($transit as $posting)
                                    @php
                                        $postingHistory =  \App\Functions\EmployeeFunction::transferHistory($posting->employee->employee_id);
                                    @endphp
                                    <tr>
                                        <td>{{ $posting->employee->employee_name.'-'.$posting->employee->employee_id  }}</td>
                                        <td>{{ $posting->employee->branch_name  }}</td>
                                        <td>{{ $posting->crReliever->employee_name.'-'.$posting->crReliever->employee_id  }}</td>
                                        <td>{{ $postingHistory->branch->branch_name ?? '' }}</td>
                                        <td>{{ $posting->postedOfficer->employee_name.'-'.$posting->postedOfficer->employee_id  }}</td>
                                        <td>{{ $posting->responsible->employee_name.'-'.$posting->responsible->employee_id  }}</td>
                                        <td>
                                            <a href="{{ asset('uploads/employeedata/' . ($posting->employee->employee_id ?? '') . '/transferfile/'.($posting->t_order_file ?? '') ) }}"
                                               target="_blank"><i class="fa fa-eye">View File</i></a></td>
                                        <td>
                                            <a href="{{ asset('uploads/employeedata/' . ($posting->employee->employee_id ?? '') . '/transferfile/'.($posting->handortakeover_file ?? '') ) }}"
                                               target="_blank"><i class="fa fa-eye">View File</i></a></td>
                                        <td>
                                            <a href="{{ asset('uploads/employeedata/' . ($posting->employee->employee_id ?? '') . '/transferfile/'.($posting->joining_letter ?? '') ) }}"
                                               target="_blank"><i class="fa fa-eye">View File</i></a></td>
                                        <td>{{ $postingHistory->effective_date}}</td>
                                        <td>
                                            @if($posting->status == 1)
                                                Initial
                                            @elseif($posting->status == 2)
                                                Processing
                                            @elseif($posting->status == 3)
                                                waiting for HR Authorization
                                            @elseif($posting->status == 4)
                                                HR Approved
                                            @else
                                                Cancel
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('viewPostingHistory/'.$postingHistory->employee_id.'') }}"
                                               class="btn btn-circle btn blue btn-sm pull-left"><i
                                                        class="fa fa-eye"></i> View</a>

                                            <a href="{{ url('authorizedPosting/'.$postingHistory->employee_id.'') }}"
                                               class="btn btn-circle btn btn-sm purple pull-left"
                                               onclick="return confirm('Are you sure?')"><i class="fa fa-check"></i>
                                                Approve</a>

                                            <a href="{{ url('postingHistory/'.$postingHistory->employee_id.'') }}"
                                               class="btn btn-circle btn default btn-sm pull-left"><i
                                                        class="fa fa-check"></i> History</a>


                                            <a href="{{ url('cancelPosting/'.$postingHistory->employee_id.'') }}"
                                               class="btn btn-circle btn btn-sm red pull-left"
                                               onclick="return confirm('Are you sure?')">
                                                <i class="fa fa-trash" aria-hidden="true"></i> Cancel</a>
                                        </td>

                                    </tr>
                                @endforeach
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
@stop
