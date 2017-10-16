$(document).ready(function(){
  $('.clear-all').click(function() {
    var title = "Bạn muốn xóa sạch lịch sử hoạt động!";
    if (configs.lang == 'english') {title = "Do you want clear all activity history!"};
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