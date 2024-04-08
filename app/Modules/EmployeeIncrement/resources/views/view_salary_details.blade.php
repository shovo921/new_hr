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
                <span>Employee Salary Details</span>
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
        <div class="page-title">Employee Salary Details View</div>

        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-gift"></i>Profile Information</div>
            </div>
            <div class="portlet-body">
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <td>{{ @$employeeSalary->employee->employee_name ?? ''}}</td>
                        <th>Employee ID</th>
                        <td>{{ @$employeeSalary->employee->employee_id }}</td>
                    </tr>
                    <tr>
                        <th>Branch/Division</th>
                        <td>{{ @$employeeSalary->employee->branch_name }}</td>
                        <th>Designation</th>
                        <td>{{ @$employeeSalary->employee->designation }}</td>
                    </tr>
                    <tr>
                        <th>Slab Number</th>
                        <td>{{ @$employeeSalary->current_inc_slave }}</td>
                    </tr>
                </table>

            </div>
        </div>
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-gift"></i>Salary Information</div>
            </div>
            <div class="portlet-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="all">Payment Head</th>
                        <th class="min-phone-l">Deduction Head</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="portlet-body">
                                <table class="table">
                                    @foreach($salaryPaySlips as $salaryPaySlip)
                                        <tr>
                                            <th>{{ $salaryPaySlip->payType->description ?? ''}}</th>
                                            <td style="float: right">{{ number_format((double)$salaryPaySlip->amount, 2, '.', '') ?? ''}}</td>
                                        </tr>
                                    @endforeach
                                    <tr style="text-decoration-line: overline;">
                                        <th><h4><b>Gross Payment</b></h4></th>
                                        <td style="float: right; text-decoration-line: overline;"><h4><b>{{ number_format((double)$payTotal, 2, '.', '') ?? ''}}</b></h4></td>
                                    </tr>
                                </table>
                            </div>
                            {{--                           <div style="display: block;margin-top: 0.5em;margin-bottom: 0.5em;margin-left: auto;margin-right: auto;border-style: inset;border-width: 1px;"></div>
                                                        <div class="portlet-body">
                                                            <table class="table">
                                                                <tr>
                                                                    <th><h4><b>Take Home Salary</b></h4></th>
                                                                    <td>{{ $payTotal-$dedTotal}}</td>
                                                                </tr>
                                                            </table>
                                                        </div>--}}
                            {{--<div style="display: block;margin-top: 0.5em;margin-bottom: 0.5em;margin-left: auto;margin-right: auto;border-style: inset;border-width: 1px;"></div>--}}

                        </td>
                        <td>
                            <div class="portlet-body">
                                <table class="table">
                                    @foreach($salaryDedSlips as $salaryDedSlip)
                                        <tr>
                                            <th>{{ $salaryDedSlip->dedType->description ?? ''}}</th>
                                            <td style="float: right">{{ number_format((double)$salaryDedSlip->rate, 2, '.', '') ?? ''}}</td>
                                        </tr>
                                    @endforeach
                                    <tr style="text-decoration-line: overline;">
                                        <th><h4><b>Total Deduction</b></h4></th>

                                        <td style="float: right; text-decoration-line: overline;"><h4><b>{{number_format((double)$dedTotal, 2, '.', '') ?? ''}}</b></h4></td>
                                    </tr>
                                </table>

                            </div>
                        </td>
                    </tr>
                    </tbody>

                </table>

                <div style="display: block;margin-top: 0.5em;margin-bottom: 0.5em;margin-left: auto;margin-right: auto;border-style: inset;border-width: 1px;"></div>
                <div class="portlet-body">
                    <table class="table">
                        <tr>
                            <th><h3><b>Take Home Salary</b></h3></th>
                            <td><h3><b>{{number_format((double)$payTotal-$dedTotal, 2, '.', '') ?? ''}}</b></h3></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

@stop