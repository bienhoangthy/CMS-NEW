function confirm_delete(id){
    var title = "Bạn muốn xóa "+configs.controller+" này!";
    if (configs.lang == 'english') {title = "Do you want delete this "+configs.controller+"!"};
    swal({
      title: title,
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes!"
    },
    function(){
      window.location.href = configs.admin_site+configs.controller+"/delete/"+id;
    });
}

function confirm_delete_all(){
  var title = "Bạn muốn xóa tất cả!";
  if (configs.lang == 'english') {title = "Do you want delete all!"};
  if(confirm(title))
        return true;
    return false;
}

function alertChange($language='vietnamese'){
  var title = "Lưu ý!";
  var text = "Thay đổi trường này sẽ chuyển tất cả nội dung bạn đang chỉnh sửa về ngôn ngữ bạn đang chọn!";
  if (configs.lang == 'english') {title = "Note!";text = "Changing this field will move all the content you are editing to the language you are currently selecting!";}
  swal(title, text);
}