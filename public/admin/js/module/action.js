function changename(id){
    swal({
    title: 'Cập nhật nhanh',
    text: "Nhập tên bạn muốn đổi",
    type: "input",
    showCancelButton: true,
    closeOnConfirm: false,
    animation: "slide-from-top",
    inputPlaceholder: "Write something"
  },
  function(inputValue){
    if (inputValue === false) return false;
    if (inputValue === "") {
      swal.showInputError("Bạn phải nhập tên quyền muốn đổi!");
      return false
    }
    var url = configs.admin_site+configs.controller+'/ajaxChangename';
    $.ajax({
        type: 'get',
        data: {"name":inputValue,"id":id},
        cache: false,
        url: url,
        success: function(rs) {
            if (rs == "ok") {
              $("#name"+id).html("<b style='color: #27ae60'>"+inputValue+"</b>");
              swal("Thành công!", "Đã cập nhật: " + inputValue, "success");
            } else {
              swal("Lỗi!", "Không thể cập nhật", "warning");
            }
        }
    });
  });
}