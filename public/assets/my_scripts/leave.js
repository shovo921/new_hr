function calculateTotalDays() {

	var start_date = $('#start_date').val();
	var end_date = $('#end_date').val();
	//console.log('start_date,end_date',start_date,end_date);
	var count = 0;



	if(start_date === '') {
		$('#start_date').css('border', '1px solid #f00');
		count = 1;
	} else {
		$('#start_date').css('border', '1px solid #ccc');
	}
	if(end_date === '') {
		$('#end_date').css('border', '1px solid #f00');
		count = 1;
	} else {
		$('#end_date').css('border', '1px solid #ccc');
	}

	if(count === 0) {
		$.ajax({
			url : getLeaveTotalDays,
			type : "GET",
			cache : false,
			data: {
				start_date: start_date,
				end_date: end_date
			},

			success : function(data) {
				if(data.status === 'success') {
					$('#total_days').val(data.total_days);
					$('#next_joining_date').val(data.next_joining);
				} else {
					$('#end_date').val('');
					$('#total_days').val('');
					$('#next_joining_date').val('');
					alert('Please check your entered leave dates.');
				}
			}
		});
	} else {
		return '';
	}
}
function calculateTotalDays1() {

	var start_date = $('#start_date1').val();
	var end_date = $('#end_date1').val();
	console.log('start_date,end_date',start_date,end_date);
	var count = 0;



	if(start_date === '') {
		$('#start_date1').css('border', '1px solid #f00');
		count = 1;
	} else {
		$('#start_date1').css('border', '1px solid #ccc');
	}
	if(end_date === '') {
		$('#end_date1').css('border', '1px solid #f00');
		count = 1;
	} else {
		$('#end_date1').css('border', '1px solid #ccc');
	}

	if(count === 0) {
		$.ajax({
			url : getLeaveTotalDays,
			type : "GET",
			cache : false,
			data: {
				start_date: start_date,
				end_date: end_date
			},

			success : function(data) {
				if(data.status === 'success') {
					$('#total_days').val(data.total_days);
					$('#next_joining_date').val(data.next_joining);
				} else {
					$('#end_date1').val('');
					$('#total_days').val('');
					$('#next_joining_date').val('');
					alert('Please check your entered leave dates.');
				}
			}
		});
	} else {
		return '';
	}
}
function checkLeaveConditions(leave_type_id) {
	//console.log(leave_type_id);
	var total_days = $('#TOTAL_DAYS').val();

	// alert(total_days);

	$.ajax({
		url : base_url + '/checkEmployeeLeaveConditions',
		type : "GET",
		cache : false,
		data: {
			leave_type_id: leave_type_id,
			total_days: total_days
		},
		success : function(data) {
			if(data.status == 'success') {
				if(data.total_days_status == 'exceeds'){
					alert(data.message);

					$('#TOTAL_DAYS').val('');
					$('#LEAVE_TYPE_ID').val('');

					$('#current_balance').val('');
					$('#remaining_balance').val('');
				} else {
					$('#current_balance').val(data.current_balance);
					$('#remaining_balance').val(data.remaining_balance);
				}
			} else {
				alert(data.message);
				$('#TOTAL_DAYS').val('');
				$('#LEAVE_TYPE_ID').val('');
				$('#current_balance').val('');
				$('#remaining_balance').val('');
			}
		}
	});
}

function checkLeaveBalance(leave_type_id) {
	//console.log(leave_type_id);
	var total_days = $('#TOTAL_DAYS').val();

	// alert(total_days);

	$.ajax({
		url : base_url + '/checkLeaveBalance',
		type : "GET",
		cache : false,
		data: {
			leave_type_id: leave_type_id,
			total_days: total_days
		},
		success : function(data) {
			if(data.status === 'success') {
				if(data.total_days_status === 'exceeds'){
					$('#TOTAL_DAYS').val('');
					$('#LEAVE_TYPE_ID').val('');

					$('#current_balance').val('');
					$('#leave_taken').val('');
				} else {
					$('#current_balance').val(data.current_balance);
					$('#leave_taken').val(data.leave_taken);
					$('#future_apply').val(data.future_apply);

					if (data.future_apply == 1) {
						$('#future').show();
						$('#future1').hide();
						$('#start_date1').val('');
						$('#end_date1').val('');

					} else {
						$('#future1').show();
						$('#future').hide();
						$('#start_date').val('');
						$('#end_date').val('');
					}



				}
			} else {
				$('#TOTAL_DAYS').val('');
				$('#LEAVE_TYPE_ID').val('');
				$('#current_balance').val('');
				$('#leave_taken').val('');
			}
		}
	});
}

/*$(function () {
	checkLeaveBalance(); //this calls it on load
	$("#leave_type_id").change(checkLeaveBalance);
});*/


$("#leave_location" ).change(function(){
	if(this.value === '2'){
		$('#passport_no').removeClass( "hide" ).addClass('required');
		$('#country_name').removeClass( "hide" ).addClass('required');
		//$('#passport_no_hide').addClass( "hide" );
	}else if(this.value === '1'){
		$('#passport_no').val('').addClass( "hide" );
		$('#country_name').val('').addClass( "hide" );
		//$('#passport_no_hide').removeClass( "hide" );
	}
	else{
		$('#passport_no').removeClass( "show" ).addClass("hide");
		$('#country_name').removeClass( "show" ).addClass("hide");
		//$('#passport_no_hide').removeClass( "show" ).addClass("hide");
	}
}).change();



