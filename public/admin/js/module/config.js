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
    animation: "slide-from-top"
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