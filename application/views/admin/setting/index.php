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
			<form class="form-horizontal form-label-left" method="post">
				<input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
				<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2><i class="fa fa-th-large"></i> <?= lang('settingforsystem')?></h2>
							<div class="navbar-right">
								<button type="submit" class="btn btn-success"><?= lang('save')?></button>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active"><a href="#activity" id="activity-tab" role="tab" data-toggle="tab" aria-expanded="true"><?= lang('activity')?></a>
									</li>
									<li role="presentation" class=""><a href="#charactertitle" role="tab" id="charactertitle-tab" data-toggle="tab" aria-expanded="false"><?= lang('charactertitle')?></a>
									</li>
									<li role="presentation" class=""><a href="#imageratio" role="tab" id="imageratio-tab" data-toggle="tab" aria-expanded="false"><?= lang('imageratio')?></a>
									</li>
									<li role="presentation" class=""><a href="#smtp" role="tab" id="smtp-tab" data-toggle="tab" aria-expanded="false">SMTP</a>
									</li>
									<li role="presentation" class=""><a href="#ga" role="tab" id="ga-tab" data-toggle="tab" aria-expanded="false">Google Analytics</a>
									</li>
								</ul>
								<div id="myTabContent" class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="activity" aria-labelledby="activity-tab">
										<div class="form-group">
											<div class="col-md-6 col-sm-6 col-xs-6">
												
												<label>
													<?= lang('record').' '.lang('activity')?> <input type="checkbox" name="write_log" class="js-switch" value="1" <?= $formData['write_log'] == 1 ? 'checked' : ''?>/>
												</label>
												<br />
												<label>Component:</label>
												<br />
												<?php foreach ($listComponent as $value): ?>
													<?php $checked = in_array($value['id'], $listOldComponent) ? 'checked' : ''; ?>
													<input type="checkbox" <?= $checked?> name="component[]" value="<?= $value['id']?>" class="flat" /> <?= $language == 'english' ? ucfirst($value['component']) : $value['component_name']?>
													<br />
												<?php endforeach ?>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-6">
												<label>
													<?= lang('record').' '.lang('historylogin')?> <input type="checkbox" name="write_history_login" class="js-switch" value="1" <?= $formData['write_history_login'] == 1 ? 'checked' : ''?>/>
												</label>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane fade" id="charactertitle" aria-labelledby="charactertitle-tab">
										<label for="limit_title"><?= lang('limit')?>:</label>
										<input type="number" class="form-control" value="<?= $formData['limit_title']?>" name="limit_title" required="required">
										<code><cite>(<?= lang('news').', '.lang('album').', '.lang('video').', '.lang('product')?>)</cite></code>
									</div>
									<div role="tabpanel" class="tab-pane fade" id="imageratio" aria-labelledby="imageratio-tab">
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12"><?= lang('news')?></label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<select class="form-control" name="ratio_news">
													<?= $ratio_news?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12"><?= lang('album')?></label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<select class="form-control" name="ratio_album">
													<?= $ratio_album?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12"><?= lang('video')?></label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<select class="form-control" name="ratio_video">
													<?= $ratio_video?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12"><?= lang('product')?></label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<select class="form-control" name="ratio_product">
													<?= $ratio_product?>
												</select>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane fade" id="smtp" aria-labelledby="smtp-tab">
										
									</div>
									<div role="tabpanel" class="tab-pane fade" id="ga" aria-labelledby="ga-tab">
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>