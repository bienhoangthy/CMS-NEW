var inputcontent = "Nhập nội dung dịch";var errorinputvalue="Vui lòng nhập nội dung!";if (configs.lang == "english") {inputcontent = "Enter translation content";var errorinputvalue="Please input content!";}
$('.translation').click(function(){
  var el = $(this);
  var filename = $('#filename').val();
  var lang = $(this).attr('data-lang');
  var content = $(this).attr('data-content');
  var title = 'Việt Nam - VI';
  if (lang == 'english') {title = 'English - EN'}
  swal({
    title: title,
    text: inputcontent,
    type: "input",
    showCancelButton: true,
    closeOnConfirm: true,
    animation: "slide-from-top",
    inputValue: content
  },
  function(inputValue){
    if (inputValue === false) return false;
    if (inputValue === "") {
      swal.showInputError(errorinputvalue);
      return false
    }
    if (inputValue != content) {
      var url = configs.admin_site+configs.controller+'/edit';
      $.ajax({
          type: 'get',
          data: {"lang":lang,"filename":filename,"content":content,"newcontent":inputValue},
          dataType: 'json',
          cache: false,
          url: url,
          success: function(rs) {
            if (rs.status == 1) {
              el.html("<b style='color: #27ae60'>"+inputValue+"</b>");
              el.attr('data-content', inputValue);
              new PNotify({
                title: rs.title,
                text: rs.message,
                type: 'success',
                styling: 'bootstrap3'
              });
            } else {
              new PNotify({
                title: rs.title,
                text: rs.message,
                type: 'error',
                styling: 'bootstrap3'
              });
            }
          }
      });
    }
  });
});