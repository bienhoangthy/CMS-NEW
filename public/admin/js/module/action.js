function changename(id){
    swal({
    title: title,
    text: inputname,
    type: "input",
    showCancelButton: true,
    closeOnConfirm: false,
    animation: "slide-from-top",
    inputValue: $("#name"+id).text()
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
$('.delete').click(function(){
  var id = $(this).attr('data-id');
  var name = $(this).attr('data-name');
  var title = "Bạn muốn xóa "+name+" này!";
    if (configs.lang == 'english') {title = "Do you want delete this "+name+"!"};
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
});