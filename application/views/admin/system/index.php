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
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<table class="table">
							<tbody>
								<tr>
									<th width="30%">Framework</th>
									<td width="70%">CodeIgniter Web Framework</td>
								</tr>
								<tr>
									<th width="30%">Version</th>
									<td width="70%"><?= CI_VERSION?></td>
								</tr>
								<tr>
									<th width="30%">PHP Version</th>
									<td width="70%"><?= phpversion()?></td>
								</tr>
								<tr>
									<th width="30%">System</th>
									<td width="70%"><?= php_uname()?></td>
								</tr>
								<tr>
									<th width="30%">Time Zone</th>
									<td width="70%">Asia/Ho_Chi_Minh</td>
								</tr>
								<tr>
									<th width="30%">Host</th>
									<td width="70%"><?= $_SERVER['HTTP_HOST']?></td>
								</tr>
								<tr>
									<th width="30%">Server Software</th>
									<td width="70%"><?= $_SERVER['SERVER_SOFTWARE']?></td>
								</tr>
								<tr>
									<th width="30%">Server Name</th>
									<td width="70%"><?= $_SERVER['SERVER_NAME']?></td>
								</tr>
								<tr>
									<th width="30%">Server Address</th>
									<td width="70%"><?= $_SERVER['SERVER_ADDR']?></td>
								</tr>
								<tr>
									<th width="30%">User Agent</th>
									<td width="70%"><?= $_SERVER['HTTP_USER_AGENT']?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>