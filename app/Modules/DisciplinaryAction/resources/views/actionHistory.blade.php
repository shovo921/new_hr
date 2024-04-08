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
            <span>Disciplinary Action History</span>
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
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet blue box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings"></i>
                        <span class="caption-subject bold uppercase">Disciplinary Action History List</span>
                    </div>
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">                            
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
                        <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Employee ID & Name</th>
                                <th class="desktop">Status</th>
                                <th class="desktop">Action Type</th>
                                <th class="desktop">Action</th>
                            </tr>
                        </thead>
                        <tbody>   
                            <?php $i =0 ?>
                            @foreach($actionHistoryList as $actionHistory)   
                            <?php $i++; ?>                                           
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $actionHistory->employee_id.' - '. $actionHistory->employee->name ?? '' }}</td>
                                <td> 
                                    @if($actionHistory->status == 1)
                                        {{ 'Running' }}
                                    @elseif($actionHistory->status == 2)
                                        {{ 'Closed' }}
                                    @endif
                                </td>
                                <td>
                                    @if($actionHistory->action_type == 1)
                                        {{ 'Minor' }}
                                    @elseif($actionHistory->action_type == 2)
                                        {{ 'Major' }}
                                    @endif
                                </td>
                                <td>
                                <a href="{{ url('disciplinaryAction/edit/'.$actionHistory->id) }}" class="btn btn-circle btn green btn-sm purple pull-left">
                                    <i class="fa fa-edit"></i>
                                    Edit</a>

                                <a href="{{ url('disciplinaryAction/view/'.$actionHistory->id) }}" class="btn btn-circle btn green btn-sm purple pull-left">
                                    <i class="fa fa-eye"></i>
                                    View</a>
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