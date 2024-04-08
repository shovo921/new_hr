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
                <span>Rm List</span>
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

                        <a href="{{  route('Rm.createOrEdit',0) }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;">
                            <i class="fa fa-plus"></i>
                            Add Rm
                        </a>
                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">Rm List</span>
                        </div>
                        <div class="tools"></div>
                    </div>
                    <div class="portlet-body">

                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
                            <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Posting Id</th>
                                <th class="min-phone-l">Zone</th>
                                <th class="min-phone-l">Branch</th>
                                <th class="min-phone-l">Date</th>
                                <th class="min-phone-l">Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i = 0; @endphp
                            @foreach($data['Rm_List'] as $singleData)
                                @php $i++; @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ optional($singleData->EmloyeeInfo)->employee_name . ' - ' . optional($singleData->EmloyeeInfo)->employee_id }}</td>
                                    <td>{{ optional($singleData->Zone)->name }}</td>
                                    <td>
                                        @foreach(json_decode($singleData->branch_list) as $singleData1)
                                            {{ \App\Functions\BranchFunction::singleActiveBranchGet($singleData1)->branch_name }}
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>{{ $singleData->effective_date ? \Carbon\Carbon::parse($singleData->effective_date)->toDateString() : '' }}</td>
                                    <td>{{ $singleData->status == 1 ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        <a href="{{ route('Rm.createOrEdit', $singleData->id) }}" class="btn btn-circle btn green btn-sm purple pull-left">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
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

