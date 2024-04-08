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
                <span>Employee Salary Process Information</span>
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

{{--                        <a href="{{  route('adjustment.index') }}" class="btn btn-default pull-right"--}}
{{--                           style="margin-top: 3px;">--}}
{{--                            <i class="fa fa-plus"></i>--}}
{{--                            Employee Salary Adjustment--}}
{{--                        </a>--}}
                        <a href="{{  route('stop-sal.index') }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;">
                            <i class="fa fa-plus"></i>
                            Employee Stop Salary
                        </a>
                        <a href="{{  route('salaryProcess.createOrEdit',0) }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;">
                            <i class="fa fa-plus"></i>
                            Add Employee Salary
                        </a>

                        <div class="tools"></div>
                        <a href="{{  route('emp-bills.tmp') }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;"><i class="fa fa-plus"></i>
                            Employee Bills
                        </a>

                        <div class="tools"></div>

                    </div>
                    <div class="portlet-body">
                        <div class="form-group">
                            {{Form::open(['url'=>'salary-process/','method'=>'get'])}}
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                <label for="FromDate" class="control-label">Employee Type</label>
                                {!! Form::select('empCondition',$data['empCondition'], $value = null, array('id'=>'empCondition', 'class' => 'form-control select2','required'=>'required')) !!}
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                <label for="FromDate" class="control-label">Payment Date</label>
                                {!! Form::text('payment_date', $value = null, array('id'=>'payment_date', 'class' => 'form-control date-picker','required'=>'required')) !!}
                            </div>
                            <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">&nbsp;</label>
                                {!! Form::submit('Search', array('class' => "btn btn-info",'name' => 'submit')) !!}
                            </div>


                            {{--@if(empty($data['paidDay']) || ($data['paidDay']->ready_to_pay ?? ' ' == 1))--}}
                            <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">&nbsp;</label>
                                {!! Form::submit('Process', array('class' => "btn btn-warning",'name' => 'submit')) !!}
                            </div>
                            {{--@endif--}}

                            {{Form::close()}}
                            {{Form::open(['url'=>'salary-process/','method'=>'get'])}}
                            <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">&nbsp;</label>
                                {!! Form::submit('FinalProcess', array('class' => "btn btn-success",'name' => 'submit')) !!}
                            </div>
                            {{Form::close()}}
                        </div>

                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                               id="sample_5">
                            <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Employee</th>
                                <th class="min-phone-l">Payment Date</th>
                                <th class="min-phone-l">Year Month</th>
                                <th class="min-phone-l">First Day of the Month</th>
                                <th class="min-phone-l">Day Count</th>
                                <th class="min-phone-l">Day Paid</th>
                                <th class="min-phone-l">Status</th>
                                <th class="min-phone-l">Remarks</th>
                                <th class="min-phone-l">Last Day of the Month</th>
                                <th> Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            use App\Functions\EmployeeFunction;

                            $i = 0; ?>
                            @foreach($data['empSal'] as $paid_day)
                                @if(!empty($paid_day))
                                        <?php $i++; ?>

                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ str_replace(['["', '"]'], [' ', ' '],EmployeeFunction::singleEmployeeName($paid_day->employee_id ??'')).'-'.($paid_day->employee_id ?? '')?? ''}}</td>
                                        <td>{{ date('Y-m-d',strtotime($paid_day->payment_date ??'')) ?? '' }}</td>
                                        <td>{{ $paid_day->year_month ?? '' }}</td>
                                        <td>{{ date('Y-m-d',strtotime($paid_day->default_date ?? '')) ?? '' }}</td>
                                        <td>{{ $paid_day->day_count ?? '' }} Day</td>
                                        <td>{{ $paid_day->day_paid ?? '' }} Day</td>
                                        <td>@if(!empty($paid_day->status))
                                                @if($paid_day->status==1)
                                                    {{"Full"}}
                                                @elseif($paid_day->status==2)
                                                    {{"Partial"}}
                                                @elseif($paid_day->status==3)
                                                    {{"Partial Join"}}
                                                @elseif($paid_day->status==4)
                                                    {{"Stop"}}
                                                @elseif($paid_day->status==5)
                                                    {{"On Provision"}}
                                                @endif
                                            @else
                                                {{"Not Found"}}
                                            @endif
                                        </td>
                                        <td>{{ $paid_day->remarks ?? '' }}</td>
                                        <td>{{ date('Y-m-d',strtotime($paid_day->end_date ??'')) ?? '' }}</td>
                                        @if(isset($paid_day->id))
                                            <td>
                                                <a href="{{ route('salaryProcess.createOrEdit',$paid_day->id)}}"
                                                   class="btn btn-circle btn green btn-sm purple pull-left">
                                                    <i class="fa fa-edit"></i>
                                                    Edit</a>

                                                <a href="{{ route('adjustment.show',$paid_day->employee_id) }}"
                                                   class="btn btn-circle btn green btn-sm purple pull-left">
                                                    <i class="fa fa-edit"></i>
                                                    Adjustment</a>
                                            </td>
                                        @else
                                            <td>
                                                <a href="#"
                                                   class="btn btn-circle btn green btn-sm purple pull-left disabled">
                                                    <i class="fa fa-edit"></i>
                                                    Edit</a>
                                            </td>
                                        @endif

                                    </tr>
                                @endif
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

{{--script--}}
@section('script')
    <script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/components-multi-select.min.js') }}"
            type="text/javascript"></script>

    <script type="text/javascript">
        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });
    </script>

@endsection


