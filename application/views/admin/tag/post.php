<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?></h3>
			</div>
			<div class="title_right hidden-xs">
				<ol class="breadcrumb pull-right">
					<li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>"><?= lang('dashboard')?></a></li>
					<li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>tag"><?= lang('list')?></a></li>
					<li class="breadcrumb-item active"><?= $title?></li>
				</ol>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2 col-xs-12">
				<form class="form-horizontal form-label-left" method="post" novalidate>
					<div class="x_panel">
						<div class="x_title">
							<h2><?= $title?></h2>
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
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="tag_name"><?= lang('tagname')?><span class="required">*</span>
								</label>
								<div class="col-md-8 col-sm-8 col-xs-12 item">
									<input id="tag_name" class="form-control col-md-7 col-xs-12" name="tag_name" required="required" type="text" value="<?= $formData['tag_name']?>">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="tag_alias">Alias<span class="required">*</span>
								</label>
								<div class="col-md-8 col-sm-8 col-xs-12 item">
									<input id="tag_alias" class="form-control col-md-7 col-xs-12" name="tag_alias" required="required" type="text" value="<?= $formData['tag_alias']?>">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="tag_status"><?= lang('status')?><span class="required">*</span>
								</label>
								<div class="col-md-8 col-sm-8 col-xs-12" style="margin-top: 8px;">
									<input type="radio" class="flat" name="tag_status" id="tag_status1" value="1" <?= $formData['tag_status'] == 1 ? 'checked="checked"' : '';?>/> <?= lang('active')?> - 
									<input type="radio" class="flat" name="tag_status" id="tag_status2" value="2" <?= $formData['tag_status'] == 2 ? 'checked="checked"' : '';?>/> <?= lang('inactive')?>
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
		</div>
	</div>
</div>