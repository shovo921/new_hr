
/*
$(document).ready(function getDistrictList(division_id) {

});
*/


function getDistrictList(division_id) {
	//alert("Page is loaded");
		$.ajax({
			url: getDistricts,
			type: "GET",
			//dataType : "json",
			cache: false,
			data: {
				division_id: division_id
			},
			timeout: 3000,
			success: function (data) {
				// $("#district_id").html(data);
				$('#district_id').empty().append(data);
			},
			error: function () {
			}
		});
}

/*jQuery(document).ready(function() {
	jQuery('#division_id').trigger('change');
});*/


//$('#division_id').change();
