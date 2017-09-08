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
			<div class="col-md-5 col-sm-5 col-xs-12">
				<form class="form-horizontal form-label-left" method="post" novalidate>
					<div class="x_panel">
						<div class="x_title">
							<h2><?= lang('tagadd')?></h2>
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
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="tag_status"><?= lang('status')?><span class="required">*</span>
								</label>
								<div class="col-md-8 col-sm-8 col-xs-12" style="margin-top: 8px;">
									<input type="radio" class="flat" name="tag_status" id="tag_status1" value="1" <?= $formData['tag_status'] == 1 ? 'checked="checked"' : '';?>/> <?= lang('active')?><br>
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
			<div class="col-md-7 col-sm-7 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<ul class="nav navbar-left">
							<li class="pull-left"><p style="padding: 5px;"><?= lang('all')?> (<?= $record?>)</p></li>
						</ul>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							</li>
							<li><a class="close-link"><i class="fa fa-close"></i></a>
							</li>
						</ul>
						<div class="">
							<form class="form-horizontal form-label-left" method="get">
								<div class="form-group">
									<div class="col-md-4 col-sm-4 col-xs-6">
										<div class="input-group">
											<input type="text" name="fkeyword" value="<?= $formDatalist['fkeyword']?>" placeholder="<?= lang('search')?>" class="form-control">
											<span class="input-group-btn">
												<button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
											</span>
										</div>
									</div>
									<div class="col-md-4 col-sm-4 col-xs-6">
										<select class="form-control" name="fstatus" onchange="this.form.submit()">
											<?= $fstatus?>
										</select>
									</div>
									<input type="hidden" name="page" value="<?= $page?>">  
								</div>
							</form>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="table-responsive">
							<form method="post">
								<input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
								<table class="table table-striped jambo_table bulk_action">
									<thead>
										<tr class="headings">
											<th>
												<input type="checkbox" id="check-all" class="flat">
											</th>
											<th class="column-title" style="width: 200px;"><? lang('tagname')?></th>
											<th class="column-title">Alias</th>
											<th class="column-title"><?= lang('status')?> </th>
											<th class="column-title"><?= lang('updatedate')?> </th>
											<th class="bulk-actions" colspan="11">
												<button type="submit" class="btn btn-danger btn-xs antoo" name="delAll" onclick="return confirm_delete_all();" style="margin-bottom: -2px;"><?= lang('deleteall')?> ( <span class="action-cnt"> </span> )</button>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php if (!empty($list)): ?>
											<?php foreach ($list as $key => $value): ?>
												<?php 
													$status = $this->mtag->listStatusName($value['tag_status']);
													$linkEdit = my_library::admin_site().'tag/edit/'.$value['id'];
												?>
												<tr class="showacction">
													<td class="a-center ">
														<input type="checkbox" class="flat" value="<?= $value['id']?>" name="table_records[]">
													</td>
													<td><span id="name<?= $value['id']?>"><?= $value['tag_name']?></span>
														<div style="height: 20px;">
															<div class="actionhover">
																<a href="javascript:;" data-id="<?= $value['id']?>" class="text-info quickedit"><?= lang('quickedit')?></a> | <a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a> | <a href="javascript:;" onclick="confirm_delete(<?= $value['id']?>);" class="text-danger"><?= lang('delete')?></a>
															</div>
														</div>
													</td>
													<td><code id="alias<?= $value['id']?>"><?= $value['tag_alias']?></code></td>
													<td><span class="label label-<?= $status['color']?>"><?= $status['name']?></span></td>
													<td><?= $value['tag_updatedate']?></td>
												</tr>
											<?php endforeach ?>
										<?php else: ?>
											<p class="text-danger"><?= lang('listempty')?></p>
										<?php endif ?>
									</tbody>
								</table>
							</form>
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