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
            <span>Leave</span>
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

<div class="row">
    <div class="col-md-12" style="margin-top:20px;">                
        <div class="table-responsive">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet blue box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings"></i>
                        <span class="caption-subject bold uppercase">All Employee Leave Information</span>
                    </div>
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">
                    {{--<iframe src="http://192.168.200.132:8080/jasperserver/flow.html?_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2FHRM_Report&reportUnit=%2FHRM_Report%2FEmployee_Leave_Application_Form&decorate=no&j_username=hr_report&j_password=hr_report&standAlone=true&leaveId={{$leave_id}}" height="600"  width="900">
                    </iframe>--}}
                   {{--<iframe src="http://192.168.200.132:8080/jasperserver/flow.html?_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2FHRM_Report&reportUnit=%2FHRM_Report%2FEmployee_Leave_Application_Form&decorate=no&j_username=hr_report&j_password=hr_report&standAlone=true&leaveId=1942" height="600"  width="900" ></iframe>--}}
                   <iframe src="http://192.168.200.132:8080/jasperserver/flow.html?_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2FHRM_Report&reportUnit=%2FHRM_Report%2FEmployee_Leave_Application_Form&decorate=no&j_username=hr_report&j_password=hr_report&standAlone=true&leaveId=1942" height="600"  width="900" ></iframe>

                    {{--<iframe src=<?php echo $src ; ?> height="600"  width="900" > </iframe>--}}
                    {{--<iframe src="{{url('http://192.168.200.132:8080/jasperserver/flow.html?_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2FHRM_Report&reportUnit=%2FHRM_Report%2FEmployee_Leave_Application_Form&decorate=no&j_username=hr_report&j_password=hr_report&standAlone=true&leaveId=1941')}}">Your browser isn't compatible</iframe>--}}
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
</div>


@endsection