var title = "Cập nhật mô tả";
var inputname = "Nhập mô tả mới";
var errorinput = "Vui lòng nhập mô tả mới";
if (configs.lang == "english") {
  var title = "Update description";
  var inputname = "Input new description";
  var errorinput = "Please input new description";
}

function editDescription(id){
    swal({
    title: title,
    text: inputname,
    type: "input",
    showCancelButton: true,
    closeOnConfirm: true,
    animation: "slide-from-top",
    inputValue: $("#name"+id).text()
  },
  function(inputValue){
    if (inputValue === false) return false;
    if (inputValue === "") {
      swal.showInputError(errorinput);
      return false
    }
    var url = configs.admin_site+configs.controller+'/editDescription';
    $.ajax({
        type: 'get',
        data: {"description":inputValue,"id":id},
        cache: false,
        url: url,
        success: function(rs) {
            if (rs == 1) {
              new PNotify({
                title: complete,
                text: done+title+success,
                type: 'success',
                styling: 'bootstrap3'
              });
              $("#name"+id).html("<b style='color: #27ae60'>"+inputValue+"</b>");
            } else {
              new PNotify({
                title: notcomplete,
                text: retry,
                type: 'error',
                styling: 'bootstrap3'
              });
            }
        }
    });
  });
}
function deletePhoto(id)
{
  swal({
    title: confirm,
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes!",
    closeOnConfirm: true
  },
  function(){
    var url = configs.admin_site+configs.controller+'/deleteImageDetail';
    $.ajax({
      url: url,
      data: {"id":id},
      cache: false,
      success: function(rs) {
        if (rs == 1) {
          var e = $('#photo'+id);
          if (e) {e.remove();}
          new PNotify({
            title: complete,
            text: done+delimage+success,
            type: 'success',
            styling: 'bootstrap3'
          });
        } else {
          new PNotify({
            title: notcomplete,
            text: retry,
            type: 'error',
            styling: 'bootstrap3'
          });
        }
      }
    });
  });
}