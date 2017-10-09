$(document).ready(function(){
	$('#sc_component').change(function(){
		var component = $(this).val();
		var url = configs.admin_site+'category/ajaxGetCategory';
		$.ajax({
			type: 'get',
			data: {'component':component},
			cache: false,
			url: url,
			success: function(rs){
				$("#sc_category").empty();
                $("#sc_category").append(rs);
			}
		});
	});
});