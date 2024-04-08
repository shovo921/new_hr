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
                <span>Employee Salary Stop</span>
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
                        <a href="{{  route('stop-sal.createOrEdit',0) }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;">
                            <i class="fa fa-plus"></i>
                            Add Info
                        </a>

                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">Employee Salary Stop</span>
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
                                <th class="min-phone-l">Designation</th>
                                <th class="min-phone-l">Branch/Division</th>
                                <th class="min-phone-l">Start Date</th>
                                <th class="min-phone-l">End Date</th>
                                <th class="min-phone-l">Remarks</th>
                                <th class="min-phone-l">Status</th>
                                <th> Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; ?>
                            @foreach($data['empSalStop'] as $singleData)
                                    <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td> {{$singleData->employeeInfo->employee_name.'('.$singleData->employee_id.')' ?? ''}}</td>
                                    <td> {{$singleData->employeeInfo->designation ?? ''}}</td>
                                    <td> {{$singleData->employeeInfo->branch_name ?? ''}}</td>
                                    <td> {{$singleData->start_date ?? ''}}</td>
                                    <td> {{$singleData->end_date ?? ''}}</td>
                                    <td> {{$singleData->remarks ?? ''}}</td>
                                    <td>@if($singleData->status == 1)
                                            {{'Inactive'}}
                                        @elseif ($singleData->status == 4)
                                            {{'Stop/LWP'}}
                                        @else
                                            {{'On Provision'}}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('stop-sal.createOrEdit',$singleData->id) }}"
                                           class="btn btn-circle btn green btn-sm purple pull-left"><i
                                                    class="fa fa-edit"></i>Edit</a>
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

