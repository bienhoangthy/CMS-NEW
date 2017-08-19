window.onload = function () {
  var Cropper = window.Cropper;
  var dataX = document.getElementById('dataX');
  var dataY = document.getElementById('dataY');
  var dataHeight = document.getElementById('dataHeight');
  var dataWidth = document.getElementById('dataWidth');
  var options = {
        aspectRatio: 1 / 1,
        preview: '.img-preview',
        crop: function (e) {
          dataX.value = Math.round(e.detail.x);
          dataY.value = Math.round(e.detail.y);
          dataHeight.value = Math.round(e.detail.height);
          dataWidth.value = Math.round(e.detail.width);
        },
      };
  var cropper = new Cropper(image, options);

  // Import image
  var inputImage = document.getElementById('inputImage');
  var URL = window.URL || window.webkitURL;
  var blobURL;
  if (URL) {
    inputImage.onchange = function () {
      var files = this.files;
      //var file;

      if (cropper && files && files.length) {
        file = files[0];

        if (/^image\/\w+/.test(file.type)) {
          blobURL = URL.createObjectURL(file);
          cropper.reset().replace(blobURL);
          inputImage.value = null;
        } else {
          window.alert('Please choose an image file.');
        }
      }
    };
  } else {
    inputImage.disabled = true;
    inputImage.parentNode.className += ' disabled';
  }

  document.getElementById('send-server').addEventListener('click', function(){
    //var token_name = document.getElementById('token').getAttribute('name');
    var token = document.getElementById('token').value;
  	var id = document.getElementById('id-user').value;
    var imageData = cropper.getCroppedCanvas();
    var dataURL = imageData.toDataURL();
    var url = configs.admin_site+'user/ajaxChangeAvatar/'+id;
    $.ajax({
        type: 'post',
        data: {'csrf_admin_thy':token,'dataURL':dataURL},
        url: url,
        success: function(rs) {
          if (rs == 1) {
            swal({
              title: complete,
              text: done+update+avatar+success,
              type: "success",
              confirmButtonColor: "#5cb85c",
              confirmButtonText: "OK",
              closeOnConfirm: false
            },
            function(isConfirm){
              if (isConfirm) {
                location.reload();
              } else {
                location.reload();
              }
            });
          } else {
            swal({
              title: notcomplete,
              text: retry,
              type: "warning",
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "OK",
              closeOnConfirm: false
            },
            function(isConfirm){
              if (isConfirm) {
                location.reload();
              } else {
                location.reload();
              }
            });
          }
        }
    });
  });

};