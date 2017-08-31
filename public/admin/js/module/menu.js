$('.dd').nestable({maxDepth:2});
$('.dd').on('change', function() {
    var rs = $('.dd').nestable('serialize');
    console.log(rs);
});
$('.show-extra').click(function(){
	var id = $(this).parent().attr('data-id');
	var extra = $('#extra-'+id);
	var status = extra.css('display');
	if (status == 'none') {extra.show();} else {extra.hide();}
});