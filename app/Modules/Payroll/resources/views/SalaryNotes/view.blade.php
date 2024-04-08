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
                <span>Employee Salary Notes</span>
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
                        <div class="tools"></div>
                    </div>
                    <div class="portlet-body">
{{--                        <div class="form-group">
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
                                {!! Form::submit('Search', array('class' => "btn btn-primary",'name' => 'submit')) !!}
                            </div>
                            <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">&nbsp;</label>
                                {!! Form::submit('Process', array('class' => "btn btn-danger",'name' => 'submit')) !!}
                            </div>
                            {{Form::close()}}
                        </div>--}}

                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                               id="sample_5">
                            <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Paytype/Dedtype</th>
                                <th class="min-phone-l">Type</th>
                                <th class="min-phone-l">Total amount</th>
                                <th class="min-phone-l">Month Year</th>
                                <th class="min-phone-l">Paid Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            use App\Functions\EmployeeFunction;
                            use Carbon\Carbon;
                            $i = 0; ?>
                            @foreach($sal_notes as $sal_note)
                                @if($sal_note->status==1 ?? '')
                                    <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    @if($sal_note->pay_or_ded_type==1 ?? '')
                                    <td>{{ 'Paytype' }}</td>
                                    @else
                                        <td>{{ 'Dedtype' }}</td>
{{--                                    <td>{{ date('Y/m/d', strtotime($paid_day->payment_date)) ?? '' }}</td>--}}
{{--                                    <td>{{ date('Y/M', strtotime($paid_day->year_month)) ?? '' }}</td>--}}
                                    @endif
                                    @if($sal_note->pay_or_ded_type==1 ?? '')
                                        <td>{{ $sal_note->payType->description ?? '' }}</td>
                                    @else
                                        <td>{{ $sal_note->dedType->description ?? '' }}</td>
                                        {{--                                    <td>{{ date('Y/m/d', strtotime($paid_day->payment_date)) ?? '' }}</td>--}}
                                        {{--                                    <td>{{ date('Y/M', strtotime($paid_day->year_month)) ?? '' }}</td>--}}
                                    @endif
                                    <td>{{  $sal_note->total_amount ?? '' }}</td>
                                    <td>{{ date('Y/M', strtotime($sal_note->month_year)) ?? '' }}</td>
                                     <td>
                                         {{ date('Y/m/d', strtotime($sal_note->paid_date)) ?? '' }}
                                     </td>
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


