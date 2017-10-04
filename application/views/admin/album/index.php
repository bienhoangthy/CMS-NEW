<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?> <a href="<?= my_library::admin_site()?>album/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('albumadd')?></button></a></h3>
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
											<option <?= $formData['fstatus'] == 10 ? 'selected' : ''?> value="10">- <?= lang('hot')?></option>
										</select>
									</div>
									<div class="col-md-3 col-sm-4 col-xs-6">
										<select class="form-control" name="fcategory" onchange="this.form.submit()">
											<?= $fcategory?>
										</select>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
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
									<th width="25%"><?= lang('albumname')?></th>
									<th width="10%"></th>
									<th width="10%"><?= lang('category')?></th>
									<th class="text-center" width="10%"><?= lang('views')?></th>
									<th class="text-center" width="10%"><?= lang('status')?></th>
									<th class="text-center" width="15%">
										<div class="btn-group">
											<button data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-xs" type="button" aria-expanded="false"><?= $flanguage['lang_name']?> <span class="caret"></span></button>
											<ul role="menu" class="dropdown-menu">
												<?php if (!empty($listLanguage)): ?>
													<?php foreach ($listLanguage as $key => $value): ?>
														<li><a href="<?= current_url().'?flanguage='.$value['lang_code']?>"><?= $value['lang_name']?></a></li>
													<?php endforeach ?>
												<?php endif ?>
											</ul>
										</div>
									</th>
									<th class="text-center" width="17%"><?= lang('updatedate')?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($list)): ?>
									<?php foreach ($list as $key => $value): ?>
										<?php 
										$picture_thumb = $value['album_picture'] != "" ? my_library::base_file().'album/'.$value['id'].'/thumb-'.$value['album_picture'] : my_library::base_public().'admin/images/image-not-found.jpg';
										$picture = $value['album_picture'] != "" ? my_library::base_file().'album/'.$value['id'].'/'.$value['album_picture'] : my_library::base_public().'admin/images/image-not-found.jpg';
										$picture = $value['album_picture'] != "" ? my_library::base_file().'album/'.$value['id'].'/thumb-'.$value['album_picture'] : my_library::base_public().'admin/images/image-not-found.jpg';
										$category = $this->mcategory_translation->getData("category_name",array('category_id' => $value['album_parent'],'language_code' => $flanguage['lang_code']));
										$category_name = $category['category_name'] ?? '';
										$linkEdit = my_library::admin_site().'album/edit/'.$value['id'].'?lang='.$flanguage['lang_code'];
										$linkDetailPhoto = my_library::admin_site().'album/upload/'.$value['id'];
										$status = $this->malbum->listStatusName($value['album_status']);
										$listLanguage = $this->malbum_translation->checkLanguage($value['id']);
										$userUpdate = $this->muser->getData('id,user_fullname',array('id' => $value['user']));
										?>
										<tr class="showacction">
											<td><h5 style="font-weight: bold;"><?= $value['id']?></h5></td>
											<td><?= $value['album_name']?>
												<div style="height: 20px;">
													<div class="actionhover">
														<a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a> | <a href="<?= $linkDetailPhoto?>" class="text-success"><?= lang('detailphoto')?></a> | <a href="javascript:;" onclick="confirm_delete(<?= $value['id']?>)" class="text-danger"><?= lang('delete')?></a>
													</div>
												</div>
											</td>
											<td><a class="fancybox-picture" href="<?= $picture?>" title="<?= $value['album_name']?>"><img src="<?= $picture_thumb?>" class="avatar" style="width: 40px;height: auto;" alt="picture"></a></td>
											<td><a href="<?= my_library::admin_site().'category/edit/'.$value['album_parent']?>" target="_blank"><h5 style="font-weight: bold;" class="text-info"><?= $category_name?></h5></a></td>
											<td class="text-center"><span class="badge bg-green"><?= $value['album_view']?></span></td>
											<td class="text-center"><span class="label label-<?= $status['color']?>"><?= $status['name']?></span><?php if ($value['album_hot'] == 1): ?><br><span class="label label-danger">Hot</span><?php endif ?></td>
											<td class="text-center">
												<?php if (!empty($listLanguage)): ?>
													<?php foreach ($listLanguage as $key => $vallang): ?>
														<img src="<?= my_library::base_file().'language/flag_'.$vallang['language_code'].'.png'?>" style="max-width: 20px;height: auto;">
													<?php endforeach ?>
												<?php endif ?>
											</td>
											<td class="text-center"><?= date("Y-m-d", strtotime($value['album_updatedate']))?><?= !empty($userUpdate) ? '<br>'.lang('by').' <a href="'.my_library::admin_site().'user/profile/'.$userUpdate['id'].'">'.$userUpdate['user_fullname'].'</a>' : ''?></td>
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