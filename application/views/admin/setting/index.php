<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?></h3>
			</div>
			<div class="title_right hidden-xs">
				<ol class="breadcrumb pull-right">
					<li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>"><?= lang('dashboard')?></a></li>
					<li class="breadcrumb-item active"><?= $title?></li>
				</ol>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<ul>
			    <li>Các mục cần ghi log</li>
			    <li>Cho phép xuất bản từ bản nháp</li>
			    <li>Số lần khóa khi nhập sai mật khẩu</li>
			    <li>Cho phép reset lại mật khẩu</li>
			    <li>Giới hạn ký tự đặt tiêu đề</li>
			    <li>Chọn tỉ lệ ảnh</li>
			    <li>Mục hiển thị bảng điều khiển</li>
			</ul>
		</div>
	</div>
</div>