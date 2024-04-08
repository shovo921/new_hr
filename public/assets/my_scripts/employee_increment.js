function getEmployeeCurrentSalary(employee_id, kk = null) {

    if (employee_id !== '') {

        $.ajax({
            url: getEmployeeCurrentSalaryInfo,
            type: "POST",
            cache: false,
            data: {
                employee_id: employee_id
            },
            success: function (resdata) {
                if (data != '') {

                    var data = jQuery.parseJSON(resdata);

                    let employeeInfo = data.employeeInfo;
                    // var obj = jQuery.parseJSON(data.employeeSalaryData);
                    let empSalary = data.employeeSalaryData;
                    let empBasicSlave = data.employeeDesigSlav;

                    console.log('employeeInfo1111', employeeInfo,empSalary,empBasicSlave);
                    $('#designationArea').removeClass('hidden');
                    var desig = employeeInfo.emp_designation + '<input type="hidden" name="designation_id" id="designation_id" value=' + employeeInfo.designation_id + ' />';
                    $('#designationInfo').html(desig);


//console.log('Length',$('#promoted_des_id').length);
                    if ($('#promoted_des_id').length > 0) {
                        $('#previous_des_id').val(employeeInfo.designation_id);
                        $('#promoted_des_id').val(employeeInfo.designation_id);
                    }

                    let basic = null;

                    if(empSalary.current_basic ===  undefined){
                        basic =empSalary.basic_salary;
                    }else{
                        basic =empSalary.current_basic;
                    }


                    if (empSalary.consolidated_flag == 0) {
                        if (basic != undefined) {


                            if (kk != 1) {
                                console.log('111');
                                $('#current_inc_slave').val(empSalary.current_inc_slave);
                                $('#current_basic').val(basic);
                                $('#house_rent').val(empSalary.house_rent);
                                $('#gross_total').val(empSalary.gross_total);
                                $('#medical').val(empSalary.medical);
                                $('#conveyance').val(empSalary.conveyance);
                                $('#house_maintenance').val(empSalary.house_maintenance);
                                $('#utility').val(empSalary.utility);
                                $('#lfa').val(empSalary.lfa);
                                $('#others').val(empSalary.others);
                                $('#consolidated_amount').val(empSalary.consolidated_salary);
                                $('#car_allowance').val(empSalary.car_maintenance);
                            }

                        } else {
                            console.log('112');
                            $('#current_inc_slave').val('0');

                            let basic_salary = parseInt(basic);
                            let house_rent = basic_salary / 2;

                            $('#current_basic').val(basic_salary);
                            $('#house_rent').val(house_rent);
                            $('#medical').val(empBasicSlave.medical);
                            $('#conveyance').val(empBasicSlave.conveyance);
                            $('#house_maintenance').val(empBasicSlave.house_maintenance);
                            $('#utility').val(empBasicSlave.utility);
                            $('#lfa').val(empBasicSlave.lfa);
                            $('#consolidated_amount').val(empSalary.consolidated_salary);
                            $('#car_allowance').val(empSalary.car_maintenance);

                            calculateGrossTotal();
                        }
                    } else {
                        let house_rent = parseInt(basic) / 2;
                        console.log('113');
                        $('#current_inc_slave').val(empSalary.current_inc_slave);
                        $('#current_basic').val(empSalary.basic_salary);
                        $('#house_rent').val(house_rent);
                        $('#medical').val(empSalary.medical);
                        $('#conveyance').val(empSalary.conveyance);
                        $('#house_maintenance').val(empSalary.house_maintenance);
                        $('#utility').val(empSalary.utility);
                        $('#lfa').val(empSalary.lfa);
                        $('#car_allowance').val(empSalary.car_maintenance);
                        $('#consolidated_amount').val(empSalary.consolidated_salary);
                        $('#others').val(empSalary.others);
                        $('#gross_total').val(empSalary.gross_total);
                    }

                } else {


                    $('#designationArea').addClass('hidden');
                    $('#designationInfo').html('');

                    alert('Unsuccessfully attempt. ');
                }
            },
            error: function () {
                alert('Get Exception on Attempt. 1');
            }
        });
    } else {
        console.log("no data found...");
        $('#salaryIncriment').trigger("reset");
    }
}


function calculateUpdateBasic(incrementSlave) {
    if (incrementSlave == 19) {
        $('#current_basic').val(0);
        $('#current_basic').prop('readonly', false);

        $('#house_rent').val(0);
        $('#house_rent').prop('readonly', false);

        $('#medical').val(0);
        $('#medical').prop('readonly', false);

        $('#conveyance').val(0);
        $('#conveyance').prop('readonly', false);

        $('#house_maintenance').val(0);
        $('#house_maintenance').prop('readonly', false);

        $('#utility').val(0);
        $('#utility').prop('readonly', false);

        $('#lfa').val(0);
        $('#lfa').prop('readonly', false);

        $('#car_allowance').val(0);
        $('#car_allowance').prop('readonly', false);

        $('#consolidated_amount').val(0);
        $('#consolidated_amount').prop('readonly', false);

        $('#others').val(0);
        $('#others').prop('readonly', false);

        $('#gross_total').val(0);
        $('#gross_total').prop('readonly', false);
    } else {
        console.log('incrementSlave', incrementSlave,$('#designation_id').val());
        //console.log('$(\'#designation_id\').', $('#designation_id').val());

        let designationId =null;
        if ($('#designation_id').length == 0) {
            designationId = $('#promoted_des_id').val();
        } else {
            designationId = $('#designation_id').val();
        }

        $.ajax({
            url: getEmployeeSalarySlaveInfo,
            type: "POST",
            cache: false,
            data: {
                designation_id: designationId,
                incrementSlave: incrementSlave
            },
            success: function (data) {
                var obj1 = jQuery.parseJSON(data);

                if (data != '') {
                    let obj = jQuery.parseJSON(data);
                    //console.log('data-obj-basic_salary', obj.salaryDetailsData);
                    let basic_salary = obj.salaryDetailsData.basic_salary;
                    //var current_inc_slave = obj.current_inc_slave;

                    let house_rent = basic_salary / 2;
                    let medical = obj.salaryDetailsData.medical;
                    let conveyance = obj.salaryDetailsData.conveyance;
                    let house_maintenance = obj.salaryDetailsData.house_maintenance;
                    let utility = obj.salaryDetailsData.utility;
                    let lfa = obj.salaryDetailsData.lfa;
                    let others = obj.salaryDetailsData.others;
                    let car_allowance = obj.salaryDetailsData.car_allowance;
                    let consolidated_amount = obj.salaryDetailsData.consolidated_amount;

                    $('#current_basic').val(basic_salary);
                    $('#house_rent').val(house_rent);
                    $('#medical').val(medical);
                    $('#conveyance').val(conveyance);
                    $('#house_maintenance').val(house_maintenance);
                    $('#utility').val(utility);
                    $('#lfa').val(lfa);
                    $('#others').val(others);
                    $('#lfa').val(lfa);
                    $('#car_allowance').val(car_allowance);
                    $('#consolidated_amount').val(consolidated_amount);
                    $('#current_inc_slave').val(incrementSlave);

                    if(basic_salary === undefined){
                        getEmployeeCurrentSalary($('#employee_id').val(), 1);
                        $('#consolidated_amount').prop('readonly', false);
                    }else {
                        $('#consolidated_amount').prop('readonly', true);
                    }

                    calculateGrossTotal();

                    $('#current_basic').prop('readonly', true);
                    $('#house_rent').prop('readonly', true);
                    $('#medical').prop('readonly', true);
                    $('#conveyance').prop('readonly', true);
                    $('#house_maintenance').prop('readonly', true);
                    $('#utility').prop('readonly', true);
                    $('#lfa').prop('readonly', true);
                    $('#car_allowance').prop('readonly', true);

                    $('#others').prop('readonly', false);
                    $('#gross_total').prop('readonly', true);

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


function calculateGrossTotal() {
    let current_basic = $('#current_basic').val();
    let house_rent = $('#house_rent').val();
    let medical = $('#medical').val();
    let conveyance = $('#conveyance').val();
    let house_maintenance = $('#house_maintenance').val();
    let utility = $('#utility').val();
    let lfa = $('#lfa').val();
    let others = $('#others').val();

    let gross_total = 0;
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



function authorizeViewModal(empId) {
    let base_url =  window.location.href;
    /*const myArray = empId.split(",");*/
    console.log(empId);
    $.ajax({
        url :'http://localhost/hrms/public/incrementAuthorizationView',
       // url :'http://localhost/hrms/public/incrementAuthorizationView/'+myArray[0]+'/'+myArray[1],
        type : "GET",
        cache : false,
        data: {
            employee_id:empId,
        },
        success : function(data) {
            alert(data);
            $('#salOrIncrementAuth').html(data);
            $('#salOrIncrementAuthModal').modal('show');
        },
        error: function() {
            alert('Get Exception on Attempt.');
        }
    });
}