function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#showavatar').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
$("#uploadavatar").change(function(){
    readURL(this);
});

$('#changepass').on('ifChecked', function () {$(".pass").prop('disabled', false);});
$('#changepass').on('ifUnchecked', function () {$(".pass").prop('disabled', true);});