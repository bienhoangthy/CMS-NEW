$('#mailimp').on('click', '.mailimportant', function(){
	var id = $(this).attr('data-id');
	var imp = $(this).attr('data-imp');
	var url = configs.admin_site+configs.controller+'/ajaxMailimportant';
	$.ajax({
		type: 'get',
		data: {"id":id,"imp":imp},
		dataType: "json",
		cache: false,
		url: url,
		success: function(rs) {
			if (rs.success == 1) {
				var star = $('#star');
				var star_id = $('#star'+id);
				$('.mailimportant').tooltip('hide');
				if (imp == 1) {
					var btn_new = '<a href="javascript:;" class="mailimportant" data-id="'+id+'" data-imp="0" data-placement="top" data-toggle="tooltip" data-original-title="'+rs.html+'"><button class="btn btn-sm btn-default" type="button"><i class="fa fa-star-o"></i></button></a>';
					var star_html = '<i class="fa fa-star text-warning" data-toggle="tooltip" data-placement="top" title="'+rs.mailimportant+'"></i>'; 
					star.html(star_html);
					if (star_id) {star_id.html(star_html);}
					var text = grant;
				} else {
					var btn_new = '<a href="javascript:;" class="mailimportant" data-id="'+id+'" data-imp="1" data-placement="top" data-toggle="tooltip" data-original-title="'+rs.html+'"><button class="btn btn-sm btn-default" type="button"><i class="fa fa-star"></i></button></a>';
					star.html('');
					if (star_id) {star_id.html('');}
					var text = cancel;
				}
				$('#mailimp').html(btn_new);
				$('.mailimportant').tooltip('show');
				new PNotify({
					title: complete,
					text: done+text+' '+rs.mailimportant+' #'+id,
					type: 'success',
					styling: 'bootstrap3'
				});
			} else {
				new PNotify({
					title: notcomplete,
					text: rs.html,
					type: 'error',
					styling: 'bootstrap3'
				});
			}
		}
	});
});

$('.delete-mail').click(function(){
	var id = $(this).attr('data-id');
	swal({
		title: confirm,
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Yes!",
		closeOnConfirm: true
	},
	function(){
		var url = configs.admin_site+configs.controller+'/ajaxDeletemail';
		$.ajax({
			type: 'get',
			data: {"id":id},
			dataType: "json",
			cache: false,
			url: url,
			success: function(rs) {
				if (rs.success == 1) {
					var mail_id = $('#mail'+id);
					if (mail_id) {mail_id.remove()}
					$('.inbox-body').html('');
					new PNotify({
						title: complete,
						text: rs.html+' #'+id,
						type: 'success',
						styling: 'bootstrap3'
					});
				} else {
					new PNotify({
						title: notcomplete,
						text: rs.html,
						type: 'error',
						styling: 'bootstrap3'
					});
				}
			}
		});
	});
});