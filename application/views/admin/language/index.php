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
			<div class="col-md-6 col-sm-6 col-xs-12">
				<form class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" novalidate>
					<div class="x_panel">
						<div class="x_title">
							<h2><?= lang('addlang')?></h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="lang_name"><?= lang('language')?><span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12 item">
									<input id="lang_name" class="form-control col-md-7 col-xs-12" name="lang_name" required="required" type="text" value="<?= $formData['lang_name']?>">
								</div>
							</div>
							<?php if (isset($action) && $action == 1): ?>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="lang_code"><?= lang('code')?><span class="required">*</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12 item">
										<input id="lang_code" class="form-control col-md-7 col-xs-12" name="lang_code" required="required" type="text" value="<?= $formData['lang_code']?>" data-validate-words="1">
									</div>
								</div>
							<?php else: ?>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12"><?= lang('code')?></label>
									<div class="col-md-6 col-sm-6 col-xs-12 item">
										<h4><code><?= $formData['lang_code']?></code></h4>
									</div>
								</div>
							<?php endif ?>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="lang_flag">Icon </label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<img src="<?= $formData['lang_flag'] != '' ? $formData['lang_flag'] : my_library::base_public().'admin/images/user.png'?>" id="showflag" alt="icon" style="max-height: 30px;width: auto; margin-top: 10px;margin-bottom: 5px;">
									<input type="file" id="uploadflag" name="lang_flag" accept="image/*">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="lang_status"><?= lang('status')?><span class="required">*</span>
								</label>
								<div class="col-md-7 col-sm-7 col-xs-12" style="margin-top: 8px;">
									<?= lang('active')?> 
									<input type="radio" class="flat" name="lang_status" id="lang_status1" value="1" <?= $formData['lang_status'] == 1 ? 'checked="checked"' : '';?>/> -- <?= lang('inactive')?>
									<input type="radio" class="flat" name="lang_status" id="lang_status2" value="2" <?= $formData['lang_status'] == 2 ? 'checked="checked"' : '';?>/>
								</div>
							</div>
							<div class="ln_solid"></div>
							<div class="text-center">
								*:<code><?= lang('requiredfields')?></code>
							</div>
							<div class="form-group pull-right">
								<input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
								<button type="submit" class="btn btn-success"><?= lang('save')?></button>
								<button type="reset" class="btn btn-primary"><?= lang('reset')?></button>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2><?= lang('list')?> <small><?= lang('all')?> (<?= $record?>)</small></h2>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							</li>
							<li><a class="close-link"><i class="fa fa-close"></i></a>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table class="table table-hover">
							<thead>
								<tr>
									<th><?= lang('language')?></th>
									<th class="text-center"><?= lang('code')?></th>
									<th>Icon</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($list)): ?>
									<?php foreach ($list as $key => $value): ?>
										<?php 
										$icon = $value['lang_flag'] != "" ? my_library::base_file().'language/'.$value['lang_flag'] : my_library::base_public().'admin/images/user.png';
										$status = $this->mlanguage->listStatusName($value['lang_status']);
										$linkEdit = my_library::admin_site().'language/edit/'.$value['id'];
										$opacity = isset($id) && $id == $value['id'] ? 'style="opacity: 0.2;"' : '';
										?>
										<tr class="showacction" <?= $opacity?>>
											<td style="width: 200px;"><h5 id="name<?= $value['id']?>"><?= $value['lang_name']?></h5>
												<div style="height: 20px;">
													<div class="actionhover">
														<a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a><?= $value['id'] > 2 ? ' | <a href="javascript:void(0)" onclick="confirm_delete('.$value['id'].',\''.lang('language').'\')" class="text-danger">'.lang('delete').'</a>' : '';?>
													</div>
												</div>
											</td>
											<td class="text-center"><h4><code><?= $value['lang_code']?></code></h4></td>
											<td><img src="<?= $icon?>" alt="<?= $value['lang_code']?>" style="max-width: 32px; height: auto;"></td>
											<td><span class="label label-<?= $status['color']?>"><?= $status['name']?></span></td>
										</tr>
									<?php endforeach ?>
								<?php else: ?>
									<p class="text-danger"><?= lang('listempty')?></p>
								<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>