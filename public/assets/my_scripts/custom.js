$(document).on('submit', 'form.delete_item_form', function () {
    var txt;
    var r = confirm("Are you sure?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
});


$(document).on('keydown', '.numeric_field', function (e) {
    var key = e.charCode || e.keyCode || 0;
    // allow backspace, tab, delete, arrows, numbers, dot and keypad numbers ONLY
    return (key == 8 || key == 9 || key == 46 || (key >= 37 && key <= 40) || key == 190 || key == 110 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
});


$(document).on('keydown', '.numeric_field2', function (e) {
    var key = e.charCode || e.keyCode || 0;
    /*console.log("key" + key);*/
    // allow backspace, tab, delete, arrows, numbers, dot and keypad numbers ONLY
    return (key == 8 || key == 9 || key == 46 || (key >= 37 && key <= 40) || key == 190 || key == 110 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105) || key == 109 || key == 173 || key == 189);
});

$(document).on('keydown', '.int_field', function (e) {
    var key = e.charCode || e.keyCode || 0;
    // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
    return (key == 8 || key == 9 || key == 46 || (key >= 37 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
});

function dateFormat(date, format) {
    format = format.replace("DD", (date.getDate() < 10 ? '0' : '') + date.getDate());
    format = format.replace("MM", (date.getMonth() < 9 ? '0' : '') + (date.getMonth() + 1));
    format = format.replace("YYYY", date.getFullYear());
    return format;
}


/**
 * Module for displaying "Waiting for..." dialog using Bootstrap
 *
 * @author Eugene Maslovich <ehpc@em42.ru>
 */

function ZeroToBlank(val) {
    val = (isNaN(parseFloat(val)) ? 0 : parseFloat(val)).toFixed(2);

    if (val == 0 || val == 0.00) val = "";
    return val;
}

function displayLoader() {
    $("body").LoadingOverlay("show");
}

function hideLoader() {
    $("body").LoadingOverlay("hide");
}

function getBranchDivisionList(branchID, field_id) {
    $.ajax({
        url: base_url + '/getBranchDivisions',
        type: "GET",
        cache: false,
        data: {
            branchID: branchID
        },
        success: function (data) {
            $("#" + field_id).html(data);
        },
        error: function () {

        }
    });
}


function getBranchEmployeesByEmp(employeeId, field_id) {

    $.ajax({
        url: base_url + '/getBranchEmployeesByEmp',
        type: "GET",
        cache: false,
        data: {
            employeeId: employeeId
        },
        success: function (data) {
            $("#" + field_id).html(data);
        },
        error: function () {

        }
    });
}


function getCurrentBranchEmployees(branchId, field_id) {
    $.ajax({
        url: base_url + '/getCurrentBranchEmployees',
        type: "GET",
        cache: false,
        data: {
            branchId: branchId
        },
        success: function (data) {
            $("#" + field_id).html(data);
        },
        error: function () {

        }
    });
}

function getBranchEmployeeList(empId, field_id) {
    $.ajax({
        url: base_url + '/getBranchEmployees',
        type: "GET",
        cache: false,
        data: {
            empId: empId
        },
        success: function (data) {
            $("#" + field_id).html(data);
        },
        error: function () {

        }
    });
}

function getEmployeeBasicInfo(employee_Id) {
    $.ajax({
        url: base_url + '/getEmpBasic',
        type: "GET",
        cache: false,
        data: {
            employeeId: employee_Id
        },
        success: function (data) {
            if (data !== '') {
                let employeeName = data.employee_name;
                let designation = data.designation;
                let branch = data.branch_name;
                let designation_id = data.designation_id;

                $('#employee_name').val(employeeName);
                $('#employee_designation').val(designation);
                $('#employee_branch').val(branch);
                $('#designation_id').val(designation_id);

            } else {
                console.log('No Employee Found')
            }
        },
        error: function () {
            alert('Get Exception on Attempt.');
        }
    });
}

function getBranchDivisionListEdit(branchID, field_id) {
    $.ajax({
        url: base_url + '/getBranchDivisions',
        type: "GET",
        cache: false,
        data: {
            branchID: branchID
        },
        success: function (data) {

            $("#" + field_id).html(data);
        },
        error: function () {

        }
    });
}

function getBranchDivisionDepartmentList(divisionID, field_id, branchID = null) {
    if (branchID == null) {
        branchID = $('#branch_id').val();
    }

    $.ajax({
        url: base_url + '/getBranchDivisionDepartments',
        type: "GET",
        cache: false,
        data: {
            branchID: branchID,
            divisionID: divisionID
        },
        success: function (data) {
            $("#" + field_id).html(data);
        },
        error: function () {

        }
    });
}

function getDisciplinaryPunishments(action_type) {

    $.ajax({
        url: base_url + '/disciplinaryAction/getDisciplinaryPunishments',
        type: "GET",
        cache: false,
        data: {
            typeId: action_type
        },
        success: function (data) {
            $('#action_taken_id').html(data);
        },
        error: function () {

        }
    });
}

function getHead(head_type) {

    if (head_type == 'P') {
        $('#payTypeArea').removeClass('hidden');
        $('#deductTypeArea').hide();
        $('#payTypeArea').show();
    } else if (head_type == 'D') {
        $('#deductTypeArea').removeClass('hidden');
        $('#payTypeArea').hide();
        $('#deductTypeArea').show();
    } else {
        $('#payTypeArea').hide();
        $('#deductTypeArea').hide();
    }
}

function getBranch(head_office) {
    if (head_office == '2') {
        $('#branchType').removeClass('hidden');
        $('#cbsCode').removeClass('hidden');
        $('#brLoc').removeClass('hidden');
        $('#clusterId').removeClass('hidden');
        $('#branchType').show();
        $('#cbsCode').show();
        $('#brLoc').show();
        $('#brSt').show();
        $('#clusterId').show();
    } else {
        $('#branchType').hide();
        $('#cbsCode').hide();
        $('#brLoc').hide();
        $('#clusterId').hide();
        $('#subBranchType').hide();
    }
}

function getSubBranch(branch_type) {

    if (branch_type == '2') {
        $('#subBranchType').removeClass('hidden');
        $('#subBranchType').show();
    } else {
        $('#subBranchType').hide();
    }
}


function getBranchDivisionDepartmentListEdit(divisionID, field_id, branchID = null) {
    // console.log(branchID);
    if (branchID == null) {
        branchID = $('#branch_id').select2('val');
    }

    // console.log(branchID);

    $.ajax({
        url: base_url + '/getBranchDivisionDepartments',
        type: "GET",
        cache: false,
        data: {
            branchID: branchID,
            divisionID: divisionID
        },
        success: function (data) {
            $("#" + field_id).html(data);
        },
        error: function () {

        }
    });
}

function getBranchDivisionDepartmentUnitList(departmentID, field_id, divisionID = null, branchID = null) {
    if (branchID == null) {
        branchID = $('#branch_id').val();
    }
    if (divisionID == null) {
        divisionID = $('#division_id').val();
    }

    $.ajax({
        url: base_url + '/getBranchDivisionDepartmentUnits',
        type: "GET",
        cache: false,
        data: {
            branchID: branchID,
            divisionID: divisionID,
            departmentID: departmentID
        },
        success: function (data) {
            $("#" + field_id).html(data);
        },
        error: function () {

        }
    });
}

function getBranchDivisionDepartmentUnitListEdit(departmentID, field_id, divisionID = null, branchID = null) {
    if (branchID == null) {
        branchID = $('#branch_id').select2('val');
    }
    if (divisionID == null) {
        divisionID = $('#division_id').val();
    }

    $.ajax({
        url: base_url + '/getBranchDivisionDepartmentUnits',
        type: "GET",
        cache: false,
        data: {
            branchID: branchID,
            divisionID: divisionID,
            departmentID: departmentID
        },
        success: function (data) {
            $("#" + field_id).html(data);
        },
        error: function () {

        }
    });
}

function authLogin() {
    let settings = {
        "url": "../salary-account/authLogin",
        "method": "GET",
        "timeout": 0,
    };

    $.ajax(settings).done(function (response) {
        console.log(response);
    });
}


/*$(document).ready(function () {*/
    $('#account_no').on('keyup', function (event) {
        console.log('Check');
        getAccInfo($('#account_no').val(),1);
    });

    function getAccInfo(accNo, cond) {
        console.log('accNo', accNo);
        let urlPath;
        if (cond === 1) {
            urlPath = '../salary-account/getAccInfo/';
        } else {
            urlPath = '../getAccInfo/';
        }

        $.ajax({

            url: urlPath + accNo,
            type: "GET",
            cache: false,
            success: function (data) {
                if (data != '') {
                    var obj = jQuery.parseJSON(data);
                    if (obj.AccountNo == null) {
                        alert('No Customer Found');
                        return false;
                    }
                    let AccountNo = obj.AccountNo;
                    let Customer = obj.Customer;
                    let AcName = obj.AcName;
                    /*let MobileNo = obj.MobileNo;
                    let EmailId = obj.EmailId;
                    let NationalID = obj.NationalID;
    */
                    $('#acc_no').val(AccountNo);
                    $('#customer_id').val(Customer);
                    $('#cus_name').val(AcName);


                } else {
                    alert('Unsuccessfully attempt.');
                }
            },
            error: function () {
                alert('Get Exception on Attempt.');
            }
        });
    }
/*});*/



