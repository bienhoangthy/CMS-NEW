<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?> <a href="<?= my_library::admin_site()?>special_content/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('specialcontentadd')?></button></a></h3>
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
						<div class="">
							<form class="form-horizontal form-label-left" method="get">
								<div class="form-group">
									<div class="col-md-3 col-sm-4 col-xs-6">
										<select class="form-control" name="fcomponent" onchange="this.form.submit()">
											<?= $fcomponent?>
										</select>
									</div>
									<div class="col-md-3 col-sm-4 col-xs-6">
										<select class="form-control" name="forderby" onchange="this.form.submit()">
											<?= $forderby?>
										</select>
									</div>
									<div class="col-md-3 col-sm-4 col-xs-6">
										<select class="form-control" name="fstatus" onchange="this.form.submit()">
											<?= $fstatus?>
										</select>
									</div>
									<div class="col-md-3 col-sm-2 col-xs-6">
										<select class="form-control" name="fuser" onchange="this.form.submit()">
											<?= $fuser?>
										</select>
									</div> 
								</div>
							</form>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th width="3%">ID</th>
									<th width="18%"><?= lang('specialcontenttitle')?></th>
									<th width="15%"><?= lang('positioncode')?></th>
									<th width="10%"><?= lang('category')?></th>
									<th class="text-center" width="7%"><?= lang('quantity')?></th>
									<th class="text-center" width="10%"><?= lang('item')?></th>
									<th class="text-center" width="10%"><?= lang('status')?></th>
									<th class="text-center" width="12%"><?= lang('language')?></th>
									<th class="text-center" width="15%"><?= lang('updatedate')?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($list)): ?>
									<?php foreach ($list as $value): ?>
										<?php 
										$special_content_title = $this->mspecial_content_translation->getData("sc_name",array('sc_id' => $value['id'],'language_code' => $language));
										$special_content_title = $special_content_title['sc_name'] ?? '';
										$category = $this->mcategory_translation->getData("category_name",array('category_id' => $value['sc_category'],'language_code' => $language));
										$category_name = $category['category_name'] ?? '';
										$component = $this->mcomponent->getData("component_name",array('component' => $value['sc_component']));
										$component_name = $component['component_name'] ?? '';
										$linkEdit = my_library::admin_site().'special_content/edit/'.$value['id'];
										$item = $this->mspecial_content->listSOrderBy($value['sc_orderby']);
										$status = $this->mspecial_content->listStatusName($value['sc_status']);
										$listLanguage = $this->mspecial_content_translation->checkLanguage($value['id']);
										$userUpdate = $this->muser->getData('id,user_fullname',array('id' => $value['user']));
										?>
										<tr class="showacction">
											<td><h5 style="font-weight: bold;"><?= $value['id']?></h5></td>
											<td><?= $special_content_title?>
												<div style="height: 20px;">
													<div class="actionhover">
														<a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a><?php if ($value['sc_orderby'] == 5): ?> | <a href="<?= my_library::admin_site().'special_content/item/'.$value['id']?>" class="text-success"><?= lang('item')?></a> <?php endif ?> | <a href="javascript:;" onclick="confirm_delete(<?= $value['id']?>,'<?= lang('specialcontent')?>')" class="text-danger"><?= lang('delete')?></a>
													</div>
												</div>
											</td>
											<td><code><?= $value['code_position']?></code></td>
											<td><a href="<?= my_library::admin_site().'category/edit/'.$value['sc_category']?>" target="_blank"><h5 style="font-weight: bold;" class="text-info"><?= $category_name?></h5></a><cite><?= $component_name?></cite></td>
											<td class="text-center"><span class="badge bg-green"><?= $value['sc_quantity']?></span></td>
											<td class="text-center"><span class="label label-<?= $item['color']?>"><?= $item['name']?></span></td>
											<td class="text-center"><span class="label label-<?= $status['color']?>"><?= $status['name']?></span><?php if ($value['sc_cache'] == 1): ?><br><span class="label label-danger">Cache</span><?php endif ?></td>
											<td class="text-center">
												<?php if (!empty($listLanguage)): ?>
													<?php foreach ($listLanguage as $vallang): ?>
														<img src="<?= my_library::base_file().'language/flag_'.$vallang['language_code'].'.png'?>" style="max-width: 20px;height: auto;">
													<?php endforeach ?>
												<?php endif ?>
											</td>
											<td class="text-center"><?= date("Y-m-d", strtotime($value['sc_updatedate']))?><?= !empty($userUpdate) ? '<br>'.lang('by').' <a href="'.my_library::admin_site().'user/profile/'.$userUpdate['id'].'">'.$userUpdate['user_fullname'].'</a>' : ''?></td>
										</tr>
									<?php endforeach ?>
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