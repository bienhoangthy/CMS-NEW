$(document).ready(function(){
  $('.loadmore').click(function() {
    var load = $(this).attr('data-load');
    var page = $('#page').val();
   	var url = configs.admin_site+configs.controller+'/ajaxActivity';
   	$.ajax({
   		dataType: 'json',
   		data: {'load':load,'page':page},
   		cache: false,
   		url: url,
   		success: function(rs){
   			var table = $('#table-activity');
   			table.empty();
   			table.html(rs.html);
   			$('#page').val(rs.page);
   			$('.page-html').html(rs.page);
   			if (rs.page > 1) {$('.previous').show('slow');} else {$('.previous').hide('slow');}
        if (rs.html == '') {$('.next').hide('slow');} else {$('.next').show('slow');}
   		}
   	});
  });
});