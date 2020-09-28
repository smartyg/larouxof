var items_loaded = 0;
var num_items_per_load = 10;
var loading = false;

function gridView() {
	$("section").addClass("view-grid");
	$("section").removeClass("view-list");
	$(".view-switch .grid-view").addClass("nodisplay");
	$(".view-switch .list-view").removeClass("nodisplay");
}

function listView() {
	$("section").removeClass("view-grid");
	$("section").addClass("view-list");
	$(".view-switch .grid-view").removeClass("nodisplay");
	$(".view-switch .list-view").addClass("nodisplay");
}

function isListView() {
	return $("section").hasClass("view-list");
}

function isGridView() {
	return $("section").hasClass("view-grid");
}

function getSort() {
	return $("select#sort").children("option:selected").val();
}

function toggleLoadingSpinner(active) {

}

function setOrder(order)
{
	if(order == 'DESC') {
		$(".sorting .arrow-up").removeClass("active");
		$(".sorting .arrow-down").addClass("active");
	}
	else {
		$(".sorting .arrow-up").addClass("active");
		$(".sorting .arrow-down").removeClass("active");
	}
}

function getOrder()
{
	if($(".sorting .arrow-up").hasClass("active")) return 'ASC';
	else if($(".sorting .arrow-down").hasClass("active")) return 'DESC';
	else {
		setOrder('ASC');
		return 'ASC';
	}
}

$(document).ready(function(){
	$(".view-switch").click(function(ev){
		if(isGridView()) listView();
		else gridView();
	});

	$(".sorting .arrow-up").click(function(ev){
		setOrder('ASC');
		loadItems(0, getSort(), 'ASC');
	});

	$(".sorting .arrow-down").click(function(ev){
		setOrder('DESC');
		loadItems(0, getSort(), 'DESC');
	});

	$("select#sort").change(function(){
		//alert("The text has been changed.");
		loadItems(0, getSort(), getOrder());
	});

	$(window).scroll(function() {
		if($(window).scrollTop() >= ($("#load-more").offset().top - $(window).height())) {
			loadItems(items_loaded, getSort(), getOrder());
		}
	});
});

function loadItems(start, sort, order) {
	if(loading) return;
	else loading = true;
	toggleLoadingSpinner(true);
	//alert("loadItems(" + start + ", " + sort + ", " + order + ")");
	return;
	var url = "/api/" + page_type + "/" + page_link + "/loadItems/" + start + '/' + num_items_per_load + '/' + sort + '/' + order;
	$.get(url, function(data) {
		alert("loaded");
		toggleLoadingSpinner(false);
		loading = false;
	}, "json");
}
