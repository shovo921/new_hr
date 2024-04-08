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
                <span>Employee Bill Setup</span>
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
                        <a href="{{  route('bills-type.index') }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;">
                            <i class="fa fa-plus"></i>
                            Bill Types
                        </a>
                        <a href="{{  route('bill-setup.index') }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;">
                            <i class="fa fa-plus"></i>
                            Bill Setup
                        </a>

                        <a href="{{  route('emp-bills.createOrEdit',0) }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;">
                            <i class="fa fa-plus"></i>
                            Add Employee Bill
                        </a>

                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">Employee Bill Setup</span>
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
                                <th class="min-phone-l">Bill Type</th>
                                <th class="min-phone-l">Amount</th>
                                <th class="min-phone-l">Status</th>
                                <th> Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; ?>
                            @foreach($data['employeeBills'] as $singleData)
                                    <?php $i++;  ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td> {{$singleData->employeeInfo->employee_name.'('.$singleData->employee_id.')' ?? ''}}</td>
                                    <td> {{$singleData->employeeInfo->designation ?? ''}}</td>
                                    <td> {{$singleData->employeeInfo->branch_name ?? ''}}</td>
                                    <td>{{$singleData->billInfo($singleData->bill_setup_id)->billsType[0]->bill_type ?? ''}}</td>
                                    <td> {{$singleData->bill_amount ?? ''}}</td>
                                    <td>{{ $singleData->status == 1 ? 'Active': 'Inactive'}}</td>
                                    <td>
                                        <a href="{{ route('emp-bills.createOrEdit',$singleData->id) }}"
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

