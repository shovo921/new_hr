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
                <span>Employee Salary / Increment Authorize</span>
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
        <div class="page-title">Employee Salary / Increment Authorization</div>
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Employee Salary / Increment Information
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>
                    <a href="javascript:;" class="reload"> </a>
                </div>
            </div>
        </div>
        <div class="portlet-body form">
            @if(isset($salaryIncrementSlave))
                <div class="col-md-8">
                    {!! Form::open(array('url' => 'authorizedIncrement/'.$salaryIncrementSlave->employee_id, 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'salaryIncriment')) !!}
                    <div class="form-group">
                        <label class="col-md-4 control-label">Employee</label>
                        <div class="col-md-8">
                            <input type="text" name="employee_id" readonly class="form-control"
                                   value="{{$salaryIncrementSlave->employee->employee_name}}  |  {{$salaryIncrementSlave->employee_id}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Employee Designation</label>
                        <div class="col-md-8">
                            <input type="text" name="employee_id" readonly class="form-control"
                                   value="{{$salaryIncrementSlave->employee->designation}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Current Increment Slab</label>
                        <div class="col-md-8">
                            <input type="text" name="current_inc_slave" readonly class="form-control"
                                   value="{{$salaryIncrementSlave->current_inc_slave}}">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Basic Salary<span class="required">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="current_basic" readonly class="form-control"
                                   value="{{$salaryIncrementSlave->current_basic}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">House Rent<span class="required">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="house_rent" readonly class="form-control"
                                   value="{{$salaryIncrementSlave->house_rent}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Medical<span class="required">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="medical" readonly class="form-control"
                                   value="{{$salaryIncrementSlave->medical}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Conveyance</label>
                        <div class="col-md-8">
                            <input type="text" name="conveyance" readonly class="form-control"
                                   value="{{$salaryIncrementSlave->conveyance}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">House Maintenance<span class="required">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="house_maintenance" readonly class="form-control"
                                   value="{{$salaryIncrementSlave->house_maintenance}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Utility<span class="required">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="utility" readonly class="form-control"
                                   value="{{$salaryIncrementSlave->utility}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">LFA<span class="required">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="lfa" readonly class="form-control"
                                   value="{{$salaryIncrementSlave->lfa}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Car Allowance</label>
                        <div class="col-md-8">
                            <input type="text" name="car_allowance" readonly class="form-control"
                                   value="{{$salaryIncrementSlave->car_allowance}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Consolidated Amount</label>
                        <div class="col-md-8">
                            <input type="text" name="consolidated_amount" readonly class="form-control"
                                   value="{{$salaryIncrementSlave->consolidated_salary}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">OTHERS</label>
                        <div class="col-md-8">
                            <input type="text" name="others" readonly class="form-control"
                                   value="{{$salaryIncrementSlave->others}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Gross Salary<span class="required">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="gross_total" readonly class="form-control"
                                   value="{{$salaryIncrementSlave->gross_total}}">
                        </div>
                    </div>
                    {{-- <div class="form-group hidden" id="basicArea">
                         <label class="col-md-4 control-label">Employee Designation</label>
                         <div class="col-md-8" id="basicInfo"></div>
                     </div>--}}


                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-8">
                            <a href="{{ url('authorizedIncrement/'.$salaryIncrementSlave->employee_id.'') }}"
                               class="btn btn-circle btn green btn-sm purple pull-left"
                               onclick="return confirm('Are you sure?')">
                                <i class="fa fa-check"></i> Authorized</a>
                            <a href="{{ url('cancelIncrement/'.$salaryIncrementSlave->employee_id.'') }}"
                               class="btn btn-circle btn green btn-sm red pull-left"
                               onclick="return confirm('Are you sure?')">
                                <i class="fa fa-trash" aria-hidden="true"></i> Cancel</a>
                            <a href="{{  url('/incrementAuthorization') }}"
                               class="btn btn-circle btn blue btn-sm blue pull-left">Back</a>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            @else

                @php
                    $employeeId =Request::segment(2);
                @endphp
                <div class="form-group">
                    <label class="col-md-4 control-label">Data is not in Correct Format Please Cancel Existing Data</label>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-4 col-md-8">
                        <a href="{{ url('cancelIncrement/'.$employeeId.'') }}"
                           class="btn btn-circle btn green btn-sm red pull-left"
                           onclick="return confirm('Are you sure?')">
                            <i class="fa fa-trash" aria-hidden="true"></i> Cancel</a>
                        <a href="{{  url('/incrementAuthorization') }}"
                           class="btn btn-circle btn blue btn-sm blue pull-left">Back</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    </div>

@stop

