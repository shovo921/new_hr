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
        <div class="page-title">Edit Employee Salary Details </div>

        <div id="success_message"></div>

        <ul id="update_msgList"></ul>

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
                <div class="caption1"><button type="button" class="btn btn-default pull-right" data-toggle="modal"
                                              data-target="#AddDtypeModal" style="margin-top: 3px;"> <i class="fa fa-plus">Add Salary Info</i></button></div>
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
                                    @foreach($salaryPaySlips as $salaryPaySlip)
                                        <tr>
                                            <th>{{ $salaryPaySlip->payType->description ?? ''}}</th>

                                            <td style="float: right"><button type="button" value="{{ $salaryPaySlip->ptype_id ?? ''}}" class="btn btn-default editbtn btn-sm"><i class="fa fa-pencil"></i></button></td>
                                            <th style="float: right">{{ $salaryPaySlip->status1 ?? ''}}</th>
                                            <td style="float: right">{{ number_format((double)$salaryPaySlip->amount, 2, '.', '') ?? ''}}</td>

                                        </tr>
                                    @endforeach
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

    {{-- Add Modal --}}
    <div class="modal fade" id="AddDtypeModal" tabindex="-1" aria-labelledby="AddDtypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddDtypeModalLabel">Add Deduction Type And Payment Type Head</h5>
                </div>
                <div class="modal-body">
                    <ul id="save_msgList"></ul>

                    <div class="form-group mb-3">
                        <input type="hidden" value={{$employeeSalary->employee->employee_id}} required class="emp_id form-control">
                    </div>


                    <div class="form-group mb-3">
                        <label class="control-label">Choose  Head Type :</label>
                        <select required class="type_id form-control select2">
                            <option value={{Null}}>Please Select</option>
                            <option  value="1">Payment Head</option>
                            <option  value="2">Deduction Head</option>
                        </select>
                    </div>

                    <div class="form-group mb-3 p_type_head">
                        <label class="control-label">Choose Payment Head:</label>
                        <select required class="paytype_id form-control select2">
                            <option value={{Null}}>Please Select</option>
                            @foreach($payHeadTypeDatas as $payHeadTypeDatas)
                                <option  value={{$payHeadTypeDatas->ptype_id}}>{{$payHeadTypeDatas->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3 d_type_head" >
                        <label class="control-label">Choose Deduction Head :</label>
                        <select required class="dtype_id form-control select2">
                            <option value={{Null}}>Please Select</option>
                            @foreach($dedTypeDatas as $dedTypeData)
                                <option  value={{$dedTypeData->dtype_id}}>{{$dedTypeData->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Amount</label>
                        <input type="text" required class="rate form-control">
                    </div>

                    <div class="form-group mb-3">
                        <input type="hidden" value="Y" required class="status form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Status</label>
                        <select required class="status1 form-control select2">
                            <option value={{Null}}>Please Select</option>
                            <option value='A'>Account</option>
                            <option value='C'>Cash</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_dtype">Save</button>
                </div>

            </div>
        </div>
    </div>
    {{-- End of Add Modal --}}




    {{-- Starting Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit & Update Payment Head Data</h5>
                </div>

                <div class="modal-body">

                    <ul id="update_msgList"></ul>

                    <input type="hidden" id="stud_id" />

                    <table class="table table-bordered" id="edit_table">
                        <thead>
                        <tr>
                            <th class="min-phone-l">Payment Head</th>
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

                            <td> <input type="text" name="description" id="description" readonly class="description form-control"></td>
                            <td> <input type="text" name="amount" id="amount" value="" readonly class="amount form-control"> </td>
                            <td> <select name="status1" id="status1" class="status1 form-control" >
                                    <option value='A'>Account</option>
                                    <option value='C'>Cash</option>
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
        $(document).ready(function () {
            $(".p_type_head, .d_type_head").hide();
            $(".type_id").change(function () {

                $(".p_type_head, .d_type_head").hide();
                var selectedHeadType = $(this).val();
                if (selectedHeadType === "1") {
                    $(".p_type_head").show();
                } else if (selectedHeadType === "2") {
                    $(".d_type_head").show();
                }
            });
        });
    </script>
    <script>

        function myFunction() {
            var x = document.getElementById("status1").value;
            console.log(x);
        }

        $(document).ready(function(){
            $(document).on('click', '.add_dtype', function (e) {
                e.preventDefault();
                var data = {
                    'emp_id': $('.emp_id').val(),
                    'status': $('.status').val(),
                    'status1': $('.status1').val(),
                    'rate': $('.rate').val(),
                    'type_id': $('.type_id').val(),
                    'ptype_id': $('.paytype_id').val(),
                    'dtype_id': $('.dtype_id').val(),

                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: base_url + '/salary-amount',
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 400) {
                            $('#save_msgList').html("");
                            $('#save_msgList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_value) {
                                $('#save_msgList').append('<li>' + err_value + '</li>');
                            });
                            $('.add_dtype').text('Save');
                        } else {
                            $('#save_msgList').html("");
                            $('#AddDtypeModal').find('input').val('');
                            $('.add_dtype').text('Save');
                            $('#AddDtypeModal').modal('hide');
                            window.location.reload();
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                        }
                    }
                });

            });

            $(document).on('click', '.editbtn', function (e) {
                e.preventDefault();
                var id = $(this).val();
                var employee_id = {{$employeeSalary->employee->employee_id}};
                $('#editModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: base_url + "/salary-amount/edit-payhead/" + employee_id + "/"+ id,
                    success: function (response) {
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#editModal').modal('hide');
                        } else {
                            $('#description').val(response.salaryPaySlips.description);
                            $('#emp_id').val(response.salaryPaySlips.emp_id);
                            $('#status').val(response.salaryPaySlips.status);
                            $('#amount').val(response.salaryPaySlips.amount);
                            $('#status1').val(response.salaryPaySlips.status1);
                            $('#ptype_id').val(response.salaryPaySlips.ptype_id);
                        }
                    }
                });
                $('.btn-close').find('input').val('');

            });

            $(document).on('click', '.update_phead', function (e) {
                e.preventDefault();
                var id = $('#ptype_id').val();
                var employee_id = {{$employeeSalary->employee->employee_id}};

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
                    url: base_url + "/salary-amount/update-payhead/" + employee_id + "/"+ id,
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
