window.onload = function () {
  var Cropper = window.Cropper;
  var dataX = document.getElementById('dataX');
  var dataY = document.getElementById('dataY');
  var dataHeight = document.getElementById('dataHeight');
  var dataWidth = document.getElementById('dataWidth');
  var options = {
        aspectRatio: 16 / 9,
        preview: '.img-preview',
        crop: function (e) {
          dataX.value = Math.round(e.detail.x);
          dataY.value = Math.round(e.detail.y);
          dataHeight.value = Math.round(e.detail.height);
          dataWidth.value = Math.round(e.detail.width);
        },
      };
  var cropper = new Cropper(image, options);
  var saveImg = document.getElementById('save-image');
  // Import image
  var inputImage = document.getElementById('inputImage');
  var URL = window.URL || window.webkitURL;
  var blobURL;
  if (URL) {
    inputImage.onchange = function () {
      var files = this.files;
      if (cropper && files && files.length) {
        file = files[0];
        if (/^image\/\w+/.test(file.type)) {
          blobURL = URL.createObjectURL(file);
          cropper.reset().replace(blobURL);
          inputImage.value = null;
          saveImg.disabled = false;
        } else {
          window.alert('Please choose an image file.');
        }
      }
    };
  } else {
    inputImage.disabled = true;
    inputImage.parentNode.className += ' disabled';
  }

  saveImg.addEventListener('click', function(){
    var cropBefore = document.getElementById('file-image');
    if (cropBefore) {cropBefore.remove();}
    var imageData = cropper.getCroppedCanvas();
    var dataURL = imageData.toDataURL('image/jpeg');
    var form = document.getElementById('formNews');
    var input = document.createElement('input');
    input.type = 'hidden';
    input.id = 'file-image';
    input.name = 'file';
    input.value = dataURL;
    form.appendChild(input);
    var currentImg = document.getElementById('current-image');
    if (currentImg) {currentImg.style.visibility = 'hidden';}
  });

  document.getElementById('destroy-image').addEventListener('click', function(){
    cropper.destroy();
    saveImg.disabled = true;
    var input = document.getElementById('file-image');
    if (input) {input.value = null;}
    var currentImg = document.getElementById('current-image');
    if (currentImg) {currentImg.style.visibility = 'visible';}
  });
};

function deleteImg(id)
{
  swal({
    title: confirm,
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes!",
    closeOnConfirm: false
  },
  function(){
    var url = configs.admin_site+configs .controller+'/deleteImage';
    $.ajax({
      url: url,
      data: {"id":id},
      cache: false,
      success: function(rs) {
        if (rs == 1) {
          swal(complete, done+delimage+success,"success");
          var currentImg = document.getElementById('current-image');
          var btnDelimg = document.getElementById('button-delimg');
          if (currentImg) {currentImg.remove();}
          if (btnDelimg) {btnDelimg.remove();}
        } else {
          swal(notcomplete, retry,"error");
        }
      }
    });
  });
}

tinymce.init({selector: 'textarea#news_detail',height: 300,theme: 'modern',plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help responsivefilemanager'
  ],toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',toolbar2: 'responsivefilemanager | print preview media | forecolor backcolor emoticons | codesample help',image_caption: true,image_advtab: true,relative_urls:false,external_filemanager_path:"/public/filemanager/",filemanager_title:"Quản lý file",filemanager_access_key: "e807f1fcf82d132f9bb018ca6738a19f",external_plugins: { "filemanager" : "/public/filemanager/plugin.min.js"}});