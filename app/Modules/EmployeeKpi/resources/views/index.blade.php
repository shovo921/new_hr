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
                <span>Bill Types</span>
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

                        <a href="{{  route('employee-kpi.createOrEdit',0) }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;">
                            <i class="fa fa-plus"></i>
                            Employee KPI Add
                        </a>
                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">Employee KPI Information</span>
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
                                <th class="min-phone-l">KPI Year</th>
                                <th class="min-phone-l">KPI Scores</th>
                                <th class="min-phone-l">Status</th>
                                <th> Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; ?>
                            @foreach($data['employeeKpi'] as $singleData)
                                    <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>
                                        {{ $singleData->employeeDetails->employee_name }}<br>
                                        {{ $singleData->employee_id }}<br>
                                        {{ $singleData->employeeDetails->designation }}<br>
                                        {{ $singleData->employeeDetails->branch_name }}
                                    </td>
                                    {{--<td>{{ $singleData->employeeDetails->employee_name.'-'.$singleData->employee_id.'-'.$singleData->employeeDetails->designation.'-'.$singleData->employeeDetails->branch_name }}</td>--}}
                                    <td>{{ $singleData->kpi_year }}</td>
                                    <td>
                                        @foreach(json_decode($singleData->kpi_data) as $allData)

                                            @foreach($allData as $key=> $singleData1)
                                                {{ \App\Functions\KpiFunction::singleActiveFieldGet($key)->field_name.' - '. $singleData1 }}
                                                <br>
                                            @endforeach
                                        @endforeach
                                    </td>
                                    <td>{{ $singleData->status == 1 ? 'Active': 'Inactive'}}</td>
                                    <td>
                                        <a href="{{ route('employee-kpi.createOrEdit',$singleData->id) }}"
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

