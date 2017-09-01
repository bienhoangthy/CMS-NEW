$('.dd').nestable({maxDepth:2});
$('.dd').on('change', function() {
    var rs = $('.dd').nestable('serialize');
    $("#nestable-output").val(JSON.stringify(rs));
});

function showExtra(id){
	var extra = $('#extra-'+id);
	var status = extra.css('display');
	if (status == 'none') {extra.show();} else {extra.hide();}
}
function removeNes(id){
	var nes = $('#nes-'+id);
	if (nes) {nes.remove();}
}
$('.add-menu').click(function(){
	var allowclick = 'Cho phép click';
	var remove = 'Xóa';
	if (configs.lang == 'english') {allowclick = 'Allow click';remove = 'Remove';}
	var menu_id = $('#formMenu').attr('data-id');
	var id = $(this).attr('data-id');
	var name = $(this).attr('data-name');
	var id_ingredient = $(this).attr('data-ingredient-id');
	var ingredient = $(this).attr('data-ingredient-name');
	var url = configs.admin_site+configs.controller+'/ajaxAddtoMenu';
	$.ajax({
		url: url,
		data: {"menu_id":menu_id,"ingredient":id_ingredient,"ingredient_id":id},
		cache: false,
		success: function(rs) {
			if (rs > 0) {
				swal(success, added+ingredient+' '+name, "success");
				var html = '<li class="dd-item dd3-item" id="nes-'+id+'" data-id="'+id+'"><div class="dd-handle dd3-handle">Drag</div><div class="dd3-content" onclick="showExtra(\''+id+'\')"><span class="pull-left"> '+name+'</span><cite class="pull-right"> '+ingredient+'</cite></div><div class="item-content" id="extra-'+id+'"><label>'+allowclick+' <input type="checkbox" class="flat" checked="checked"></label><label><span>Icon</span><input class="form-control" name="icon" type="text"></label><label><span>Target</span><select class="form-control"><option value="_self">_self</option><option value="_blank">_blank</option><option value="_parent">_parent</option><option value="_top">_top</option></select></label><button type="button" onclick="removeNes(\''+id+'\')" class="btn btn-danger">'+remove+'</button></div></li>';
				$('#nestable-content').append(html);
			} else {
				swal(error, nonpermission, "warning");
			}
		}
	});
});