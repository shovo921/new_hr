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
                <span>Salary Process</span>
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
                    @php

                        if(!empty( $allData['sal'])){
                           foreach( $allData['sal'] as $paymentData){

                             if($paymentData['dr_cr'] == 'DR'){
                                 $debitBalance[] = str_replace([','],[''],$paymentData['amount']);
                             }
                             if($paymentData['dr_cr'] == 'CR'){
                                 $creditBalance[] = str_replace([','],[''],$paymentData['amount']);
                             }

                         }
                        }

                         //dd(array_sum($debitBalance),array_sum($creditBalance),$debitBalance,$creditBalance);
                         //dd($debitBalance,$creditBalance);

                    @endphp

                    <div class="portlet-body">
                        <div class="form-group">
                            <label for="debit" class="control-label">Total
                                Debit: {{array_sum($debitBalance ?? [])}}</label><br>
                            <label for="credit" class="control-label">Total
                                Credit: {{array_sum($creditBalance ?? []) }}</label>
                            {{Form::open(['url'=>'salary-process/final/','method'=>'get'])}}
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                <label for="FromDate" class="control-label">Office</label>
                                {!! Form::select('hoOrBr',$allData['hoOrBranchOrBoth'], $value = null, array('id'=>'hoOrBr', 'class' => 'form-control select2','required'=>'required')) !!}
                            </div>
                            <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">&nbsp;</label>
                                {!! Form::submit('Search', array('class' => "btn btn-info",'name' => 'submit')) !!}
                            </div>
                            <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">&nbsp;</label>
                                {!! Form::submit('Process', array('class' => "btn btn-warning",'name' => 'submit')) !!}
                            </div>

                            {{Form::close()}}
                            {{Form::open(['url'=>'salary-process/final/','method'=>'get'])}}
                            <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                <label for="ID" class="control-label">&nbsp;</label>
                                {!! Form::submit('FinalProcess', array('class' => "btn btn-danger",'name' => 'submit')) !!}
                            </div>
                            {{Form::close()}}
                            @if(!empty($allData['bonus']))
{{--                            Festival  bonus--}}
                            {{Form::open(['url'=>'salary-process/final/','method'=>'get'])}}

                            <div class="col-md-1 col-sm-12 col-xs-12 form-group ml-3" style="margin-left: 30px;">
                                <label for="ID" class="control-label">&nbsp;</label>
                                {!! Form::submit('FestivalBonus', array('class' => "btn btn-danger",'name' => 'submit')) !!}
                            </div>
                            {{Form::close()}}

                            {{--                            Festival  bonus closed--}}
                            @endif

                        </div>

                        <table class="table table-striped table-bordered table-hover dt-responsive"
                               width="100%"
                               id="sample_5">
                            <thead>
                            <tr>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Branch/Division</th>
                                <th class="min-phone-l">Account Name</th>
                                <th class="min-phone-l">Account</th>
                                <th class="min-phone-l">Amount</th>
                                <th class="min-phone-l">DR_CR</th>
                                <th class="min-phone-l">TRAN_BR_CODE</th>
                                <th class="min-phone-l">AC_BR_CODE</th>
                                <th class="min-phone-l">PAYMENT_DATE</th>
                                <th class="min-phone-l">Narration</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            use App\Functions\BranchFunction;
                            use App\Functions\GlPlFunction;

                            $i = 0; ?>
                            @if(!empty($allData['sal']))
                                @foreach( $allData['sal'] as $payment)
                                        <?php $i++;
                                        if ($payment['branch_code'] == '0001') {
                                            $branchCode = 'Head Office';
                                        } else {
                                            $branchCode = str_replace(['["', '"]'], ['', ''], BranchFunction::branchNameByCode($payment['branch_code']));
                                        }
                                        ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $branchCode ?? ''}}</td>
                                        <td>{{ str_replace(['{"','":"', '"}','[]','["','"]'], [' ','-', ' ','GL-PARKING',' ',' '],GlPlFunction::getGlOrPLInfo($payment['accountno']) ) }}</td>
                                        <td>{{ $payment['accountno'] ?? ''  }}</td>
                                        <td>{{ $payment['amount'] ?? '' }}</td>
                                        <td>{{ $payment['dr_cr']  ?? '' }}</td>
                                        <td>{{ $payment['tran_br_code'] ?? '' }}</td>
                                        <td>{{ $payment['ac_br_code'] ?? '' }}</td>
                                        <td>{{ $payment['payment_date'] ?? '' }}</td>
                                        <td>{{ $payment['remarks'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @endif
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


