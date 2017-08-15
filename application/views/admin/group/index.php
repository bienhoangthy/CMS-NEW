<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?> <a href="<?= my_library::admin_site()?>group/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('addgroup')?></button></a></h3>
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
			                  <div class="col-md-3 col-sm-3 col-xs-6">
			                    <div class="input-group">
			                      <input type="text" name="fkeyword" value="<?= $formData['fkeyword']?>" placeholder="<?= lang('search')?>" class="form-control">
			                      <span class="input-group-btn">
			                        <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
			                      </span>
			                    </div>
			                  </div>
			                  <div class="col-md-3 col-sm-4 col-xs-6">
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
					<div class="x_content table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>ID</th>
									<th><?= lang('groupname')?></th>
									<th><?= lang('status')?></th>
									<th><?= lang('craetedate')?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($list)): ?>
									<?php foreach ($list as $key => $value): ?>
										<?php 
											$status = $this->mgroup->listStatusName($value['group_status']);
											$linkPermission = my_library::admin_site().'group/permission/'.$value['id'];
											$linkEdit = my_library::admin_site().'group/edit/'.$value['id'];
										 ?>
										<tr class="showacction">
											<th scope="row"><?= $value['id']?></th>
											<td style="width: 300px;"><?= $value['group_name']?>
												<div style="height: 20px;">
						                            <div class="actionhover">
						                              <a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a> | <a href="<?= $linkPermission?>" class="text-success"><?= lang('groupper')?></a><?= $value['id'] > 1 ? ' | <a href="javascript:void(0)" onclick="confirm_delete('.$value['id'].')" class="text-danger">'.lang('delete').'</a>' : '';?>
						                            </div>
						                        </div>
											</td>
											<td><span class="label label-<?= $status['color']?>"><?= $status['name']?></span></td>
											<td><?= $value['group_createdate']?></td>
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
</div>