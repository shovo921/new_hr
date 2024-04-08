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

                        <a href="{{  url('/gl-pl-mapping/createOrEdit/0') }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;">
                            <i class="fa fa-plus"></i>
                            Add Account Info
                        </a>
                        <div class="tools"></div>
                    </div>
                    <div class="portlet-body">

                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                               id="sample_5">
                            <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Office</th>
                                <th class="min-phone-l">Debit Account</th>
                                <th class="min-phone-l">Credit Account</th>
                                <th> Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; ?>
                            @foreach($data['glPlMapping'] as $glPlMappingInfo)
                                    <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td> {!! $glPlMappingInfo->office == 1 ?'Head Office' :'Branch' !!} </td>
                                    <td> {{$glPlMappingInfo->glPlInfoDebit->glplinfo ?? ''}}</td>
                                    <td> {{$glPlMappingInfo->glPlInfoCredit->glplinfo ?? ''}}</td>
                                    <td>
                                        <a href="{{ url('/gl-pl-mapping/createOrEdit/'.$glPlMappingInfo->id) }}"
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

