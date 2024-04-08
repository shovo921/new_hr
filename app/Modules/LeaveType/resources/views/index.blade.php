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
            <span>Leave Types</span>
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
                    <a href="{{  url('/leave-type/create') }}" class="btn btn-default pull-right" style="margin-top: 3px;">
                        <i class="fa fa-plus"></i>
                        Add New Leave Type
                    </a>

                    <div class="caption">
                        <i class="icon-settings"></i>
                        <span class="caption-subject bold uppercase">All Leave Types</span>
                    </div>
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">                            

                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
                        <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="desktop">Leave Type</th>
                                <th class="desktop">Yearly Total Leave</th>
                                <th class="desktop">Is Carried Forward?</th>
                                <th class="desktop">Eligibility</th>
                                <th class="desktop">Max Carried Forward</th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>   
                            <?php $i =0 ?> 
                            @foreach($leaveTypes as $leaveType)   
                            <?php $i++; ?>                                           
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $leaveType->leave_type }}</td>
                                <td>{{ $leaveType->total_leave_per_year }}</td>
                                <td>{{ ($leaveType->carried_forward_status == '1') ? 'Yes':'No' }}</td>
                                <td>{{ $leaveType->eligibility->eligibility }}</td>
                                <td>{{ $leaveType->max_carried_forward ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ url('leave-type/'.$leaveType->id.'/edit') }}" class="btn btn-circle btn green btn-sm purple pull-left">
                                        <i class="fa fa-edit"></i>
                                    Edit</a>
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