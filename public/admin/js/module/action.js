function changename(id){
    swal({
    title: title,
    text: inputname,
    type: "input",
    showCancelButton: true,
    closeOnConfirm: false,
    animation: "slide-from-top"
  },
  function(inputValue){
    if (inputValue === false) return false;
    if (inputValue === "") {
      swal.showInputError(errorinput);
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
              swal(success, edited + inputValue, "success");
            } else {
              swal(error, notedit, "warning");
            }
        }
    });
  });
}