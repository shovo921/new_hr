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
                <span>Employee Job Description</span>
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

                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet blue box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">Employee Job Description List</span>
                        </div>
                        <div class="tools"></div>
                    </div>
                    <div class="portlet-body">

                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                                   id="sample_5">
                                <thead>
                                <tr>
                                    <th class="all">SI No</th>
                                    <th class="min-phone-l">Employee</th>
                                    <th class="min-phone-l">Branch</th>
                                    <th class="min-phone-l">Designation</th>
                                    <th class="min-phone-l">Functional Designation</th>
                                    <th class="min-phone-l">Approval</th>
                                    <th class="min-phone-l"> File</th>
                                    <th class="min-phone-l"> Status</th>
                                    <th class="min-phone-l"> Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0 ?>

                                @foreach($employeeJd as $employeeJds)
                                        <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $employeeJds->employeeDetails->employee_name ?? '' }}
                                            ({{ $employeeJds->employee_id }})
                                        </td>
                                        <td>{{ $employeeJds->employeeDetails->branch_name ?? ''}}</td>
                                        <td>{{ $employeeJds->employeeDetails->designation ?? '' }}</td>
                                        <td>{{ $employeeJds->functionalDesignation->designation ?? '' }}</td>
                                        <td>{{ $employeeJds->user->name ?? '' }}
                                            -{{ $employeeJds->approver_id ?? '' }}</td>
                                        <td><a href="{{ asset('uploads/employee-jd/'. $employeeJds->file_name) }}"
                                               target="_blank"><i class="fa fa-eye"></i></a></td>
                                        <td>
                                            @if($employeeJds->status==1)
                                                {{"Not Checked"}}
                                            @elseif($employeeJds->status==2)
                                                {{"Processing"}}
                                            @elseif($employeeJds->status==3)
                                                {{"Approved"}}
                                            @else
                                                {{"Cancel"}}
                                            @endif

                                        </td>
                                        <td>
                                            @if($employeeJds->approver_id == 'hradmin' && $employeeJds->status==2)
                                                <a href="{{ url('job-description/jd/'.$employeeJds->employee_id) }}"
                                                   class="btn btn-circle btn green btn-sm purple pull-left">
                                                    <i class="fa fa-edit"></i>
                                                    Approve</a>
                                            @elseif($employeeJds->approver_id == auth()->user()->employee_id && $employeeJds->status==2)
                                                <a href="{{ url('job-description/jd/'.$employeeJds->employee_id) }}"
                                                   class="btn btn-circle btn green btn-sm purple pull-left">
                                                    <i class="fa fa-edit"></i>
                                                    Approve</a>

                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{--                            @if($employeeJd->count()>0)
                                                            {{$employeeJd->appends($_REQUEST)->render()}}
                                                        @endif--}}
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->

        @endsection

        {{--script--}}
        @section('script')
            <script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
            <script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"
                    type="text/javascript"></script>
            <script src="{{ asset('assets/pages/scripts/components-multi-select.min.js') }}"
                    type="text/javascript"></script>

@endsection
