function loadRecords(obj) {
	if(loading) return;
	else loading = true;
	toggleLoadingSpinner(true);
	var url = '/Api' + obj + '/loadEditRecords'
	$.get(url, function(data) {
		alert("loaded");
		toggleLoadingSpinner(false);
		loading = false;
	}, "json");
}

/*
// add a converting function
var object = '/Page';
var fields = '[{"name":"id","type":32},{"name":"title","type":81},{"name":"content","type":149}]';

response:
{
	"call":"Page\/loadEditRecords",
	"status":1,
	"response":
	[
		{
			"id":"0",
			"title":"Welcome",
			"link":"Welcome",
			"content":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
		},
		{
			"id":"1",
			"title":"Order",
			"link":"Order",
			"content":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
		}
	]
}

<article><p class="field-id hidden">1</p><p class="field-title">title</p><p class="field-integer">1</p><p class="field-content hidden">Long description</p></article>
*/