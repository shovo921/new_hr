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
            <span>All EMployee List</span>
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
                        <span class="caption-subject bold uppercase">In Development</span>
                    </div>
                    <div class="tools"> </div>
                </div>

                <div class="portlet-body">
                    <h3>This functionality is under Development</h3>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->

@endsection