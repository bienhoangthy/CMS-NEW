<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?> <a href="<?= my_library::admin_site()?>banner/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('banneradd')?></button></a></h3>
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
										<select class="form-control" name="fposition" onchange="this.form.submit()">
											<?= $fposition?>
										</select>
									</div>
									<div class="col-md-3 col-sm-4 col-xs-6">
										<select class="form-control" name="ftype" onchange="this.form.submit()">
											<?= $ftype?>
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
									<th width="3%">ID</th>
									<th width="20%"><?= lang('bannertitle')?></th>
									<th width="15%"><?= lang('position')?></th>
									<th width="20%"></th>
									<th class="text-center" width="5%"><?= lang('type')?></th>
									<th class="text-center" width="10%"><?= lang('status')?></th>
									<th class="text-center" width="12%"><?= lang('language')?></th>
									<th class="text-center" width="15%"><?= lang('updatedate')?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($list)): ?>
									<?php foreach ($list as $value): ?>
										<?php 
										$picture = my_library::base_public().'admin/images/image-not-found.jpg';
										switch ($value['banner_type']) {
											case 1:
												if (isset($value['banner_picture']) && $value['banner_picture'] != '') {
													$picture = my_library::base_file().'banner/'.$value['id'].'/thumb-'.$value['banner_picture'];
												}
												break;
											case 2:
												$picture = my_library::base_public().'admin/images/html.png';
												break;
											case 3:
												$picture = my_library::base_public().'admin/images/iframe.png';
												break;
											default:
												break;
										}
										$banner_title = $this->mbanner_translation->getData("banner_title",array('banner_id' => $value['id'],'language_code' => $language));
										$banner_title = $banner_title['banner_title'] ?? '';
										$position = $this->mposition->getData("position_name,position_width,position_height",array('id' => $value['banner_position']));
										$position_title = '';
										if ($position) {
											$position_title = $position['position_name'].'('.$position['position_width'].'x'.$position['position_height'].')';
										}
										$linkEdit = my_library::admin_site().'banner/edit/'.$value['id'];
										$status = $this->mbanner->listStatusName($value['banner_status']);
										$type = $this->mbanner->listType($value['banner_type']);
										$listLanguage = $this->mbanner_translation->checkLanguage($value['id']);
										$userUpdate = $this->muser->getData('id,user_fullname',array('id' => $value['user']));
										?>
										<tr class="showacction">
											<td><h5 style="font-weight: bold;"><?= $value['id']?></h5></td>
											<td><?= $banner_title?>
												<div style="height: 20px;">
													<div class="actionhover">
														<a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a> | <a href="javascript:;" onclick="confirm_delete(<?= $value['id']?>)" class="text-danger"><?= lang('delete')?></a>
													</div>
												</div>
											</td>
											<td><?= $position_title?></td>
											<td><img src="<?= $picture?>" class="avatar" style="width: auto;height: 40px;max-width: 100%;" alt="picture"></td>
											<td class="text-center"><span class="label label-<?= $type['color']?>"><?= $type['name']?></span></td>
											<td class="text-center"><span class="label label-<?= $status['color']?>"><?= $status['name']?></span><?php if (isset($value['banner_link']) && $value['banner_link'] != ''): ?>
												<br><a href="<?= $value['banner_link']?>" target="_blank"><span class="label label-info">Link</span></a>
											<?php endif ?></td>
											<td class="text-center">
												<?php if (!empty($listLanguage)): ?>
													<?php foreach ($listLanguage as $vallang): ?>
														<img src="<?= my_library::base_file().'language/flag_'.$vallang['language_code'].'.png'?>" style="max-width: 20px;height: auto;">
													<?php endforeach ?>
												<?php endif ?>
											</td>
											<td class="text-center"><?= date("Y-m-d", strtotime($value['banner_updatedate']))?><?= !empty($userUpdate) ? '<br>'.lang('by').' <a href="'.my_library::admin_site().'user/profile/'.$userUpdate['id'].'">'.$userUpdate['user_fullname'].'</a>' : ''?></td>
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