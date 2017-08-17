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
    var token = document.getElementById('token').value;
  	var id = document.getElementById('id-user').value;
    var imageData = cropper.getCroppedCanvas();
    var dataURL = imageData.toDataURL();
    //console.log(dataURL);
    //cropper.getCroppedCanvas().toBlob(function (blob) {
      //var formData = new FormData();
      //formData.append('csrf_admin_thy', token);
      //formData.append('avatar-crop', blob);
      var url = configs.admin_site+'user/ajaxChangeAvatar/'+id;
      $.ajax({
          type: 'post',
          data: {'csrf_admin_thy':token,'dataURL':dataURL},
          url: url,
          success: function(rs) {
              alert(rs);
          }
      });
      // $.ajax(url, {
      //   method: "POST",
      //   data: {'csrf_admin_thy':token,formData},
      //   success: function(rs) {
      //     alert(rs);
      //   },
      //   error: function() {
      //     console.log('Upload error');
      //   }
      // });
  });

};