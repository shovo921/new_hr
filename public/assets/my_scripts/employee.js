$(document).ready(function () {
    $('#joining_date').bind('blur change keyup', function (e) {
        var joining_date = $('#joining_date').val();
        var employeeID = $('#employee_id').val();

        $.ajax({
            url: getUpdatedEmployeeID,
            type: "POST",
            //dataType : "json",
            cache: false,
            data: {
                employee_id: employeeID,
                joining_date: joining_date
            },
            success: function (data) {
                // console.log(data);
                $("#employee_id").val(data);
            },
            error: function () {

            }
        });
    });

    $('#relative_employee_id').bind('blur change', function (e) {
        var employeeID = $('#relative_employee_id').val();
        if (employeeID != '') {
            $.ajax({
                url: getEmployeeInfo,
                type: "POST",
                //dataType : "json",
                cache: false,
                data: {
                    employee_id: employeeID
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    $("#employee_info").html('Name: ' + obj.employee_name + '<br />Designation: ' + obj.designation + '<br />Branch: ' + obj.branch_name);
                },
                error: function () {

                }
            });
        }
    });

    $('#marital_status').bind('change', function (e) {
        var marital_status = $('#marital_status').val();
        if (marital_status == 'Married')
            $('#spouse_name').attr('required', true);
        else
            $('#spouse_name').removeAttr('required');
    });

    /*$('#result_type').bind('change', function(e){
        var result_type = $('#result_type').val();
        if(result_type == 'division') {
            var selectField = '<select id="result" class="form-control" name="result[]"><option value="" selected="selected">--Please Select--</option><option value="1st Division/Class">1st Division/Class</option><option value="2nd Division/Class">2nd Division/Class</option><option value="3rd Division/Class">3rd Division/Class</option></select>';
            $('#result_type').closest('td').next().html(selectField);
        }
        else {
            var inputField = '<input id="result" class="form-control" name="result[]" type="number">';
            $('#result_type').closest('td').next().html(inputField);
        }
    }).change();*/
    $('#result_type').change(function () {
        var result_type = $('#result_type').val();
        if (result_type === 'division') {
            console.log('division');
            var selectField = '<select id="result" class="form-control" name="result[]"><option value="" selected="selected">--Please Select--</option><option value="1st Division/Class">1st Division/Class</option><option value="2nd Division/Class">2nd Division/Class</option><option value="3rd Division/Class">3rd Division/Class</option></select>';
            $('#result_type').closest('td').next().html(selectField);
        } else {
            console.log('CGPA');
            var inputField = '<input id="result" class="form-control" name="result[]" type="number">';
            $('#result_type').closest('td').next().html(inputField);
        }
    }).change();

    $('#institute_name').change(function () {
        var institute_name = $('#institute_name').val();
        if (institute_name === 'Add New') {
            console.log('division');
            alert('institute_name Add')
            profDegreeDiplomaAddModal();
        }

    }).change();

    $('.nominee_birth_date').bind('blur change keyup keydown', function (e) {
        var birthDayDate = $('#nominee_birth_date').val();

        var from = birthDayDate.split("/");
        var birthdateTimeStamp = new Date(from[2], from[1] - 1, from[0]);

        var cur = new Date();
        var diff = cur - birthdateTimeStamp;
        var currentAge = Math.floor(diff / 31557600000);

        // $('#nominee_birth_date').closest('td').next().html(currentAge);
        $('.nominee_birth_date').closest('td').next().find('#nominee_age').val(currentAge);
    });

    $('#exp_start_date, #exp_end_date').bind('blur change keyup keydown', function (e) {
        var start_date = $('#exp_start_date').val();
        var end_date = $('#exp_end_date').val();

        var from = start_date.split("/");
        var startDateTimeStamp = new Date(from[2], from[1] - 1, from[0]);

        var to_date = end_date.split("/");
        var endDateTimeStamp = new Date(to_date[2], to_date[1] - 1, to_date[0]);

        // var cur = new Date();
        var diff = endDateTimeStamp - startDateTimeStamp;

        //var currentAge = Math.floor(diff/31557600000);

        // $('#nominee_birth_date').closest('td').next().html(currentAge);

        console.log("start_date" + start_date);
        console.log("end_date" + end_date);

        if (start_date != '' && end_date != '') {
            var day = 1000 * 60 * 60 * 24;

            var total_days = Math.floor(diff / day);

            var years = Math.floor(total_days / 365);
            var remaining_days = Math.floor(total_days % 365);

            var months = Math.floor(remaining_days / 31);
            var days = Math.floor(remaining_days % 31);


            var message = '';
            message += years + " years ";
            message += months + " months ";
            message += days + " days ";

            console.log(message);

            $('#duration').val(message);
        }
    });

    $('#employment_type').bind('change', function (e) {
        let employment_type = $('#employment_type option:selected').text();



        if (employment_type === 'Contractual' || employment_type === 'Probation') {
            let inputField = '<div class="col-md-6">' +
                '<div class="form-group">' +
                '<label class="col-md-4 control-label">Period Start Date<span class="required">*</span></label>' +
                '<div class="col-md-8">' +
                '<input id="period_start_date" placeholder="dd/mm/yyyy" class="form-control date-picker" name="period_start_date" type="text" readonly="readonly" required>' +
                '</div></div></div>' +
                '<div class="col-md-6">' +
                '<div class="form-group">' +
                '<label class="col-md-4 control-label">Period End Date<span class="required">*</span></label>' +
                '<div class="col-md-8">' +
                '<input id="period_end_date" placeholder="dd/mm/yyyy" class="form-control date-picker" name="period_end_date" type="text" readonly="readonly" required>' +
                '</div></div></div>';

            $('#prov_contract_area').html(inputField);
        } else {
            $('#prov_contract_area').html('');
        }

        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            orientation: "bottom",
            maxDate: '0'
        });
    }).change();

    /*$('#kinship_declaration').bind('change', function(e){
        var kinship_declaration = $( 'input[name=kinship_declaration]:checked' ).val();
        alert(kinship_declaration);
        if(kinship_declaration == 'Yes') {
            $('#kinshipArea').removeClass('hidden');
        }
        else {
            $('#kinshipArea').addClass('hidden');
        }
    });*/

    $("#kinship_declaration1").change(function () {
        $('#kinshipArea').removeClass('hidden');
    });
    $("#kinship_declaration2").change(function () {
        $('#kinshipArea').addClass('hidden');
    });

    $("#release_order_type").change(function () {
        var release_order_type = $('#release_order_type option:selected').val();

        if (release_order_type === 'Conditional Release')
            $('#releaseArea').removeClass('hidden');
        else
            $('#releaseArea').addClass('hidden');
    });

    /*$(".button").click(function() {
        $("#myform #valueFromMyButton").text($(this).val().trim());
        $("#myform input[type=text]").val('');
        $("#valueFromMyModal").val('');
        $("#myform").show(500);
    });
    $("#btnOK").click(function() {
        $("#valueFromMyModal").val($("#myform input[type=text]").val().trim());
        $("#myform").hide(400);
    });*/
});

function getEmployeePrefix(staff_type) {
    if (staff_type === 'Sales Staff') {
        $("#prefix").val('R');
    } else if (staff_type === 'Support Staff') {
        $("#prefix").val('C');
    } else {
        $("#prefix").val('');
    }

    if (staff_type !== '') {
        $.ajax({
            url: getEmployeeFileNumber,
            type: "POST",
            //dataType : "json",
            cache: false,
            data: {
                staff_type: staff_type
            },
            success: function (data) {
                $("#personal_file_no").val(data);
            },
            error: function () {

            }
        });
    }
}

function tableAddRow(tableID) {
    var table = document.getElementById(tableID);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var colCount = table.rows[0].cells.length;

    for (var i = 0; i < colCount; i++) {
        var newcell = row.insertCell(i);

        newcell.innerHTML = table.rows[0].cells[i].innerHTML;
        //alert(newcell.childNodes);
        switch (newcell.childNodes[0].type) {
            case "text":
                newcell.childNodes[0].value = "";
                break;
            case "checkbox":
                newcell.childNodes[0].checked = false;
                break;
            case "select-one":
                newcell.childNodes[0].selectedIndex = 0;
                break;
        }
    }

    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd/mm/yyyy',
        orientation: "bottom",
        maxDate: '0'
    });
}

function tableDeleteRow(tableID) {
    try {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;

        for (var i = 0; i < rowCount; i++) {
            var row = table.rows[i];
            var chkbox = row.cells[0].childNodes[0];
            if (null != chkbox && true == chkbox.checked) {
                if (rowCount <= 1) {
                    alert("Cannot delete all the rows.");
                    break;
                }
                table.deleteRow(i);
                rowCount--;
                i--;
            }
        }
    } catch (e) {
        alert(e);
    }
}

function getEmployeeDistrictList(division_id, field_id) {
    $.ajax({
        url: getDistricts,
        type: "GET",
        //dataType : "json",
        cache: false,
        data: {
            division_id: division_id
        },
        success: function (data) {
            $("#" + field_id).html(data);
        },
        error: function () {

        }
    });
}

function getEmployeeThanaList(district_id, field_id) {
    $.ajax({
        url: getThanas,
        type: "GET",
        //dataType : "json",
        cache: false,
        data: {
            district_id: district_id
        },
        success: function (data) {
            $("#" + field_id).html(data);
        },
        error: function () {

        }
    });
}

function createNewUser() {


    var name = $('#name').val();
    var email1 = $('#email').val();
    if (email1) {
        var email = email1;
    } else {
        var email = 'test@email.com';
    }

    var employee_id = $('#employee_id').val();
    var joining_date = $('#joining_date').val();
    var prefix = $('#prefix').val();
    var personal_file_no = $('#personal_file_no').val();
    var staff_type = $('#staff_type').val();
    var mobile_no = $('#mobile_no').val();
    var employment_type = $('#employment_type').val();
    var employment_type_text = $('#employment_type option:selected').text();
    var period_start_date = $('#period_start_date').val();
    var period_end_date = $('#period_end_date').val();

    var validStatus = '0';
    var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
    // var mobile_pattern = /^0\d{10}$/;
    var mobile_pattern = /^(?:\+88|88)?(01[3-9]\d{8})$/;

    // console.log(mobile_pattern.test(MOBILE_NO));

    if (name == '') {
        $('#name').css('border', '1px solid #f00');
        validStatus = '1';
    } else {
        $('#name').css('border', '1px solid #ccc');
    }

    if (email == '') {
        /*if(! pattern.test(email)) {
            $('#email').css('border', '1px solid #f00');
            //validStatus = '1';
        }*/
        $('#email').css('border', '1px solid #ccc');

    }

    if (employee_id == '') {
        $('#employee_id').css('border', '1px solid #f00');
        validStatus = '1';
    } else {
        $('#employee_id').css('border', '1px solid #ccc');
    }

    if (staff_type == '') {
        $('#staff_type').css('border', '1px solid #f00');
        validStatus = '1';
    } else {
        $('#staff_type').css('border', '1px solid #ccc');
    }

    if (joining_date == '') {
        $('#joining_date').css('border', '1px solid #f00');
        validStatus = '1';
    } else {
        $('#joining_date').css('border', '1px solid #ccc');
    }

    if (personal_file_no == '') {
        $('#personal_file_no').css('border', '1px solid #f00');
        validStatus = '1';
    } else {
        $('#personal_file_no').css('border', '1px solid #ccc');
    }

    if (employment_type == '') {
        $('#employment_type').css('border', '1px solid #f00');
        validStatus = '1';
    } else {
        $('#employment_type').css('border', '1px solid #ccc');
    }

    if (employment_type_text == 'Contractual' || employment_type_text == 'On Provision') {
        if (period_start_date == '') {
            $('#period_start_date').css('border', '1px solid #f00');
            validStatus = '1';
        } else {
            $('#period_start_date').css('border', '1px solid #ccc');
        }
        if (period_end_date == '') {
            $('#period_end_date').css('border', '1px solid #f00');
            validStatus = '1';
        } else {
            $('#period_end_date').css('border', '1px solid #ccc');
        }
    }

    if (mobile_no == '' || !mobile_pattern.test(mobile_no)) {
        $('#mobile_no').css('border', '1px solid #f00');
        validStatus = '1';
    } else {
        $('#mobile_no').css('border', '1px solid #ccc');
    }

    //alert(validStatus);

    if (validStatus == '0') {
        $.ajax({
            url: createEmployee,
            type: "POST",
            cache: false,
            data: {
                _token: $("input[name=_token]").val(),
                name: name,
                email: email,
                employee_id: employee_id,
                joining_date: joining_date,
                prefix: prefix,
                personal_file_no: personal_file_no,
                staff_type: staff_type,
                mobile_no: mobile_no,
                employment_type: employment_type,
                period_start_date: period_start_date,
                period_end_date: period_end_date
            },
            success: function (data) {
                console.log(name);

                if (employee_id != null) {
                    alert('Employee Information Successfully Saved.');
                    window.location.href = base_url + '/employee/' + data + '/edit';
                } else {
                    alert('Unsuccessfully attempt.');
                }
            },
            error: function () {

            }
        });
    }
}

function updateUserBasicInfo() {
    var validStatus = '0';

    $(':input[required]:visible').each(function () {
        if ($(this).val() === '') {
            $(this).css('border', '1px solid #f00').focus();
            validStatus = '1';
        } else {
            $(this).css('border', '1px solid #ccc');
        }
    });

    if (validStatus === '0') {
        $.ajax({
            url: updateUserBasic,
            type: "POST",
            cache: false,
            data: $('#employeeAccount').serialize(),
            success: function (data) {
                console.log(data);
                if (data !== '') {
                    alert('Employee Information Successfully Updated.');
                    $('.buttonNext').click();
                } else {
                    alert('Unsuccessfully attempt.');
                }
            },
            error: function () {
                alert('Get Exception on Attempt.');
            }
        });
    }
}

function updateUserInfo() {
    var validStatus = '0';
    console.log('validStatus', validStatus);
    $(':input[required]:visible').each(function () {
        if ($(this).val() === '') {
            $(this).css('border', '1px solid #f00').focus();
            validStatus = '1';
        } else {
            $(this).css('border', '1px solid #ccc');
        }
    });

    if (validStatus === '0') {
        console.log('#employeeProfile', validStatus);
        $.ajax({
            url: updateEmployee,
            type: "POST",
            cache: false,
            data: $('#employeeProfile').serialize(),
            success: function (data) {

                if (data != '') {
                    alert('Employee Information Successfully Updated.');
                    $('.buttonNext').click();
                } else {
                    console.log('data', data);
                    alert('Unsuccessfully attempt.');
                }
            },
            error: function () {
                alert('Get Exception on Attempt.');
            }
        });
    }
}

function updateOtherUserInfo() {
    var validStatus = '0';

    $(':input[required]:visible').each(function () {
        if ($(this).val() == '') {
            $(this).css('border', '1px solid #f00').focus();
            validStatus = '1';
        } else {
            $(this).css('border', '1px solid #ccc');
        }
    });

    if (validStatus == '0') {
        $.ajax({
            url: updateEmployeeOtherInfo,
            type: "POST",
            cache: false,
            data: $('#employeeOtherInfo').serialize(),
            success: function (data) {
                if (data != '') {
                    alert('Employee Information Successfully Updated.');
                    $('.buttonNext').click();
                } else {
                    alert('Unsuccessfully attempt.');
                }
            },
            error: function () {
                alert('Get Exception on Attempt.');
            }
        });
    }
}

function updateUserSkillInfo() {
    var validStatus = '0';

    $(':input[required]:visible').each(function () {
        if ($(this).val() == '') {
            $(this).css('border', '1px solid #f00').focus();
            validStatus = '1';
        } else {
            $(this).css('border', '1px solid #ccc');
        }
    });

    if (validStatus == '0') {
        $.ajax({
            url: updateEmployeeSkillInfo,
            type: "POST",
            cache: false,
            data: $('#employeeSkillInfo').serialize(),
            success: function (data) {
                if (data != '') {
                    alert('Employee Information Successfully Updated.');
                    $('.buttonNext').click();
                } else {
                    alert('Unsuccessfully attempt.');
                }
            },
            error: function () {
                alert('Get Exception on Attempt.');
            }
        });
    }
}

function updateTransferInfo() {
    var validStatus = '0';

    $(':input[required]:visible').each(function () {
        if ($(this).val() == '') {
            $(this).css('border', '1px solid #f00').focus();
            validStatus = '1';
        } else {
            $(this).css('border', '1px solid #ccc');
        }
    });

    if (validStatus == '0') {
        $.ajax({
            url: updateEmployeeTransferInfo,
            type: "POST",
            cache: false,
            data: $('#employeeTransfer').serialize(),
            success: function (data) {
                if (data != '') {
                    alert('Employee Transfer / Posting request submitted and send for authorization.');
                    $('.buttonNext').click();
                } else {
                    alert('Employee Transfer / Posting request already submitted waiting for authorization.');
                }
            },
            error: function () {
                alert('Get Exception on Attempt.');
            }
        });
    }
}

function updateExperienceInfo() {
    var validStatus = '0';

    $(':input[required]:visible').each(function () {
        if ($(this).val() == '') {
            $(this).css('border', '1px solid #f00').focus();
            validStatus = '1';
        } else {
            $(this).css('border', '1px solid #ccc');
        }
    });

    if (validStatus == '0') {
        $.ajax({
            url: updateEmployeeExperienceInfo,
            type: "POST",
            cache: false,
            data: $('#employeeExperience').serialize(),
            success: function (data) {
                if (data != '') {
                    alert('Employee Information Successfully Updated.');

                    $('#employeeExperience').each(function () {
                        this.reset();
                    });

                    $('.buttonNext').click();
                } else {
                    alert('Unsuccessfully attempt.');
                }
            },
            error: function () {
                alert('Get Exception on Attempt.');
            }
        });
    }
}

function calculateHouseRent(basic_salary) {
    var house_rent = basic_salary / 2;

    $('#house_rent').val(house_rent);

    calculateGrossTotal();
}


function calculatePromotionBasic(designation_id, prev_designation_id, incrementSlave) {
    $.ajax({
        url: getEmployeePromotedSalaryInfo,
        type: "POST",
        cache: false,
        data: {
            designation_id: designation_id,
            prev_designation_id: prev_designation_id,
            incrementSlave: incrementSlave
        },
        success: function (data) {
            if (data != '') {
                var obj = jQuery.parseJSON(data);

                console.log(obj);

                var inc_slave = obj.new_inc_slave;

                var basic_salary = obj.new_basic;
                var house_rent = basic_salary / 2;
                var medical = obj.new_medical;
                var conveyance = obj.new_conveyance;
                var house_maintenance = obj.new_house_maintenance;
                var utility = obj.new_utility;
                var lfa = obj.new_lfa;

                $('#current_inc_slave').val(inc_slave);
                $('#current_basic').val(basic_salary);
                $('#house_rent').val(house_rent);
                $('#medical').val(medical);
                $('#conveyance').val(conveyance);
                $('#house_maintenance').val(house_maintenance);
                $('#utility').val(utility);
                $('#lfa').val(lfa);

                calculateGrossTotal();
            } else {
                alert('Unsuccessfully attempt.');
            }
        },
        error: function () {
            alert('Get Exception on Attempt.');
        }
    });
}

function calculatePromotionBasicWith(incrementSlave) {
    var designation_id = $('#promoted_des_id').val();

    $.ajax({
        url: getEmployeeSalarySlaveInfo,
        type: "POST",
        cache: false,
        data: {
            designation_id: designation_id,
            incrementSlave: incrementSlave
        },
        success: function (data) {
            if (data != '') {
                var obj = jQuery.parseJSON(data);

                var basic_salary = obj.basic_salary;

                var house_rent = basic_salary / 2;

                $('#current_basic').val(basic_salary);
                $('#house_rent').val(house_rent);

                calculateGrossTotal();
            } else {
                alert('Unsuccessfully attempt.');
            }
        },
        error: function () {
            alert('Get Exception on Attempt. 111111');
        }
    });
}

function profDegreeDiplomaAddModal() {
    $.ajax({
        url: '../../profInstituteNameAdd',
        type: "GET",
        cache: false,
        data: {
            id: 1,
        },
        success: function (data) {
            $('#profDiplomaDegreeEdit').html(data);
            $("#profDegreeDiplomaAddModal").modal('show');
        },
        error: function () {
            alert('Get Exception on Attempt.');
        }
    });
}

function educationInfoModal(education_id) {
    $.ajax({
        url: '../../educationEdit',
        type: "GET",
        cache: false,
        data: {
            education_id: education_id
        },
        success: function (data) {
            alert(data);
            $('#educationEdit').html(data);
            $("#educationEditModal").modal('show');
        },
        error: function () {
            alert('Get Exception on Attempt.');
        }
    });
}

function profDegreeModal(prof_degree_id) {
    $.ajax({
        url: '../../profDegreeEdit',
        type: "GET",
        cache: false,
        data: {
            prof_degree_id: prof_degree_id
        },
        success: function (data) {
            $('#profDegreeEdit').html(data);
            $("#profDegreeEditModal").modal('show');

            $('body').on('focus', ".date-picker", function () {
                $(this).datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    orientation: "bottom",
                    maxDate: '0'
                });
            });
        },
        error: function () {
            alert('Get Exception on Attempt.');
        }
    });
}

function profTrainingModal(prof_training_id) {
    $.ajax({
        url: '../../profTrainingEdit',
        type: "GET",
        cache: false,
        data: {
            prof_training_id: prof_training_id
        },
        success: function (data) {
            $('#traningEdit').html(data);
            $("#traningEditModal").modal('show');

            $('body').on('focus', ".date-picker", function () {
                $(this).datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    orientation: "bottom",
                    maxDate: '0'
                });
            });
        },
        error: function () {
            alert('Get Exception on Attempt.');
        }
    });
}

function childrenInfoModal(children_id) {
    $.ajax({
        url: '../../childrenInfoEdit',
        type: "GET",
        cache: false,
        data: {
            children_id: children_id
        },
        success: function (data) {
            $('#childrenEdit').html(data);
            $("#childrenEditModal").modal('show');
        },
        error: function () {
            alert('Get Exception on Attempt.');
        }
    });
}

function referenceInfoModal(reference_id) {
    $.ajax({
        url: '../../referenceInfoEdit',
        type: "GET",
        cache: false,
        data: {
            reference_id: reference_id
        },
        success: function (data) {
            $('#referenceEdit').html(data);
            $("#referenceEditModal").modal('show');
        },
        error: function () {
            alert('Get Exception on Attempt.');
        }
    });
}

function nomineeInfoModal(nominee_id) {
    $.ajax({
        url: '../../nomineeInfoEdit',
        type: "GET",
        cache: false,
        data: {
            nominee_id: nominee_id
        },
        success: function (data) {
            $('#nomineeEdit').html(data);
            $("#nomineeEditModal").modal('show');

            $('body').on('focus', ".date-picker", function () {
                $(this).datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    orientation: "bottom",
                    maxDate: '0'
                });
            });
        },
        error: function () {
            alert('Get Exception on Attempt.');
        }
    });
}

function projectModal(project_id) {
    $.ajax({
        url: '../../projectEdit',
        type: "GET",
        cache: false,
        data: {
            project_id: project_id
        },
        success: function (data) {
            $('#modalTitle').html("Project Works Edit");
            $('#commonEdit').html(data);
            $("#commonEditModal").modal('show');

            $('body').on('focus', ".date-picker", function () {
                $(this).datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    orientation: "bottom",
                    maxDate: '0'
                });
            });
        },
        error: function () {
            alert('Get Exception on Attempt.');
        }
    });
}

function specializationModal(specialization_id) {
    $.ajax({
        url: '../../specializationEdit',
        type: "GET",
        cache: false,
        data: {
            specialization_id: specialization_id
        },
        success: function (data) {
            $('#modalTitle').html("Specialization Edit");
            $('#commonEdit').html(data);
            $("#commonEditModal").modal('show');
        },
        error: function () {
            alert('Get Exception on Attempt.');
        }
    });
}

function experienceModal(experience_id) {
    $.ajax({
        url: '../../experienceEdit',
        type: "GET",
        cache: false,
        data: {
            experience_id: experience_id
        },
        success: function (data) {
            $('#modalTitle').html("Professional Experience Edit");
            $('#commonEdit').html(data);
            $("#commonEditModal").modal('show');

            $('body').on('focus', ".date-picker", function () {
                $(this).datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    orientation: "bottom",
                    maxDate: '0'
                });
            });
        },
        error: function () {
            alert('Get Exception on Attempt.');
        }
    });
}

function showClusterBranches() {
    var designation_name = $('#functional_designation').find("option:selected").text();

    if (designation_name == 'Cluster Head') {
        $('#clusterBranchesArea').removeClass('hidden');
    } else {
        $('#clusterBranchesArea').addClass('hidden');
    }
}

function calculateGrossTotal() {
    var current_basic = $('#current_basic').val();
    var house_rent = $('#house_rent').val();
    var medical = $('#medical').val();
    var conveyance = $('#conveyance').val();
    var house_maintenance = $('#house_maintenance').val();
    var utility = $('#utility').val();
    var lfa = $('#lfa').val();
    var others = $('#others').val();

    var gross_total = 0;
    if (current_basic != '')
        gross_total = gross_total + parseFloat(current_basic);
    if (house_rent != '')
        gross_total = gross_total + parseFloat(house_rent);
    if (medical != '')
        gross_total = gross_total + parseFloat(medical);
    if (conveyance != '')
        gross_total = gross_total + parseFloat(conveyance);
    if (house_maintenance != '')
        gross_total = gross_total + parseFloat(house_maintenance);
    if (utility != '')
        gross_total = gross_total + parseFloat(utility);
    if (lfa != '')
        gross_total = gross_total + parseFloat(lfa);
    if (others != '')
        gross_total = gross_total + parseFloat(others);

    $('#gross_total').val(gross_total.toFixed(2));
}
