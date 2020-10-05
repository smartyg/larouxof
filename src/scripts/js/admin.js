/*
// https://phppot.com/jquery/jquery-drag-and-drop-image-upload/

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

//var object = '/Page';
//var fields = '[{"name":"id","type":32},{"name":"title","type":81},{"name":"content","type":149}]';
//var fields = {"id":32,"title":81,"content":149};
//var response = '';
/*
var response = {"call":"Page\/loadEditRecords","status":1,"response":[{"id":"0","title":"Welcome","link":"Welcome","content":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."},{"id":"1","title":"Order","link":"Order","content":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."}]};
*/

function loadRecords(obj) {
	if(loading) return;
	else loading = true;
	//toggleLoadingSpinner(true);
	var url = '/Api' + obj + '/loadEditRecords'
	$.get(url, function(data) {
		//alert("loaded");
		if(data['status'] == 0) alert('error');
		var response = data['response'];
		for(field in response)
		{
			printRecord(response[field], page_fields);
		}
		$("article").click(articleClick);
		//toggleLoadingSpinner(false);
		loading = false;
	}, "json");
}

function printRecord(record, fields)
{
	var html = '<article>';
	for(field in record)
	{
		var classes = 'field-' + field + ' input ';
		var tag = '';
		var field_type = fields[field] & 15;
		var field_option = fields[field] & ~15;
		//alert(field_type);
		switch(field_type) {
			case 0:
				tag = 'p';
				classes += 'input-no-edit';
				break;
			case 1:
				tag = 'p';
				classes += 'input-string';
				break;
			case 2:
				tag = 'p';
				classes += 'input-integer';
				break;
			case 3:
				tag = 'p';
				classes += 'input-decimal';
				break;
			case 4:
				tag = 'p';
				classes += 'input-text';
				break;
			case 5:
				tag = 'p';
				classes += 'input-wysiwyg';
				break;
			case 6:
				tag = 'img';
				classes += 'input-image';
				break;
			case 7:
				tag = 'p';
				classes += 'input-date';
				break;
			case 8:
				tag = 'p';
				classes += 'input-bool';
				break;
			case 9:
				tag = 'p';
				classes += 'input-select';
				break;
			case 10:
				tag = 'p';
				classes += 'input-time';
				break;
			case 11:
				tag = 'p';
				classes += 'input-images';
				break;
			default:
		}

		if(hasSet(field_option, 4)) classes += ' required';
		if(hasSet(field_option, 5)) classes += ' nodisplay';
		if(hasSet(field_option, 7)) classes += ' nodisplay extended';

		switch(tag)
		{
			case 'img':
				html += '<img class="' + classes + '" src="' + getImage(record[field]) + '"/>\n';
			case 'p':
			default:
				html += '<p class="' + classes + '">' + record[field] + '</p>\n';
		}
	}
	html += '</article>';
	//document.write(html);
	$('section').append(html);
}

function hasSet(field, bit)
{
	return field & (1 << bit);
}

function makeDropable() {
	$("#drop-area").on('dragenter', function (e){
		e.preventDefault();
		$(this).css('background', '#BBD5B8');
	});

	$("#drop-area").on('dragover', function (e){
		e.preventDefault();
	});

	$("#drop-area").on('drop', function (e){
		$(this).css('background', '#D8F9D3');
		e.preventDefault();
		var image = e.originalEvent.dataTransfer.files;
		createFormData(image);
	});
}

function createFormData(image) {
	var formImage = new FormData();
	formImage.append('userImage', image[0]);
	uploadFormData(formImage);
}

function uploadFormData(formData) {
	$.ajax({
		url: "upload.php",
		type: "POST",
		data: formData,
		contentType:false,
		cache: false,
		processData: false,
		success: function(data){
			$('#drop-area').append(data);
		}});
}

function ConvertToInput(obj, tag, type, extra = '')
{
	var value = obj.text();
	if(obj.hasClass('extended'))
	{
		obj.removeClass('nodisplay');
	}
	var classes = obj.attr('class');
	var classes_array = classes.split(' ');
	var field = '';
	var required = '';

	jQuery.each(classes_array, function(index, item) {
		if(item.substring(0, 6) == 'field-') field = item.substring(6);
				if(item == 'required') required = 'required';
	});

	if(tag == 'input')
		obj.replaceWith('<input type="' + type + '" id="' + field + '" class="' + classes + '" name="' + field + '" value="' + value + '" ' + extra + '/>');
	else if(tag == 'textarea')
		obj.replaceWith('<textarea id="' + field + '" class="' + classes + '" name="' + field + '" ' + extra + '>' + value + '</textarea>');
	/*
	else if(tag == 'images')
		obj.replaceWith('<img type="' + type + '" id="' + field + '" class="' + classes + '" name="' + field + '" value="' + value + '" ' + extra + '/>');*/
}

function ConvertFromInput(obj)
{
	var value = obj.val();
	var classes = obj.attr('class');
	var classes_array = classes.split(' ');
	var type = '';
	var required = '';

	jQuery.each(classes_array, function(index, item) {
		if(item.substring(0, 6) == 'input-') type = item.substring(6);
	});

	if(type == 'image' || type == 'images')
		obj.replaceWith('<input type="' + type + '" id="' + field + '" class="' + classes + '" name="' + field + '" value="' + value + '" ' + extra + '/>');
}

function hashCode(str){
	var hash = 0;
	if (str.length == 0) return hash;
	for (i = 0; i < str.length; i++) {
		char = str.charCodeAt(i);
		hash = ((hash<<5)-hash)+char;
		hash = hash & hash; // Convert to 32bit integer
	}
	return hash;
}

function closeOtherArticle()
{
	var form = $('article.active > form');
	if(submitForm(form) == false) return false;
	form.children(':input').each(function () {

	});
	return true;
}

function submitForm(form)
{
	var data_org = form.data('checksum');
	var data = hashCode(form.children(':input').serialize());
	if(data == data_org) return true;
	return true;
}

function articleClick() {
	if($(this).hasClass("active")) return;
	if(closeOtherArticle() != true) return;
	$(this).addClass("active");
	$(this).children("p").each(function () {
		if ($(this).hasClass("input-no-edit")) ConvertToInput($(this), 'input', 'text', 'readonly');
		if ($(this).hasClass("input-string")) ConvertToInput($(this), 'input', 'text');
		if ($(this).hasClass("input-integer")) ConvertToInput($(this), 'input', 'number', 'min="0" step="1"');
		if ($(this).hasClass("input-decimal")) ConvertToInput($(this), 'input', 'number', 'min="0" step="0.01"');
		if ($(this).hasClass("input-text")) ConvertToInput($(this), 'textarea', '');
		//if ($(this).hasClass("input-wysiwyg")) ConvertToInput($(this), 'text');
		if ($(this).hasClass("input-image")) ConvertToInput($(this), 'input', 'image');
		if ($(this).hasClass("input-date")) ConvertToInput($(this), 'input', 'date');
		if ($(this).hasClass("input-bool")) ConvertToInput($(this), 'input', 'checkbox');
		if ($(this).hasClass("input-select")) ConvertToInput($(this), 'input', 'select');
		if ($(this).hasClass("input-time")) ConvertToInput($(this), 'input', 'time');
		//if ($(this).hasClass("input-images")) ConvertToInput($(this), 'checkbox');
	});

	var inner = '<form>' + $(this).html() + '<input type="button" id="submit" name="submit" value="submit"/><input type="reset" id="reset" name="reset" value="reset"/></form>';
	$(this).html(inner);

	var data = hashCode($('article.active > form > :input').serialize());
	$(this).children('form').data('checksum', data);
}

$(document).ready(function() {
	loadRecords(object);
});
