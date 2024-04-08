function calculatePromotedBasic(designation_id) {

    let prev_designation_id = $('#previous_des_id').val();
    //let promoted_designation_id = $('#promoted_des_id').val(designation_id);
    let incrementSlave = $('#current_inc_slave').val();
    let employeeId = $('#employee_id').val();
    let currBasic = $('#current_basic').val();

    if (prev_designation_id === '' || prev_designation_id === undefined) {
        $('#promoted_des_id').val(designation_id);
        alert('Designation info not found.');
        return false;
    } else if (incrementSlave === '' || incrementSlave === undefined) {
        alert('Increment Slave info not found.');
        return false;
    } else {
        $.ajax({
            url: getEmployeePromotedSalaryInfo,
            type: "POST",
            cache: false,
            data: {
                designation_id: designation_id,
                employeeId: employeeId,
                prev_designation_id: prev_designation_id,
                incrementSlave: incrementSlave,
                currBasic: currBasic,
            },
            success: function (data) {
                if (data !== '') {
                    var obj = jQuery.parseJSON(data);

                    console.log('obj',obj);

                    var inc_slave = obj.new_inc_slave;

                    var basic_salary = obj.new_basic;
                    var house_rent = basic_salary / 2;
                    var medical = obj.new_medical;
                    var conveyance = obj.new_conveyance;
                    var house_maintenance = obj.new_house_maintenance;
                    var utility = obj.new_utility;
                    var lfa = obj.new_lfa;
                    var car_allowance = obj.new_car_maintenance;
                    var consolidated_amount = obj.new_consolidated_salary;

                    $('#current_inc_slave').val(inc_slave);
                    $('#current_basic').val(basic_salary);
                    $('#house_rent').val(house_rent);
                    $('#medical').val(medical);
                    $('#conveyance').val(conveyance);
                    $('#house_maintenance').val(house_maintenance);
                    $('#car_allowance').val(car_allowance);
                    $('#consolidated_amount').val(consolidated_amount);
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
}

function getEmployeeCurrentSalaryPromotion(employee_id, kk = null, designation_id) {

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
                    let empSalary = data.employeeSalaryData;
                    let empBasicSlave = data.employeeDesigSlav;

                    console.log('employeeInfo1', empSalary.consolidated_salary);

                    $('#designationArea').removeClass('hidden');
                    var desig = employeeInfo.emp_designation + '<input type="hidden" name="designation_id" id="designation_id" value=' + employeeInfo.designation_id + ' />';
                    $('#designationInfo').html(desig);

                    if (designation_id == null) {
                        $('#previous_des_id').val(employeeInfo.designation_id);
                        $('#promoted_des_id').val(employeeInfo.designation_id);
                    } else {
                        $('#promoted_des_id').val(designation_id);
                    }


                    let basic = null;


                    if (empSalary.current_basic === undefined) {
                        basic = empSalary.basic_salary;
                    } else {
                        basic = empSalary.current_basic;
                    }

                    console.log('Test KK',kk);
                    if (empSalary.consolidated_flag == 0) {
                        if (basic != undefined) {


                            if (kk != 1) {
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
                                $('#consolidated_salary').val(empSalary.consolidated_salary);
                                $('#car_allowance').val(empSalary.car_maintenance);
                            }

                        } else {
                            $('#current_inc_slave').val('0');

                            var basic_salary = parseInt(basic);
                            var house_rent = basic_salary / 2;

                            $('#current_basic').val(basic_salary);
                            $('#house_rent').val(house_rent);
                            $('#medical').val(empSalary.medical);
                            $('#conveyance').val(empSalary.conveyance);
                            $('#house_maintenance').val(empSalary.house_maintenance);
                            $('#utility').val(empSalary.utility);
                            $('#lfa').val(empSalary.lfa);
                            $('#consolidated_salary').val(empSalary.consolidated_salary);
                            $('#car_allowance').val(empSalary.car_maintenance);

                            calculateGrossTotal();
                        }
                    } else {


                        $('#current_inc_slave').val(basic);
                        //$('#current_basic').val(empSalary.current_basic);
                        $('#house_rent').val(empSalary.house_rent);
                        $('#medical').val(empSalary.medical);
                        $('#conveyance').val(empSalary.conveyance);
                        $('#house_maintenance').val(empSalary.house_maintenance);
                        $('#utility').val(empSalary.utility);
                        $('#lfa').val(empSalary.lfa);
                        $('#car_allowance').val(empSalary.car_maintenance);
                        $('#consolidated_salary').val(empSalary.consolidated_salary);
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

function calculatePromotionSlab(incrementSlave, designation_id) {
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


        $.ajax({
            url: getEmployeeSalarySlaveInfo,
            type: "POST",
            cache: false,
            data: {
                designation_id: $('#promoted_des_id').val(),
                incrementSlave: incrementSlave
            },
            success: function (data) {
                var obj1 = jQuery.parseJSON(data);

                if (data != '') {
                    let obj = jQuery.parseJSON(data);

                    let basic_salary = obj.salaryDetailsData.basic_salary;

                    let house_rent = basic_salary / 2;
                    let medical = obj.salaryDetailsData.medical;
                    let promoted_des_id = $('#promoted_des_id').val();
                    let conveyance = obj.salaryDetailsData.conveyance;
                    let house_maintenance = obj.salaryDetailsData.house_maintenance;
                    let utility = obj.salaryDetailsData.utility;
                    let lfa = obj.salaryDetailsData.lfa;
                    let others = obj.salaryDetailsData.others;
                    let car_allowance = obj.salaryDetailsData.car_allowance;
                    let consolidated_amount = obj.salaryDetailsData.consolidated_amount;

                    $('#current_basic').val(basic_salary);
                    $('#promoted_des_id').val(promoted_des_id);
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


                    //getEmployeeCurrentSalaryPromotion($('#employee_id').val(), 1, promoted_des_id);
                    calculateGrossTotal();

                    $('#current_basic').prop('readonly', true);
                    $('#house_rent').prop('readonly', true);
                    $('#medical').prop('readonly', true);
                    $('#conveyance').prop('readonly', true);
                    $('#house_maintenance').prop('readonly', true);
                    $('#utility').prop('readonly', true);
                    $('#lfa').prop('readonly', true);
                    $('#car_allowance').prop('readonly', true);
                    $('#consolidated_amount').prop('readonly', true);
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

/*
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
	if(current_basic != '')
		gross_total = gross_total + parseFloat(current_basic);
	if(house_rent != '')
		gross_total = gross_total + parseFloat(house_rent);
	if(medical != '')
		gross_total = gross_total + parseFloat(medical);
	if(conveyance != '')
		gross_total = gross_total + parseFloat(conveyance);
	if(house_maintenance != '')
		gross_total = gross_total + parseFloat(house_maintenance);
	if(utility != '')
		gross_total = gross_total + parseFloat(utility);
	if(lfa != '')
		gross_total = gross_total + parseFloat(lfa);
	if(others != '')
		gross_total = gross_total + parseFloat(others);

	$('#gross_total').val(gross_total.toFixed(2));
}*/
