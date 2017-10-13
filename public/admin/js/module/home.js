$(document).ready(function(){
  $('.loadmore').click(function() {
    var load = $(this).attr('data-load');
    var page = $('#page').val();
    alert(page);
  });
});