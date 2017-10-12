$(document).ready(function(){
	if (configs.lang == 'vietnamese') {
		var by = 'bởi ';
		var delete_ = 'Xóa';
		var approval = 'Duyệt';
		var success = 'Thành công';
		var unsuccess = 'Không thành công';
		var confirm = 'Bạn muốn xóa bình luận này?';
	} else {
		var by = 'by ';
		var delete_ = 'Delete';
		var approval = 'Approval';
		var success = 'Success';
		var unsuccess = 'Unsuccessful';
		var confirm = 'Are you sure delete this comment?';
	}

	$('.actionhover').on('click', '.operation', function(){
		var id = $(this).parent().attr('data-id');
		var operation = $(this).attr('data-operation');
		if (id && operation) {
			var url = configs.admin_site+configs.controller+'/ajaxOperation';
			$.ajax({
				type: 'get',
				dataType: 'json',
				data: {'id':id,'operation':operation},
				cache: false,
				url: url,
				success: function(rs){
					if (rs.status == 1) {
						if (operation == 1) {
							var html_operation = '<a href="javascript:;" data-operation="3" class="text-warning operation">Spam</a>';
						} else {
							var html_operation = '<a href="javascript:;" data-operation="1" class="text-success operation">'+approval+'</a>';
						}
						html_operation += ' | <a href="javascript:;" class="text-danger delete">'+delete_+'</a>';
						$('#operation'+id).html(html_operation);
						var html_status = '<span class="label label-'+rs.color+'">'+rs.name+'</span><br>'+by+' '+rs.user_fullname;
						$('#status'+id).html(html_status);
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

	$('.actionhover').on('click', '.delete', function(){
		var id = $(this).parent().attr('data-id');
		swal({
			title: confirm,
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes!",
			closeOnConfirm: true
		},
		function(){
			var url = configs.admin_site+configs.controller+'/ajaxDelete';
			$.ajax({
				type: 'get',
				dataType: 'json',
				url: url,
				data: {"id":id},
				cache: false,
				success: function(rs) {
					if (rs.status == 1) {
						$('#comment'+id).remove();
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
		});
	});
});