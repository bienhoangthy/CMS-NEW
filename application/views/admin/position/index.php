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
							<h2><?= lang('positionadd')?></h2>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="position_name"><?= lang('positionname')?><span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12 item">
									<input id="position_name" class="form-control col-md-7 col-xs-12" name="position_name" required="required" type="text" value="<?= $formData['position_name']?>" placeholder="Slide home">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="position_width"><?= lang('width')?><span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12 item">
									<input id="position_width" class="form-control col-md-7 col-xs-12" name="position_width" required="required" type="number" value="<?= $formData['position_width']?>" placeholder="500">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="position_height"><?= lang('height')?><span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12 item">
									<input id="position_height" class="form-control col-md-7 col-xs-12" name="position_height" required="required" type="number" value="<?= $formData['position_height']?>" placeholder="200">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="position_status"><?= lang('status')?><span class="required">*</span>
								</label>
								<div class="col-md-7 col-sm-7 col-xs-12" style="margin-top: 8px;">
									<?= lang('active')?> 
									<input type="radio" class="flat" name="position_status" id="position_status1" value="1" <?= $formData['position_status'] == 1 ? 'checked="checked"' : '';?>/> -- <?= lang('inactive')?>
									<input type="radio" class="flat" name="position_status" id="position_status2" value="2" <?= $formData['position_status'] == 2 ? 'checked="checked"' : '';?>/>
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
						<p><?= lang('all')?> (<?= $record?>)</p>
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
									<div class="col-md-5 col-sm-5 col-xs-6">
										<select class="form-control" name="fstatus" onchange="this.form.submit()">
											<?= $fstatus?>
										</select>
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
									<th width="5%">ID</th>
									<th width="35%"><?= lang('position')?></th>
									<th width="20%"><?= lang('width')?> (px)</th>
									<th width="20%"><?= lang('height')?> (px)</th>
									<th width="20%"><?= lang('status')?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($list)): ?>
									<?php foreach ($list as $value): ?>
										<?php 
											$linkEdit = my_library::admin_site().'position/edit/'.$value['id'];
											$status = $this->mposition->listStatusName($value['position_status']);
											$opacity = isset($id) && $id == $value['id'] ? 'style="opacity: 0.2;"' : '';
										 ?>
										<tr class="showacction" <?= $opacity?>>
											<td><b><?= $value['id']?></b></td>
											<td><h5 id="name<?= $value['id']?>"><?= $value['position_name']?></h5>
												<div style="height: 20px;">
													<div class="actionhover">
														<a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a> | <a href="javascript:;" onclick="confirm_delete(<?= $value['id']?>)" class="text-danger"><?= lang('delete')?></a>
													</div>
												</div>
											</td>
											<td><span class="badge bg-green"><?= $value['position_width']?></span></td>
											<td><span class="badge bg-green"><?= $value['position_height']?></span></td>
											<td><span class="label label-<?= $status['color']?>"><?= $status['name']?></span></td>
										</tr>
									<?php endforeach ?>
								<?php else: ?>
									<p class="text-danger"><?= lang('listempty')?></p>
								<?php endif ?>
							</tbody>
						</table>
						<?php if (isset($pagination)): ?>
			              	<ul class="pagination pull-right"><?= $pagination?></ul>
			            <?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>