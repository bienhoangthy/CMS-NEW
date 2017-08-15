$('.change-check').click(function(){
	var group_id = $(this).attr('group-id');
	var action_value = $(this).attr('action-value');
	var name = $(this).attr('name');
	var status = $(this).is(":checked");
	if (status == true) {var url = configs.admin_site+'permission/ajaxEnablePer';var type = grant;} else {var url = configs.admin_site+'permission/ajaxDisabalePer';var type = cancel;}
	$.ajax({
        type: 'get',
        data: {"group_id":group_id,"action_value":action_value},
        cache: false,
        url: url,
        success: function(rs) {
            if (rs == "ok") {
            	new PNotify({
	              title: type+success,
	              text: done+type+role+name+group+group_id,
	              type: 'success',
	              styling: 'bootstrap3'
	            });
            } else {
            	new PNotify({
	              title: type+unsuccessful,
	              text: error+type+role+name+group+group_id,
	              type: 'error',
	              styling: 'bootstrap3'
	            });
            }
        }
    });
});