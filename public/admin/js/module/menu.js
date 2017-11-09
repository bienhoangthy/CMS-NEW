$('.dd').nestable({maxDepth:3});
$('.dd').on('change', function() {
	event.preventDefault();
    var rs = $('.dd').nestable('serialize');
    $("#nestable-output").val(JSON.stringify(rs));
});

function showExtra(id){
	var extra = $('#extra-'+id);
	var status = extra.css('display');
	if (status == 'none') {extra.show('slow');} else {extra.hide('slow');}
}
function removeNes(id){
	swal({
      	title: confirm_delete,
      	type: "warning",
      	showCancelButton: true,
      	confirmButtonColor: "#DD6B55",
      	confirmButtonText: "Yes!"
    },
    function(){
    	var url = configs.admin_site+configs.controller+'/ajaxDeleteMenu';
    	$.ajax({
    		url: url,
    		data:{"id":id},
    		cache: false,
    		success: function(rs) {
    			if (rs > 0) {
    				var nes = $('#nes-'+id);
    				if (nes) {nes.remove();}
    				new PNotify({
		              title: success,
		              text: deleted+'#'+id,
		              type: 'success',
		              styling: 'bootstrap3'
		            });
    			} else {
    				new PNotify({
		              title: error,
		              text: nonpermission,
		              type: 'error',
		              styling: 'bootstrap3'
		            });
    			}
    		}
    	});
    });
}
$('.add-menu').click(function(){
	var allow = 'Cho phép';
	var disallowance = 'Không cho phép';
	var remove = 'Xóa';
	if (configs.lang == 'english') {allow = 'Allow';disallowance = 'Disallowance';remove = 'Remove';}
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
				//swal(success, added+ingredient+' '+name, "success");
				new PNotify({title: success,text: added+ingredient+' '+name,type: 'success',styling: 'bootstrap3'});
				var html = '<li class="dd-item dd3-item" id="nes-'+rs+'" data-id="'+rs+'"><div class="dd-handle dd3-handle">Drag</div><div class="dd3-content" onclick="showExtra(\''+rs+'\')"><span class="pull-left"> '+name+'</span><cite class="pull-right"> '+ingredient+'</cite></div><div class="item-content" id="extra-'+rs+'"><label><span>Click</span><select class="form-control" name="allow'+rs+'"><option value="1" selected>'+allow+'</option><option value="0">'+disallowance+'</option></select></label><label><span>Icon</span><input class="form-control" name="icon'+rs+'" type="text"></label><label><span>Target</span><select class="form-control" name="target'+rs+'"><option value="_self">_self</option><option value="_blank">_blank</option><option value="_parent">_parent</option><option value="_top">_top</option></select></label><button type="button" onclick="removeNes(\''+rs+'\')" class="btn btn-danger">'+remove+'</button></div></li>';
				$('#nestable-content').append(html);
			} else {
				//if (rs==0) {swal(error, exists, "warning");} else {swal(error, nonpermission, "warning");}
				if (rs==0) {new PNotify({title: error,text: exists,type: 'error',styling: 'bootstrap3'});} else {new PNotify({title: error,text: nonpermission,type: 'error',styling: 'bootstrap3'});}
			}
		}
	});
});