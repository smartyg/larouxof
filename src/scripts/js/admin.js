function loadRecords(obj) {
	if(loading) return;
	else loading = true;
	toggleLoadingSpinner(true);
	//alert("loadItems(" + start + ", " + sort + ", " + order + ")");
	//return;
	//var url = "/api/" + page_type + "/" + page_link + "/loadItems/" + start + '/' + num_items_per_load + '/' + sort + '/' + order;
	var url = '/Api' + obj + '/loadEditRecords'
	$.get(url, function(data) {
		alert("loaded");
		toggleLoadingSpinner(false);
		loading = false;
	}, "json");
}
