$('.change-check').click(function(){
	var id = $(this).attr('id');
	var status = $(this).is(":checked");
	if (status == false) {
		var masterStatus = $(this).prop('checked');
        $('input.subcheck'+id).each(function(index){
            var switchStatus = $('input.subcheck'+id)[index].checked;
            if(switchStatus != masterStatus){
                 $(this).trigger('click');
            }
        });
	}
});

$('.subchange').click(function(){
	if ($(this).prop('checked')) {
		var id_parent = $(this).attr('data-parent');
	   	if(!$('input#'+id_parent).prop('checked')){
	       	$('input#'+id_parent).trigger('click');
	   	}
	}
});