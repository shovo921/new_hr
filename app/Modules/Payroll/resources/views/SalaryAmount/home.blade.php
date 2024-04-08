@extends('layouts.app_new')

@section('content')


    {{-- Add Modal --}}
    <div class="modal fade" id="AddPtypeModal" tabindex="-1" aria-labelledby="AddPtypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddPtypeModalLabel">Add Payment Type Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="save_msgList"></ul>
                    <div class="form-group mb-3">
                        <label for="">Description</label>
                        <input type="text" required class="description form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Status</label>
                        <input type="text" required class="status form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_ptype">Save</button>
                </div>

            </div>
        </div>
    </div>
    {{-- End of Add Modal --}}

    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">

                <div id="success_message"></div>

                <div class="card">
                    <div class="card-header">
                        <h4>
                            Payment Head Data
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                                    data-bs-target="#AddPtypeModal">Add Payment Type</button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Description</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection


@section('script')

    <script>

        $(document).on('click', '.add_ptype', function (e) {
            e.preventDefault();

            var data = {
                'description': $('.description').val(),
                'status': $('.status').val(),
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "http://localhost/padma-hr-and-payroll/public/salary-amount",
                data: data,
                dataType: "json",
                success: function (response) {
                    console.log(response);
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
                    }
                }
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
