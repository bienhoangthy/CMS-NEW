$('.show-extra').click(function(){
	var id = $(this).attr('data-id');
	var extra = $('#extra-'+id);
	var status = extra.css('display');
	if (status == 'none') {extra.show();} else {extra.hide();}
});
function closeExtra(id)
{
	var extra = $('#extra-'+id);
	if (extra) {extra.hide();}
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
	            	var html_title = '<a href="'+configs.base_url+rs.news_alias+'-post'+id+'.html" target="_blank">'+rs.news_title+'</a>  <i class="fa fa-check fa-lg text-success"</i>';
	            	var text_view = rs.news_view;
	            	//Thêm html vào chổ này
	            	var html_status = '';
	            	$('#title'+id).html(html_title);
	            	$('#view'+id).text(text_view);
	            	$('#status'+id).html(html_status);
	            	var title = "Sửa nhanh thành công";
	            	if (configs.lang == "english") {var title = "Quick edit success";}
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