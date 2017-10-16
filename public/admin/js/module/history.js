$(document).ready(function(){
  $('.clear-all').click(function() {
    var title = "Bạn muốn xóa sạch lịch sử đăng nhập!";
    if (configs.lang == 'english') {title = "Do you want clear all login history!"};
    swal({
      title: title,
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes!"
    },
    function(){
      window.location.href = configs.admin_site+configs.controller+"/clearall";
    });
  });
});