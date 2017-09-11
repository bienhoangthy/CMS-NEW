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