$(document).ready(function() {
  $('.fancybox-media').fancybox({
    openEffect  : 'none',
    closeEffect : 'none',
    helpers : {
      media : {}
    }
  });
  $(".fancybox-picture").fancybox();
  $('.fancybox-thumbs').fancybox({
		closeBtn  : true,
		arrows    : true,
		nextClick : true,

		helpers : {
			thumbs : {
				width  : 50
			}
		}
	});
});