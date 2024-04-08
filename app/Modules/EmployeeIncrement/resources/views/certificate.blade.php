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
            <span>Employee  Salary Certificate</span>
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
    <div class="page-title">Employee  Salary Certificate</div>
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>Employee  Salary Certificate Information</div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>
                    <a href="javascript:;" class="reload"> </a>
                </div>
            </div>
        </div>

        <div class="portlet-body form">
            <div class="col-md-12">
                <a class="btn btn-info pull-right" onclick="PrintElem('printArea')"><i class="fa fa-print"></i>Print</a>
            </div>

            <div class="col-md-10" id="printArea">
                <p style="text-align: right;"><img src="{{asset('/assets/layouts/layout/img/logo.png')}}" /></p>
                <p style="text-align: center; font-size: 16px;">Human Resource Division</p>
                <p>PADMA/HO/HRD/{{date('Y')}}/</p>
                <p>{{strtoupper(date('d-M-Y'))}}</p>
                <p style="text-align: center; font-size: 20px; font-weight: bold;">To Whom It May Concern</p>
                <p>

                    This is to certify {{$employeeInfo->employee_name}}, ID# {{$employeeInfo->employee_id}} has been working in Padma Bank PLC. since {{strtoupper($employeeInfo->joining_date)}}. He is a permanent employee of the bank who is currently working in our {{$employeeInfo->branch_name}} as {{$employeeInfo->designation}}
                </p>
                <p>His monthly salary is as follows:</p>
                <div class="col-md-10 col-md-offset-1">
                    <table width="70%">
                        <tr>
                            <th width="70%"><u>Payment Head</u></th>
                            <th width="30%" style="text-align: right;"><u>Amount in BDT</u></th>
                        </tr>
                        <?php 
                        $inductive_total = 0;
                        $basic_salary = 0; 
                        ?>
                        @foreach($salaryHeads as $salaryHead)
                        @if($salaryHead->head_type == 'Inductive')
                        <tr>
                            <td>{{ $salaryHead->salary_head }}</td>
                            <td align="right">
                                @if($salaryHead->salary_head == 'Basic Pay')
                                @if($employeeSalaryData->current_basic != '')
                                <?php 
                                $basic_salary = $employeeSalaryData->current_basic;
                                $inductive_total = $inductive_total + $basic_salary;
                                ?>
                                @else
                                <?php 
                                $basic_salary = $salaryBasicInfo->basic_salary;
                                $inductive_total = $inductive_total + $basic_salary;
                                ?>
                                @endif
                                {{ number_format($basic_salary, 2) }}
                                @elseif($salaryHead->salary_head == 'House Rent')
                                <?php 
                                $house_rent = (((int)$basic_salary * (int)$salaryHead->percentage) / 100);
                                $inductive_total = $inductive_total + $house_rent;
                                ?>
                                {{ number_format($house_rent, 2) }}
                                @elseif($salaryHead->salary_head == 'Conveyance Allowances')
                                @if($employeeSalaryData->conveyance != '')
                                <?php $conveyance = $employeeSalaryData->conveyance; ?>
                                @else
                                <?php $conveyance = $salaryBasicInfo->conveyance; ?>
                                @endif
                                <?php $inductive_total = $inductive_total + $conveyance; ?>
                                {{ number_format($conveyance, 2) }}
                                @elseif($salaryHead->salary_head == 'Medical Allowances')
                                @if($employeeSalaryData->medical != '')
                                <?php $medical = $employeeSalaryData->medical; ?>
                                @else
                                <?php $medical = $salaryBasicInfo->medical; ?>
                                @endif
                                <?php $inductive_total = $inductive_total + $medical; ?>
                                {{ number_format($medical, 2) }}
                                @elseif($salaryHead->salary_head == 'PF Bank Contribution')
                                @if($employeeSalaryData->pf != '')
                                <?php $pf = $employeeSalaryData->pf; ?>
                                @else
                                <?php $pf = (((int)$basic_salary * (int)$salaryHead->percentage) / 100); ?>
                                @endif
                                <?php $inductive_total = $inductive_total + $pf; ?>
                                {{ number_format($pf, 2) }}
                                @elseif($salaryHead->salary_head == 'House Maintenance Allowances')
                                @if($employeeSalaryData->house_maintenance != '')
                                <?php $house_maintenance = $employeeSalaryData->house_maintenance; ?>
                                @else
                                <?php $house_maintenance = $salaryHead->house_maintenance; ?>
                                @endif
                                <?php $inductive_total = $inductive_total + $house_maintenance; ?>
                                {{ number_format($house_maintenance, 2) }}
                                @elseif($salaryHead->salary_head == 'Utility Allowances')
                                @if($employeeSalaryData->utility != '')
                                <?php $utility = $employeeSalaryData->utility; ?>
                                @else
                                <?php $utility = $salaryHead->utility; ?>
                                @endif
                                <?php $inductive_total = $inductive_total + $utility; ?>
                                {{ number_format($utility, 2) }}
                                @elseif($salaryHead->salary_head == 'L.F.A (Inland Travel)')
                                @if($employeeSalaryData->lfa != '')
                                <?php $lfa = $employeeSalaryData->lfa; ?>
                                @else
                                <?php $lfa = $salaryHead->lfa; ?>
                                @endif
                                <?php $inductive_total = $inductive_total + $lfa; ?>
                                {{ number_format($lfa, 2) }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        <tr style="border-top: 1px solid #000;">
                            <th>Gross Payment</th>
                            <th style="text-align: right;">{{ number_format($inductive_total, 2) }}</th>
                        </tr>
                        <tr>
                            <th style="text-decoration: underline;padding-top: 10px;">Deduction Head</th>
                            <td>&nbsp;</td>
                        </tr>
                        <?php $deduction_total = 0; ?>
                        @foreach($salaryHeads as $salaryHead)
                        @if($salaryHead->head_type == 'Deductive')
                        <tr>
                            <td>{{$salaryHead->salary_head}}</td>
                            <td align="right">
                                @if($salaryHead->salary_head == 'PF Bank Contribution')
                                @if($employeeSalaryData->pf != '')
                                <?php $pf = $employeeSalaryData->pf; ?>
                                @else
                                <?php $pf = (((int)$basic_salary * (int)$salaryHead->percentage) / 100); ?>
                                @endif

                                <?php $deduction_total = $deduction_total + $pf; ?>
                                {{ number_format($pf, 2) }}
                                @elseif($salaryHead->salary_head == 'PF Member Contribution')
                                @if($employeeSalaryData->pf != '')
                                <?php $pf = $employeeSalaryData->pf; ?>
                                @else
                                <?php $pf = (((int)$basic_salary * (int)$salaryHead->percentage) / 100); ?>
                                @endif
                                <?php $deduction_total = $deduction_total + $pf; ?>
                                {{ number_format($pf, 2) }}
                                @elseif($salaryHead->salary_head == 'Income TAX')
                                <?php
                                $tax = $employeeSalaryData->income_tax;
                                $deduction_total = $deduction_total + $tax;
                                ?>
                                {{ number_format($tax, 2) }}
                                @elseif($salaryHead->salary_head == 'Employees Welfare Fund')
                                <?php
                                $welfare_fund = $employeeSalaryData->welfare_fund;
                                $deduction_total = $deduction_total + $welfare_fund;
                                ?>
                                {{ number_format($welfare_fund, 2) }}
                                @elseif($salaryHead->salary_head == 'Employee House Building Loan Installment')
                                <?php
                                $hb_loan_installment = $employeeSalaryData->hb_loan_installment;
                                $deduction_total = $deduction_total + $hb_loan_installment;
                                ?>
                                {{ number_format($hb_loan_installment, 2) }}
                                @elseif($salaryHead->salary_head == 'Executive Car Loan Installment')
                                <?php
                                $car_loan_installment = $employeeSalaryData->car_loan_installment;
                                $deduction_total = $deduction_total + $car_loan_installment;
                                ?>
                                {{ number_format($car_loan_installment, 2) }}
                                @elseif($salaryHead->salary_head == 'Employee PF Loan Installment')
                                <?php
                                $pf_loan_installment = $employeeSalaryData->pf_loan_installment;
                                $deduction_total = $deduction_total + $pf_loan_installment;
                                ?>
                                {{ number_format($pf_loan_installment, 2) }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach

                        <tr style="border-top: 1px solid #000;">
                            <th>Total Deduction</th>
                            <th style="text-align: right;">{{ number_format($deduction_total, 2) }}</th>
                        </tr>

                        <tr style="border-top: 1px solid #000;">
                            <th>Take Home Salary</th>
                            <th style="text-align: right;">{{ number_format(($inductive_total - $deduction_total), 2) }}</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    function PrintElem(elem)
    {
        var mywindow = window.open('', 'PRINT', 'height=400,width=600');
        var htmlData = document.getElementById(elem).innerHTML;

        // alert(htmlData);

        //mywindow.document.write('<html><head><title>Salary Certificate</title>');
        //mywindow.document.write('</head><body >');
        // mywindow.document.write('<h1>' + document.title  + '</h1>');
        mywindow.document.write(htmlData);
        //mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>
@stop
