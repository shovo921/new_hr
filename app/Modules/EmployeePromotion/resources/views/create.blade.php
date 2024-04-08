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
                <span>Employee Increment</span>
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
        <div class="page-title">Employee Promotion</div>
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Employee Promotion Information
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>
                    <a href="javascript:;" class="reload"> </a>
                </div>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="col-md-8">
                {!! Form::open(array('url' => 'employeePromotionStore', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) !!}
                {!! Form::hidden('previous_des_id', null, array('id'=>'previous_des_id', 'class' => 'form-control', 'required'=>"")) !!}

                <div class="form-group">
                    <label class="col-md-4 control-label">Employee Name<span class="required">*</span></label>
                    <div class="col-md-8">
                        {!! Form::select('employee_id', $employeeList, $value = null, array('id'=>'employee_id', 'class' => 'form-control select2', 'required'=>"", 'placeholder'=>'Select a Employee', 'onchange'=>'getEmployeeCurrentSalaryPromotion(this.value)')) !!}
                        @if($errors->has('employee_id'))
                            <span class="required">{{ $errors->first('employee_id') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Employee Designation<span class="required">*</span></label>
                    <div class="col-md-8">
                        {!! Form::select('promoted_des_id', $designations, null, array('id'=>'promoted_des_id', 'class' => 'form-control', 'required'=>"", 'onchange'=>'calculatePromotedBasic(this.value)')) !!}

                        @if($errors->has('promoted_des_id'))
                            <span class="required">{{ $errors->first('promoted_des_id') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Current Increment Slab<span class="required">*</span></label>
                    <div class="col-md-8">
                        {!! Form::select('current_inc_slave', $incrementSlave, null, array('id'=>'current_inc_slave', 'class' => 'form-control', 'required'=>"", 'onchange'=>'calculatePromotionSlab(this.value)')) !!}

                        @if($errors->has('current_inc_slave'))
                            <span class="required">{{ $errors->first('current_inc_slave') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Promotion Date<span class="required">*</span></label>
                    <div class="col-md-8">
                        {!! Form::text('promotion_date',$value = null, array('id'=>'promotion_date', 'placeholder'=>'yyyy-mm-dd', 'class' => 'form-control date-picker', 'required'=>"")) !!}
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-4 control-label">Basic Salary<span class="required">*</span></label>
                    <div class="col-md-8">
                        <?php
                        $basic = 0;
                        $houseRent = 0;
                        ?>
                        {!! Form::number('current_basic', null, array('id'=>'current_basic', 'class' => 'form-control', 'required'=>"", 'readonly'=>'')) !!}
                        @if($errors->has('current_basic'))
                            <span class="required">{{ $errors->first('current_basic') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">House Rent<span class="required">*</span></label>
                    <div class="col-md-8">
                        {!! Form::number('house_rent', null, array('id'=>'house_rent', 'class' => 'form-control', 'required'=>"", 'readonly'=>'readonly')) !!}
                        @if($errors->has('house_rent'))
                            <span class="required">{{ $errors->first('house_rent') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Medical<span class="required">*</span></label>
                    <div class="col-md-8">
                        {!! Form::number('medical', null, array('id'=>'medical', 'class' => 'form-control', 'required'=>"", 'readonly'=>'readonly')) !!}
                        @if($errors->has('medical'))
                            <span class="required">{{ $errors->first('medical') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Conveyance</label>
                    <div class="col-md-8">
                        {!! Form::number('conveyance', null, array('id'=>'conveyance', 'class' => 'form-control', 'readonly'=>'readonly')) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">House Maintenance<span class="required">*</span></label>
                    <div class="col-md-8">
                        {!! Form::number('house_maintenance', null, array('id'=>'house_maintenance', 'class' => 'form-control', 'required'=>"", 'readonly'=>'readonly')) !!}

                        @if($errors->has('house_maintenance'))
                            <span class="required">{{ $errors->first('house_maintenance') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Utility<span class="required">*</span></label>
                    <div class="col-md-8">
                        {!! Form::number('utility', null, array('id'=>'utility', 'class' => 'form-control', 'required'=>"", 'readonly'=>'readonly')) !!}
                        @if($errors->has('utility'))
                            <span class="required">{{ $errors->first('utility') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">LFA<span class="required">*</span></label>
                    <div class="col-md-8">
                        {!! Form::number('lfa', null, array('id'=>'lfa', 'class' => 'form-control', 'required'=>"", 'readonly'=>'readonly')) !!}
                        @if($errors->has('lfa'))
                            <span class="required">{{ $errors->first('lfa') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Car Allowance</label>
                    <div class="col-md-8">
                        {!! Form::number('car_allowance', $value = null, array('id'=>'car_allowance', 'class' => 'form-control','readonly'=>'readonly' )) !!}
                        @if($errors->has('car_allowance'))
                            <span class="required">{{ $errors->first('car_allowance') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Consolidated Amount</label>
                    <div class="col-md-8">
                        {!! Form::number('consolidated_salary', null, array('id'=>'consolidated_salary', 'class' => 'form-control', )) !!}
                        @if($errors->has('consolidated_salary'))
                            <span class="required">{{ $errors->first('consolidated_salary') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">OTHERS</label>
                    <div class="col-md-8">
                        {!! Form::number('others', null, array('id'=>'others', 'class' => 'form-control', 'onkeyup'=>'calculateGrossTotal()')) !!}
                    </div>
                </div>

                {{--<div class="form-group">
                    <label class="col-md-4 control-label">Gross Salary<span class="required">*</span></label>
                    <div class="col-md-8">
                        {!! Form::number('gross_total', $value = null, array('id'=>'gross_total', 'class' => 'form-control', 'required'=>"", 'readonly'=>'readonly')) !!}
                    </div>
                </div>--}}
                <div class="form-group">
                    <label class="col-md-4 control-label">Gross Salary<span class="required">*</span></label>
                    <div class="row">
                        <div class="col-sm-6">
                            {!! Form::number('gross_total', $value = null, array('id'=>'gross_total', 'class' => 'form-control', 'required'=>"", 'readonly'=>'readonly')) !!}
                        </div>
                        <div class="col-sm-1">
                            <a onclick="calculateGrossTotal()" class="btn btn-circle btn-sm green-meadow pull-left"><i
                                        class="fa fa-check" aria-hidden="true"></i>Gross Total</a>
                        </div>

                    </div>


                </div>

                <div class="form-group">
                    <div class="col-md-offset-4 col-md-8">
                        {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
                        <a href="{{  url('/employee-promotion') }}" class="btn btn-success">Back</a>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
    </div>

@stop

@section('script')
    <script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/my_scripts/employee_increment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/my_scripts/employee_promotion.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var getEmployeeCurrentSalaryInfo = 'getEmployeeCurrentSalaryInfo';
        var getEmployeeSalarySlaveInfo = 'getEmployeeSalarySlaveInfo';
        var getEmployeePromotedSalaryInfo = 'getEmployeePromotedSalaryInfo ';

        $(document).ready(function () {
            calculateGrossTotal();
        });

        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });
    </script>

@stop
