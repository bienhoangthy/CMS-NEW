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
					<div class="x_title">
						<h2><small><?= lang('all')?> (<?= $record?>)</small></h2>
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
									<div class="col-md-3 col-sm-4 col-xs-6">
					                    <select class="form-control" name="fgroup" onchange="this.form.submit()">
					                    	<?= $fgroup?>
					                    </select>
					                </div>
								</div>
							</form>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content table-responsive">
						<?php if (!empty($listGroup)): ?>
							<table class="table table-hover">
								<thead>
									<tr>
										<th><?= lang('role')?></th>
										<?php foreach ($listGroup as $key => $v): ?>
											<th class="text-center" style="width: 130px;"><a href="<?= my_library::admin_site().'group/permission/'.$v['id']?>"><?= $v['group_name']?></a></th>
										<?php endforeach ?>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($listAction)): ?>
										<?php foreach ($listAction as $key => $value): ?>
											<tr>
												<td><?= $value['action_name']?> / <small class="text-danger"><?= $value['action_value']?></small></td>
												<?php foreach ($listGroup as $key => $val): ?>
													<?php $checked = $this->mpermission->permission($value['action_value'],$val['id']) == true ? 'checked' : '' ?>
													<td class="text-center">
														<label>
							                            	<input type="checkbox" class="js-switch change-check" name="<?= $value['action_name']?>" action-value="<?= $value['action_value']?>" group-id="<?= $val['id']?>" <?= $checked?>/>
							                             </label>
													</td>
												<?php endforeach ?>
											</tr>
										<?php endforeach ?>
									<?php else: ?>
										<p class="text-danger"><?= lang('listempty')?></p>
									<?php endif ?>
								</tbody>
							</table>
						<?php endif ?>
						<?php if (isset($pagination)): ?>
			              	<ul class="pagination pull-right"><?= $pagination?></ul>
			            <?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>