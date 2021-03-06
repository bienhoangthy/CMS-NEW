$('.quickedit').click(function(){
  var id = $(this).attr('data-id');
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
      swal.showInputError(errorinputvalue);
      return false
    }
    var url = configs.admin_site+configs.controller+'/ajaxQuickedit';
    $.ajax({
        type: 'get',
        data: {"name":inputValue,"id":id},
        cache: false,
        url: url,
        success: function(rs) {
            var data = $.parseJSON(rs);
            if (data.status == 1) {
              $("#name"+id).html("<b style='color: #27ae60'>"+inputValue+"</b>");
              $("#alias"+id).html(data.alias);
              swal(success, data.message, "success");
            } else {
              swal(error, data.message, "warning");
            }
        }
    });
  });
});
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