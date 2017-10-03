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
				<form class="form-horizontal form-label-left" method="post" novalidate>
					<div class="x_panel">
						<div class="x_title">
							<h2><?= lang('addmenu')?></h2>
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
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu_name"><?= lang('menuname')?><span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12 item">
									<input id="menu_name" class="form-control col-md-7 col-xs-12" name="menu_name" required="required" type="text" value="<?= $formData['menu_name']?>">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu_status"><?= lang('status')?></label>
								<div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 8px;">
									<input type="radio" class="flat" name="menu_status" id="menu_status1" value="1" <?= $formData['menu_status'] == 1 ? 'checked="checked"' : '';?>/> <?= lang('active')?><br>
									<input type="radio" class="flat" name="menu_status" id="menu_status2" value="2" <?= $formData['menu_status'] == 2 ? 'checked="checked"' : '';?>/> <?= lang('inactive')?>
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
						<h2><?= lang('list')?></h2>
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
									<th width="10%">ID</th>
									<th width="40%"><?= lang('menuname')?></th>
									<th class="text-center"  width="25%"><?= lang('status')?></th>
									<th class="text-center" width="25%"><?= lang('updatedate')?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($list)): ?>
									<?php foreach ($list as $key => $value): ?>
										<?php
											$status = $this->mmenu->listStatusName($value['menu_status']);
											$user = $this->muser->getData('user_fullname',array('id' => $value['user']));
											$linkEdit = my_library::admin_site().'menu/edit/'.$value['id'];
										?>
										<tr class="showacction">
											<th scope="row"><?= $value['id']?></th>
											<td><h5><?= $value['menu_name']?></h5>
												<div style="height: 20px;">
													<div class="actionhover">
														<a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a><?php if ($value['id'] > 1): ?>
															 | <a href="javascript:void(0)" onclick="confirm_delete(<?= $value['id']?>)" class="text-danger"><?= lang('delete')?></a>
														<?php endif ?>
													</div>
												</div>
											</td>
											<td class="text-center"><span class="label label-<?= $status['color']?>"><?= $status['name']?></span></td>
											<td class="text-center"><?= $value['menu_updatedate']?><br><?= lang('by')?> <cite><?= !empty($user) ? $user['user_fullname'] : ''?></cite></td>
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