var base_url = $("#base_url").val();

function ajax_form(dom, url){
	var deferred = $.Deferred();
	$.ajax({
		url: base_url + url,
		type: "POST",
		data: new FormData(dom),
		contentType: false,
		processData:false,
		success:function(res){
			deferred.resolve(res);
		}
	});
	
	return deferred.promise();
}

function ajax_simple(data, url){
	var deferred = $.Deferred();
	$.ajax({
		url: base_url + url,
		type: "POST",
		data: data,
		success:function(res){
			deferred.resolve(res);
		}
	});
	
	return deferred.promise();
}

$(".btn_delete_sender").on('click',(function(e) {
	if (!confirm("Are you sure you want to delete sender?")) event.preventDefault();
}));

$(".btn_delete_content").on('click',(function(e) {
	if (!confirm("Are you sure you want to delete content record?")) event.preventDefault();
}));

