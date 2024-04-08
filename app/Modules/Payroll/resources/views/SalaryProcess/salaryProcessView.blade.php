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
                <span>Employee Salary Process</span>
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

                        <a href="{{  url('salary-notes') }}" class="btn btn-default pull-right"
                           style="margin-top: 3px;">
                            Employee Salary Notes
                        </a>

                        <div class="tools"></div>
                    </div>
                    <div class="portlet-body">
                        <div class="form-group">
                            {{Form::open(['url'=>'salary-process/','method'=>'get'])}}
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                <label for="FromDate" class="control-label">Employee Type</label>
                                {{-- {!! Form::select('empCondition',$data['empCondition'], $value = null, array('id'=>'empCondition', 'class' => 'form-control select2','required'=>'required')) !!}--}}
                            </div>
                            <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">&nbsp;</label>
                                {!! Form::submit('Check', array('class' => "btn btn-info",'name' => 'submit')) !!}
                            </div>


                            {{--@if(empty($data['paidDay']) || ($data['paidDay']->ready_to_pay ?? ' ' == 1))--}}
                            <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">&nbsp;</label>
                                {!! Form::submit('Process', array('class' => "btn btn-warning",'name' => 'submit')) !!}
                            </div>
                            {{--@endif--}}

                            {{Form::close()}}
                            {{--{{Form::open(['url'=>'salary-process/','method'=>'get'])}}
                            <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">&nbsp;</label>
                                {!! Form::submit('FinalProcess', array('class' => "btn btn-success",'name' => 'submit')) !!}
                            </div>
                            {{Form::close()}}--}}
                        </div>

                        <table class="table table-striped table-bordered table-hover dt-responsive"
                               width="100%"
                               id="sample_5">
                            <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Pay Type</th>
                                <th class="min-phone-l">Debit Account</th>
                                <th class="min-phone-l">Credit Account</th>
                                <th class="min-phone-l">Amount</th>
                                <th class="min-phone-l">Narration</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 0; ?>
                            @foreach($data['allGlPlAmount'] as $payment)
                                @if(!empty($payment))
                                        <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $payment->description ?? ''  }}</td>
                                        <td>{{ $payment->debit_account ?? '' }}</td>
                                        <td>{{ $payment->credit_account  ?? '' }}</td>
                                        <td>{{ $payment->amount ?? '' }}</td>
                                        <td>{{ $payment->narration ?? '' }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>

                        <!-- END EXAMPLE TABLE PORTLET-->

                    </div>


                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->

        @endsection

        {{--script--}}
        @section('script')
            <script src="{{asset('assets/pages/scripts/components-select2.min.js') }}"
                    type="text/javascript"></script>
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


