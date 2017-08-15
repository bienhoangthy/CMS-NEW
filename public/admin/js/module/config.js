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