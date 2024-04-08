{{--@extends('layouts.app_new')--}}
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
                <span>Employee Salary Information</span>
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


    {{-- Add Modal --}}
    <div class="modal fade" id="AddPtypeModal" tabindex="-1" aria-labelledby="AddPtypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddPtypeModalLabel">Add Payment Head</h5>
                </div>
                <div class="modal-body">
                    <ul id="save_msgList"></ul>

                    <div class="form-group mb-3">
                        <input type="hidden" value={{$employee_id}} required class="emp_id form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Choose a Payment Head:</label>
                        <select required class="ptype_id form-control">
                            <option value={{Null}}>Please Select</option>
                            @foreach($payHeadLists as $payHeadList)
                            <option value={{$payHeadList->ptype_id}}>{{$payHeadList->description}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Amount</label>
                        <input type="text" required class="amount form-control">
                    </div>

                    <div class="form-group mb-3">
                        <input type="hidden" value="Y" required class="status form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Status</label>
                        <select required class="status1 form-control">
                                <option value={{Null}}>Please Select</option>
                                <option value='A'>Account</option>
                                <option value='C'>Cash</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_ptype">Save</button>
                </div>

            </div>
        </div>
    </div>
    {{-- End of Add Modal --}}



    <!-- BEGIN PAGE TITLE-->
    <div class="row">
        <div class="col-md-12" style="margin-top:20px;">
            <div class="table-responsive">

                <div id="success_message"></div>

                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet blue box">
                    <div class="portlet-title">

                            <button type="button" class="btn btn-default pull-right" data-toggle="modal"
                                    data-target="#AddPtypeModal" style="margin-top: 3px;" > <i class="fa fa-plus"></i> Add Payment Head</button>

                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">Salary Information</span>
                        </div>
                        <div class="tools"></div>
                    </div>

                    <div class="portlet-body">

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="min-phone-l">Payment Head</th>
                                <th class="min-phone-l">Amount</th>
                                <th class="min-phone-l">Status</th>
                            </tr>
                            </thead>
                            <tbody>
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


@section('script')

    <script>

        $(document).ready(function(){

            fetchInfo();

            function fetchInfo() {
                var id = {{$employee_id}}

                $.ajax({
                    type: "GET",
                    url: base_url + '/salary-amount/fetch-info/'+id,
                    dataType: "json",
                    success: function (response) {
                        $('tbody').html("");
                        $.each(response.salaryPaySlips, function (key, item) {
                            if(item.status1=='A'){
                                var str='Account'
                            }else{
                                var str='Cash'
                            }
                            $('tbody').append('<tr>\
                            <td>' + item.description + '</td>\
                            <td>' + item.amount + '</td>\
                            <td>' + str + '</td>\
                            <td><button type="button" value="' + item.ptype_id + '" class="btn btn-primary editbtn btn-sm purple pull-left"><i class="fa fa-edit"></i>Edit</button></td>\
                        \</tr>');
                        });
                    }
                });
            }


        $(document).on('click', '.add_ptype', function (e) {

            e.preventDefault();

            var data = {
                'emp_id': $('.emp_id').val(),
                'status': $('.status').val(),
                'status1': $('.status1').val(),
                'amount': $('.amount').val(),
                'ptype_id': $('.ptype_id').val(),
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
                        $('.add_ptype').text('Save');
                    } else {
                        $('#save_msgList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#AddPtypeModal').find('input').val('');
                        $('.add_ptype').text('Save');
                        $('#AddPtypeModal').modal('hide');
                        fetchInfo();
                    }
                }
            });

        });

        });

    </script>

{{--    <script>
        $(document).ready(function () {

            fetchstudent();

            function fetchstudent() {
                $.ajax({
                    type: "GET",
                    url: "/fetch-students",
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                        $('tbody').html("");
                        $.each(response.students, function (key, item) {
                            $('tbody').append('<tr>\
                            <td>' + item.id + '</td>\
                            <td>' + item.name + '</td>\
                            <td>' + item.course + '</td>\
                            <td>' + item.email + '</td>\
                            <td>' + item.phone + '</td>\
                            <td><button type="button" value="' + item.id + '" class="btn btn-primary editbtn btn-sm">Edit</button></td>\
                            <td><button type="button" value="' + item.id + '" class="btn btn-danger deletebtn btn-sm">Delete</button></td>\
                        \</tr>');
                        });
                    }
                });
            }

            $(document).on('click', '.add_student', function (e) {
                e.preventDefault();

                $(this).text('Sending..');

                var data = {
                    'name': $('.name').val(),
                    'course': $('.course').val(),
                    'email': $('.email').val(),
                    'phone': $('.phone').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/students",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 400) {
                            $('#save_msgList').html("");
                            $('#save_msgList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_value) {
                                $('#save_msgList').append('<li>' + err_value + '</li>');
                            });
                            $('.add_student').text('Save');
                        } else {
                            $('#save_msgList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#AddStudentModal').find('input').val('');
                            $('.add_student').text('Save');
                            $('#AddStudentModal').modal('hide');
                            fetchstudent();
                        }
                    }
                });

            });

            $(document).on('click', '.editbtn', function (e) {
                e.preventDefault();
                var stud_id = $(this).val();
                // alert(stud_id);
                $('#editModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "/edit-student/" + stud_id,
                    success: function (response) {
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#editModal').modal('hide');
                        } else {
                            // console.log(response.student.name);
                            $('#name').val(response.student.name);
                            $('#course').val(response.student.course);
                            $('#email').val(response.student.email);
                            $('#phone').val(response.student.phone);
                            $('#stud_id').val(stud_id);
                        }
                    }
                });
                $('.btn-close').find('input').val('');

            });

            $(document).on('click', '.update_student', function (e) {
                e.preventDefault();

                $(this).text('Updating..');
                var id = $('#stud_id').val();
                // alert(id);

                var data = {
                    'name': $('#name').val(),
                    'course': $('#course').val(),
                    'email': $('#email').val(),
                    'phone': $('#phone').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: "/update-student/" + id,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 400) {
                            $('#update_msgList').html("");
                            $('#update_msgList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_value) {
                                $('#update_msgList').append('<li>' + err_value +
                                    '</li>');
                            });
                            $('.update_student').text('Update');
                        } else {
                            $('#update_msgList').html("");

                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#editModal').find('input').val('');
                            $('.update_student').text('Update');
                            $('#editModal').modal('hide');
                            fetchstudent();
                        }
                    }
                });

            });

            $(document).on('click', '.deletebtn', function () {
                var stud_id = $(this).val();
                $('#DeleteModal').modal('show');
                $('#deleteing_id').val(stud_id);
            });

            $(document).on('click', '.delete_student', function (e) {
                e.preventDefault();

                $(this).text('Deleting..');
                var id = $('#deleteing_id').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "/delete-student/" + id,
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 404) {
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.delete_student').text('Yes Delete');
                        } else {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.delete_student').text('Yes Delete');
                            $('#DeleteModal').modal('hide');
                            fetchstudent();
                        }
                    }
                });
            });

        });

    </script>--}}

@stop
