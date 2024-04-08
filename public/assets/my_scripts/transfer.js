
function showClusterBrancheArea() {
	var designation_name = $('#functional_designation').find("option:selected").text();

	if(designation_name == 'Cluster Head') {
		$('#clusterBranchesArea').removeClass('hidden');
	} else {
		$('#clusterBranchesArea').addClass('hidden');		
	}
}