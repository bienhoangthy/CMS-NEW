<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?></h3>
			</div>
			<div class="title_right hidden-xs">
				<ol class="breadcrumb pull-right">
					<li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>"><?= lang('dashboard')?></a></li>
					<li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>menu"><?= lang('list')?></a></li>
					<li class="breadcrumb-item active"><?= $title?></li>
				</ol>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<form class="form-horizontal form-label-left" method="post" novalidate>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2><?= lang('baseinfo')?></h2>
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
									<input type="radio" class="flat" name="menu_status" id="menu_status1" value="1" <?= $formData['menu_status'] == 1 ? 'checked="checked"' : '';?>/> <?= lang('active')?> -- 
									<input type="radio" class="flat" name="menu_status" id="menu_status2" value="2" <?= $formData['menu_status'] == 2 ? 'checked="checked"' : '';?>/> <?= lang('inactive')?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-5 col-sm-5 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2><i class="fa fa-archive"></i> <?= lang('ingredient')?></h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
								<div class="panel">
									<a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										<h4 class="panel-title">Collapsible Group Items #1</h4>
									</a>
									<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
										<div class="panel-body">
											<table class="table table-bordered">
												<thead>
													<tr>
														<th>#</th>
														<th>First Name</th>
														<th>Last Name</th>
														<th>Username</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<th scope="row">1</th>
														<td>Mark</td>
														<td>Otto</td>
														<td>@mdo</td>
													</tr>
													<tr>
														<th scope="row">2</th>
														<td>Jacob</td>
														<td>Thornton</td>
														<td>@fat</td>
													</tr>
													<tr>
														<th scope="row">3</th>
														<td>Larry</td>
														<td>the Bird</td>
														<td>@twitter</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="panel">
									<a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										<h4 class="panel-title">Collapsible Group Items #2</h4>
									</a>
									<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
										<div class="panel-body">
											<p><strong>Collapsible Item 2 data</strong>
											</p>
											Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
										</div>
									</div>
								</div>
								<div class="panel">
									<a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
										<h4 class="panel-title">Collapsible Group Items #3</h4>
									</a>
									<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
										<div class="panel-body">
											<p><strong>Collapsible Item 3 data</strong>
											</p>
											Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-7 col-sm-7 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2><i class="fa fa-code-fork"></i> <?= lang('structure')?></h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<div class="dd" id="nestable3">
								<ol class="dd-list">
									<li class="dd-item dd3-item" data-id="13">
										<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">
											<span class="pull-left"> Home</span>
											<cite class="pull-right"> Page</cite>
										</div>
										<ol class="dd-list">
											<li class="dd-item dd3-item" data-id="16">
												<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">
													<span class="pull-left"> Home</span>
													<cite class="pull-right"> Page</cite>
												</div>
											</li>
											<li class="dd-item dd3-item" data-id="17">
												<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">
													<span class="pull-left"> Home</span>
													<cite class="pull-right"> Page</cite>
												</div>
											</li>
											<li class="dd-item dd3-item" data-id="18">
												<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">
													<span class="pull-left"> Home</span>
													<cite class="pull-right"> Page</cite>
												</div>
											</li>
										</ol>
									</li>
									<li class="dd-item dd3-item" data-id="14">
										<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">
											<span class="pull-left"> Home</span>
											<cite class="pull-right"> Page</cite>
										</div>
									</li>
									<li class="dd-item dd3-item" data-id="15">
										<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">
											<span class="pull-left"> Home</span>
											<cite class="pull-right"> Page</cite>
										</div>
										<ol class="dd-list">
											<li class="dd-item dd3-item" data-id="16">
												<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">
													<span class="pull-left"> Home</span>
													<cite class="pull-right"> Page</cite>
												</div>
											</li>
											<li class="dd-item dd3-item" data-id="17">
												<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">
													<span class="pull-left"> Home</span>
													<cite class="pull-right"> Page</cite>
												</div>
											</li>
											<li class="dd-item dd3-item" data-id="18">
												<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">
													<span class="pull-left"> Home</span>
													<cite class="pull-right"> Page</cite>
												</div>
											</li>
										</ol>
									</li>
								</ol>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>