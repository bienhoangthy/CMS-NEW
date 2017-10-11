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

	if (configs.lang == 'vietnamese') {
		var deleteall = 'Bạn muốn xóa tất cả?';
		var success = 'Thành công';
		var unsuccess = 'Không thành công';
	} else {
		var deleteall = 'Are you sure delete all?';
		var success = 'Success';
		var unsuccess = 'Unsuccessful';
	}

	var id = $('#listItem').attr('data-id');

	$('.delete-all-item').click(function() {
	    swal({
	      title: deleteall,
	      type: "warning",
	      showCancelButton: true,
	      confirmButtonColor: "#DD6B55",
	      confirmButtonText: "Yes!"
	    },
	    function(){
	      window.location.href = configs.admin_site+configs.controller+"/deleteAllItem/"+id;
	    });
	});

	$('.delete-item').click(function() {
		var id_item = $(this).attr('data-id-item');
		if (id && id_item) {
			var url = configs.admin_site+configs.controller+'/deleteItem';
			$.ajax({
				type: 'get',
				dataType: 'json',
				data: {'id':id,'id_item':id_item},
				cache: false,
				url: url,
				success: function(rs){
					if (rs.status == 1) {
						var count = $('.count').text(rs.total);
						var item = $('#item'+id_item);
						if (item) {item.remove();}
						new PNotify({
							title: success,
							text: rs.message,
							type: 'success',
							styling: 'bootstrap3'
						});
					} else {
						new PNotify({
							title: unsuccess,
							text: rs.message,
							type: 'error',
							styling: 'bootstrap3'
						});
					}
				}
			});
		}
	});
});