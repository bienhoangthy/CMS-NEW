function readURL(input,name) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#show'+name).attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
$("#uploadlogo").change(function(){
    readURL(this,'logo');
});

$("#uploadfavicon").change(function(){
    readURL(this,'favicon');
});

function quickedit(id,name){
	swal({
    title: title,
    text: name+' - '+inputvalue,
    type: "input",
    showCancelButton: true,
    closeOnConfirm: false,
    animation: "slide-from-top",
    inputValue: $("#value"+id).text()
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
        data: {"value":inputValue,"id":id},
        cache: false,
        url: url,
        success: function(rs) {
            if (rs == "ok") {
              $("#value"+id).html("<b style='color: #27ae60'>"+inputValue+"</b>");
              swal(success, edited + name, "success");
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