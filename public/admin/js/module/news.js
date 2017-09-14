$('.show-extra').click(function(){
	var id = $(this).attr('data-id');
	var extra = $('#extra-'+id);
	var status = extra.css('display');
	if (status == 'none') {extra.show();} else {extra.hide();}
});
// $('.pass-news').click(function(){
// 	var id = $(this).attr('data-id');
// 	swal({
//     title: 'Bảo mật',
//     text: 'Vui lòng nhập mật khẩu bài viết',
//     type: "input",
//     inputType: "password",
//     showCancelButton: true,
//     closeOnConfirm: false,
//     animation: "slide-from-top"
//   },
//   function(inputValue){
//     var url = configs.admin_site+configs.controller+'/checkPassword';
//     $.ajax({
//         type: 'get',
//         data: {"id":id,"password":inputValue},
//         cache: false,
//         url: url,
//         success: function(rs) {
//             if (rs == 1) {
//             	window.location = configs.admin_site+'news/edit/'+id;
//             } else {
//             	var error = 'Không thành công';
//             	var text = 'Mật khẩu không chính xác!';
//             	if (configs.lang == 'english') {error = 'Unsuccessful';text = 'Incorrect password!';}
//             	swal(error, text, "warning");
//             }
//         }
//     });
//   });
// });
function closeExtra(id)
{
	var extra = $('#extra-'+id);
	if (extra) {extra.hide();}
}