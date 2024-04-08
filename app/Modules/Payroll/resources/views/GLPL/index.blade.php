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
                <span>GLPL Information</span>
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

                        <a href="{{  url('/gl-pl/create') }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;">
                            <i class="fa fa-plus"></i>
                            Add New GLPL Account
                        </a>
                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">GLPL Account List</span>
                        </div>
                        <div class="tools"></div>
                    </div>
                    <div class="portlet-body">

                            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                                   id="sample_5">
                                <thead>
                                <tr>
                                    <th class="all">SI No</th>
                                    <th class="min-phone-l">Head Type</th>
                                    <th class="min-phone-l">Head ID</th>
                                    <th class="min-phone-l">GLPL</th>
                                    <th class="min-phone-l">GLPL Number</th>
                                    <th class="min-phone-l">Status</th>
                                    <th> Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0 ?>
                                @foreach($gl_pl_lists as $gl_pl_list)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            @if($gl_pl_list->head_type=="P")
                                                {{"Payment Type"}}
                                            <td>{{ $gl_pl_list->payType->description ?? '' }}</td>
                                            @else
                                                {{"DeductionType"}}
                                            <td>{{ $gl_pl_list->deductionType->description ?? '' }}</td>
                                            @endif</td>
                                        </td>
                                        <td>
                                            {{$gl_pl_list->gl_pl}}</td>
                                        </td>
                                        <td>{{ $gl_pl_list->gl_pl_no ?? '' }}</td>
                                        <td>
                                         @if($gl_pl_list->status==1)
                                             {{"Active"}}
                                            @else
                                             {{"Inactive"}}
                                            @endif</td>
                                        <td>
                                            <a href="{{ url('gl-pl/edit/'.$gl_pl_list->id) }}"
                                               class="btn btn-circle btn green btn-sm purple pull-left">
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

