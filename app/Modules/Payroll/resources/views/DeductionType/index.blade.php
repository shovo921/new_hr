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
                <span>Deduction Type Information</span>
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

                        <a href="{{  url('/deduction-type/create') }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;">
                            <i class="fa fa-plus"></i>
                            Add New Deduction Type
                        </a>
                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">Deduction Type List</span>
                        </div>
                        <div class="tools"></div>
                    </div>
                    <div class="portlet-body">

                            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                                   id="sample_5">
                                <thead>
                                <tr>
                                    <th class="all">SI No</th>
                                    <th class="min-phone-l">Description</th>
                                    <th class="min-phone-l">Status</th>
                                    <th> Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0 ?>
                                @foreach($dedType_lists as $dedType_list)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td> {{$dedType_list->description}}</td>
                                        <td>
                                         @if($dedType_list->status=="A")
                                             {{"Active"}}
                                            @elseif($dedType_list->status=="I")
                                             {{"Inactive"}}
                                            @else
                                                {{"Loan"}}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('deduction-type/edit/'.$dedType_list->dtype_id) }}"
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

