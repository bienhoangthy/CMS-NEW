$('.show-extra').click(function(){
	var id = $(this).attr('data-id');
	var extra = $('#extra-'+id);
	var status = extra.css('display');
	if (status == 'none') {extra.show('slow');} else {extra.hide();}
});
function closeExtra(id)
{
	var extra = $('#extra-'+id);
	if (extra) {extra.hide('slow');}
}

function saveQuick(id)
{
	if (id) {
		var lang = $('#lang').val();
		var title = $('#news_title'+id).val();
		var alias = $('#news_alias'+id).val();
		var view = $('#news_view'+id).val();
		var orderby = $('#news_orderby'+id).val();
		var status = $('#news_status'+id).prop("checked");
		status = status == true ? 1 : 2;
		var hot = $('#news_hot'+id).prop("checked");
		hot = hot == true ? 1 : 0;
		var url = configs.admin_site+configs.controller+'/ajaxQuickedit';
	    $.ajax({
	        data: {"lang":lang,"id":id,"title":title,"alias":alias,"view":view,"orderby":orderby,"status":status,"hot":hot},
	        dataType: "json",
	        cache: false,
	        url: url,
	        success: function(rs) {
	            if (rs.success) {
	            	var title = "Sửa nhanh thành công";
	            	var hotnews = "Nổi bật";
	            	if (configs.lang == "english") {var title = "Quick edit success";hotnews = "Hot News";}
	            	var text_view = rs.news_view;
	            	var html_status = '<span class="label label-'+rs.color+'">'+rs.name+'</span><br>';
	            	if (hot == 1) {html_status += '<span class="label label-danger" data-toggle="tooltip" data-placement="top" title="'+hotnews+'">Hot</span>';}
	            	$('#title'+id).html(rs.news_title+' <i class="fa fa-check fa-lg text-success"</i>');
	            	$('#title'+id).prop("href", configs.base_url+rs.news_alias+'-post'+id+'.html');
	            	$('#view'+id).text(text_view);
	            	$('#status'+id).html(html_status);
	            	closeExtra(id)
	            	new PNotify({
				      title: title,
				      text: rs.success,
				      type: 'success',
				      styling: 'bootstrap3'
				    });
	            } else {
	            	var title = "Không thành công!";
	            	if (configs.lang == "english") {var title = "Unsuccessful!";}
	            	new PNotify({
				      title: title,
				      text: rs.error,
				      type: 'error',
				      styling: 'bootstrap3'
				    });
	            }
	        }
	    });
	}
}