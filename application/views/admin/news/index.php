<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?> <a href="<?= my_library::admin_site()?>news/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('newsadd')?></button></a></h3>
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
					<div class="x_title">
					<h2>Form Wizards <small>Sessions</small></h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div id="wizard" class="form_wizard wizard_horizontal">
							<ul class="wizard_steps">
								<li>
									<a href="#step-1">
										<span class="step_no"><i class="fa fa-file-code-o"></i></span>
										<span class="step_descr">
											<?= lang('draft')?>
										</span>
									</a>
								</li>
								<li>
									<a href="#step-2" class="disabled">
										<span class="step_no"><i class="fa fa-edit"></i></span>
										<span class="step_descr">
											<?= lang('pending')?>
										</span>
									</a>
								</li>
								<li>
									<a href="#step-3" class="disabled">
										<span class="step_no"><i class="fa fa-globe"></i></span>
										<span class="step_descr">
											<?= lang('publish')?>
										</span>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>