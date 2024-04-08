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
                <span>Employee Allowances</span>
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

                        <a href="{{  url('/allowance/createOrEdit/0') }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;">
                            <i class="fa fa-plus"></i>
                            Employee Allowance Add
                        </a>
                        <a href="{{  url('/allowance-type') }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;">
                            <i class="fa fa-plus"></i>
                             Allowance Types Add
                        </a>
                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">Employee Allowances</span>
                        </div>
                        <div class="tools"></div>
                    </div>
                    <div class="portlet-body">

                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                               id="sample_5">
                            <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Employee Info</th>
                                <th class="min-phone-l">Allowance Type</th>
                                <th class="min-phone-l">Amount</th>
                                <th class="min-phone-l">Disbursement Amount</th>
                                <th class="min-phone-l">Status</th>
                                <th> Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; ?>
                            @foreach($data['employeeAllowances'] as $employeeAllowances)
                                    <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td> {{$employeeAllowances->employeeInfo->employee_name.'('.$employeeAllowances->employee_id.')' ?? ''}}</td>
                                    <td>{{$employeeAllowances->allowanceTypes->allowance_type ?? ''}}</td>
                                    <td>{{$employeeAllowances->disb_amount ?? ''}}</td>
                                    <td>{{date('M-d-Y',strtotime($employeeAllowances->disb_date)) ?? ''}}</td>
                                    <td>
                                        @if($employeeAllowances->status==2)
                                            {{"Active"}}
                                        @elseif($employeeAllowances->status==1)
                                            {{"Initial"}}
                                        @elseif($employeeAllowances->status==3)
                                            {{"End"}}
                                        @else
                                            {{"Cancel"}}
                                        @endif</td>
                                    <td>
                                        <a href="{{ url('/allowance/createOrEdit/'.$employeeAllowances->id) }}" class="btn btn-circle btn green btn-sm purple pull-left"><i class="fa fa-edit"></i>Edit</a>
                                        @if($employeeAllowances->status==1)
                                        <a href="{{ url('/allowance/authorize/'.$employeeAllowances->id) }}" class="btn btn-circle btn-sm green-meadow pull-left" title="Approve" onclick="return confirm('Are you sure?')"><i class="fa fa-check"></i>Authorize</a>
                                        <a href="{{ url('/allowance/cancel/'.$employeeAllowances->id) }}" class="btn btn-circle btn-sm red-flamingo pull-left" title="Cancel" onclick="return confirm('Are you sure?')"><i class="fa fa-times" aria-hidden="true"></i>Cancel</a>
                                        <a href="{{ url('/allowance/destroy/'.$employeeAllowances->id) }}" class="btn btn-circle btn-sm red-flamingo pull-left" title="Cancel" onclick="return confirm('Are you sure?')"><i class="fa fa-times" aria-hidden="true"></i>Delete</a>
                                        @endif
                                    </td>
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

