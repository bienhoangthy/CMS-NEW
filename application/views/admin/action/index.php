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
							<h2><?= lang('addrole')?></h2>
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
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="action_name"><?= lang('rolename')?><span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12 item">
									<input id="action_name" class="form-control col-md-7 col-xs-12" name="action_name" required="required" type="text" value="<?= $formData['action_name']?>" placeholder="<?= lang('listrole')?>">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="action_value"><?= lang('rolevalue')?><span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12 item">
									<input id="action_value" class="form-control col-md-7 col-xs-12" name="action_value" required="required" type="text" value="<?= $formData['action_value']?>" placeholder="action_index">
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
						<h2><?= lang('listrole')?> <small><?= lang('all')?> (<?= $record?>)</small></h2>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							</li>
							<li><a class="close-link"><i class="fa fa-close"></i></a>
							</li>
						</ul>
						<div class="">
							<form class="form-horizontal form-label-left" method="get">
								<div class="form-group">
									<div class="col-md-5 col-sm-5 col-xs-6">
										<div class="input-group">
										<input type="text" name="fkeyword" value="<?= $formSearch['fkeyword']?>" placeholder="<?= lang('search')?>" class="form-control">
											<span class="input-group-btn">
												<button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
											</span>
										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>ID</th>
									<th><?= lang('rolename')?></th>
									<th><?= lang('rolevalue')?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($list)): ?>
									<?php foreach ($list as $key => $value): ?>
										<tr class="showacction">
											<th scope="row"><?= $value['id']?></th>
											<td><h5 id="name<?= $value['id']?>"><?= $value['action_name']?></h5>
												<div style="height: 20px;">
													<div class="actionhover">
														<a href="javascript:void(0)" onclick="changename('<?= $value['id']?>')" class="text-primary"><?= lang('quickedit')?></a> | <a href="javascript:void(0)" onclick="confirm_delete(<?= $value['id']?>)" class="text-danger"><?= lang('delete')?></a>
													</div>
												</div>
											</td>
											<td><h4><code><?= $value['action_value']?></code></h4></td>
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