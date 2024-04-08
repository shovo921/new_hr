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
                <span>Employee Account Loan Information</span>
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


                        <a href="{{  url('/account-loan/create') }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;">
                            <i class="fa fa-plus"></i>
                            Add New Employee Loan
                        </a>

                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">Employee Loan Information</span>
                        </div>
                        <div class="tools"></div>
                    </div>
                    <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                                   id="sample_5">
                                <thead>
                                <tr>
                                    <th class="all">SI No</th>
                                    <th class="min-phone-l">Employee</th>
                                    <th class="min-phone-l">Account Information</th>
                                    <th class="min-phone-l">Branch</th>
                                    <th class="min-phone-l">Loan Type</th>
                                    <th class="min-phone-l">Disbursement Amount</th>
                                    <th class="min-phone-l">Recovered Amount</th>
                                    <th class="min-phone-l">Loan Status</th>
                                    <th> Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0 ?>


                                @foreach($loan as $loan)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $loan->employeeDetails->employee_name ?? '' }}
                                            ({{ $loan->employee_id ?? ''}})
                                        </td>
                                        <td>{{ $loan->acc_no ?? '' }}</td>
                                        <td>{{ $loan->branchDetails->branch_name ?? ''}}</td>
                                        <td>{{ $loan->dedDetails->description ?? ''}}</td>
                                        <td>{{ $loan->disb_amt ?? '' }}</td>
                                        <td>{{ $loan->recover_amt ?? '' }}</td>
    
                                        <td>{!! ($loan->status == 2) ? '<font color="red">In-Active</font>':'<font color="green">Active</font>'!!}</td>
                                        <td>
                                            <a href="{{ url('account-loan/edit/'.$loan->id) }}"
                                               class="btn btn-circle btn green btn-sm purple pull-left">
                                                <i class="fa fa-edit"></i>
                                                Loan Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
{{--                            @if($salaryAccount->count()>0)
                                {{$salaryAccount->appends($_REQUEST)->render()}}
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
