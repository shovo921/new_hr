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
        <div class="page-title"> Employee Salary Adjustment Details </div>

        <div id="success_message"></div>

        <ul id="update_msgList"></ul>

        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-gift"></i>Employee Profile Information</div>
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
                <div class="caption"><i class="fa fa-gift"></i>Temp salary Information</div>
            </div>
            <div class="portlet-body">
                <table class="table">
                    <tr>
                        <th>Payment date</th>
                        <td>
                            {{ \Carbon\Carbon::parse($PaidDay->payment_date)->format('d-m-Y') }}

                        </td>
                        <th>Year Month</th>
                        <td>{{ $PaidDay->year_month?? ''}}</td>
                    </tr>
                    <tr>
                        <th>Day count</th>
                        <td>{{ $PaidDay->day_count?? ''}}</td>
                        <th>Day paid</th>
                        <td>{{ $PaidDay->day_paid?? ''}}</td>
                    </tr>
                    <tr>
                        <th>ready to pay</th>
                        <td>{{ $PaidDay->ready_to_pay==1 ? 'No' : 'Yes'}}</td>
                        <th>remarks</th>
                        <td>{{ $PaidDay->remarks?? ''}}</td>
                        <th>Employee type</th>
                        <td>  {{ $PaidDay->emp_status == 1 ? 'Regular' : 'Resign' }}</td>

                    </tr>
                </table>

            </div>
        </div>

        <div class="portlet box blue">
            <div class="portlet-title">


                <a href="{{ url('salary-amount/view/'.$employeeSalary->employee->employee_id) }}" class="btn btn-default pull-right"
                   style="margin-top: 3px;">
                    <i class="fa fa-info"></i>
                   Master Salary Information
                </a>

                <div class="caption"><i class="fa fa-gift"></i>Salary Adjustment Information</div>


                <div class="tools"></div>





            </div>
            <div class="portlet-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="all">Payment Head</th>
                        <th class="all">Deduction Head </th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="portlet-body">
                                <table class="table">
                                    @foreach($paytypedata as $salaryPaySlip)
                                        <tr>
                                            <th>{{ $salaryPaySlip->payType->description ?? ''}}</th>

                                            <td style="float: right">
                                                <button type="button" value="{{ $salaryPaySlip->type_id ?? ''}}" class="btn btn-default editbtn btn-sm"><i class="fa fa-pencil"></i>
                                                </button>
                                            </td>
                                            <th style="float: right">{{ $salaryPaySlip->pay_type ==1 ? 'Account' : 'Cash'}}</th>


                                            <td style="float: right">{{ number_format((double)$salaryPaySlip->pay_amount, 2, '.', '') ?? ''}}</td>

                                        </tr>
                                    @endforeach
{{--                                    {{die()}}--}}
                                    <tr style="text-decoration-line: overline;">
                                        <th><h4><b>Gross Payment</b></h4></th>
                                        <td style="float: right; text-decoration-line: overline;"><h4><b>{{ number_format((double)$payTotal, 2, '.', '') ?? ''}}</b></h4></td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                        <td>
                            <div class="portlet-body">
                                <table class="table">
                                    @foreach($dedtypedata as $salaryDedSlip)

                                        <tr>
                                            <th>{{ $salaryDedSlip->dedType->description ?? ''}}</th>
                                            <td style="float: right">
                                                <button type="button" value="{{ $salaryDedSlip->type_id}}" class="btn btn-default editbtndedType btn-sm"><i class="fa fa-pencil"></i>
                                                </button>
                                            </td>
                                            <td style="float: right">{{ number_format((double)$salaryDedSlip->pay_amount, 2, '.', '') ?? ''}}</td>
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





    {{-- Starting Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit & Update Payment OR Deduction Head Data</h5>
                </div>
                <div class="modal-body">
                    <ul id="update_msgList"></ul>
                    <input type="hidden" id="stud_id" />

                    <table class="table table-bordered" id="edit_table">
                        <thead>
                        <tr>
                            <th class="min-phone-l">Payment OR Deduction Head</th>
                            <th class="min-phone-l">Amount</th>
                            <th class="min-phone-l">Pay Type</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <div class="form-group mb-3">
                                <input type="hidden" name="emp_id" id="emp_id"  required class="emp_id form-control">
                            </div>

                            <div class="form-group mb-3">
                                <input type="hidden" name="status" id="status"  required class="status form-control">
                            </div>

                            <div class="form-group mb-3">
                                <input type="hidden" name="ptype_id" id="ptype_id"  required class="ptype_id form-control">
                            </div>
                            <div class="form-group mb-3">
                                <input type="hidden" name="pay_or_ded_type" id="pay_or_ded_type"  required class="pay_or_ded_type form-control">
                            </div>

                            <td> <input type="text" name="description" id="description"  readonly class="description form-control"></td>
                            <td> <input type="text" name="amount" id="amount" value=""  class="amount form-control"> </td>
                            <td> <select name="status1" id="status1" class="status1 form-control" >
                                    <option value='1'>Account</option>
                                    <option value='2'>Cash</option>
                                </select></td>
                        </tr>
                        </tbody>
                    </table>
                    {{--@if($salaryPaySlips->count()>0)
                        {{$salaryPaySlips->appends($_REQUEST)->render()}}
                    @endif--}}


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary update_phead">Update</button>
                </div>

            </div>
        </div>
    </div>
    {{-- End Edit Modal --}}

@stop


@section('script')
    <script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/components-multi-select.min.js') }}"
            type="text/javascript"></script>



    <script>

        function myFunction() {
            var x = document.getElementById("status1").value;
            console.log(x);
        }

        $(document).ready(function(){

            $(document).on('click', '.editbtn', function (e) {
                e.preventDefault();
                var id = $(this).val();
                var pay_or_ded_type  =1
                var employee_id = {{$employeeSalary->employee->employee_id}};
                $('#editModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: base_url + "/emp-salary-adjustment/edit-pay-or-ded/" + employee_id + "/"+ pay_or_ded_type + "/"+ id,
                    success: function (response) {
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#editModal').modal('hide');
                        } else {
                            $('#description').val(response.salaryPaySlips.description);
                            $('#emp_id').val(response.salaryPaySlips.employee_id);
                            $('#status').val(response.salaryPaySlips.status);
                            $('#amount').val(response.salaryPaySlips.pay_amount);
                            $('#status1').val(response.salaryPaySlips.pay_type);
                            $('#ptype_id').val(response.salaryPaySlips.type_id);
                            $('#pay_or_ded_type').val(1);
                        }
                    }
                });
                $('.btn-close').find('input').val('');

            });

            $(document).on('click', '.editbtndedType', function (e) {
                e.preventDefault();
                var id = $(this).val();
                var employee_id = {{$employeeSalary->employee->employee_id}};
                var pay_or_ded_type  =2
                $('#editModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: base_url + "/emp-salary-adjustment/edit-pay-or-ded/" + employee_id + "/"+ pay_or_ded_type + "/"+ id,
                    success: function (response) {
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#editModal').modal('hide');
                        } else {
                            $('#description').val(response.salaryPaySlips.description);
                            $('#emp_id').val(response.salaryPaySlips.employee_id);
                            $('#status').val(response.salaryPaySlips.status);
                            $('#amount').val(response.salaryPaySlips.pay_amount);
                            $('#status1').val(response.salaryPaySlips.pay_type);
                            $('#ptype_id').val(response.salaryPaySlips.type_id);
                            $('#pay_or_ded_type').val(2);
                        }
                    }
                });
                $('.btn-close').find('input').val('');

            });

            $(document).on('click', '.update_phead', function (e) {
                e.preventDefault();
                var id = $('#ptype_id').val();
                var employee_id = {{$employeeSalary->employee->employee_id}};
                var pay_or_ded_type=$('#pay_or_ded_type').val();
                var data = {
                    'status1': $('#status1').val(),
                    'amount': $('#amount').val()
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: base_url + "/emp-salary-adjustment/update-pay-or-ded/" + employee_id + "/"+ pay_or_ded_type + "/"+ id,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        if (response == 400) {
                            $('#update_msgList').html("");
                            $('#update_msgList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_value) {
                                $('#update_msgList').append('<li>' + err_value +
                                    '</li>');
                            });
                            $('.update_phead').text('Update');
                        } else {
                            $('#update_msgList').html("");
                            $('#editModal').find('input').val('');
                            $('.update_phead').text('Update');
                            $('#editModal').modal('hide');
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            window.location.reload();
                        }
                    }
                });

            });

        });

    </script>
    <script src="{{asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

@stop
