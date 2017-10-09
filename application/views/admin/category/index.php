<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?> <a href="<?= my_library::admin_site()?>category/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('categoryadd')?></button></a></h3>
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
					<div class="x_content table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th width="25%"><?= lang('categoryname')?></th>
									<th width="15%">Alias</th>
									<th class="text-center" width="15%">ID - Component</th>
									<th class="text-center" width="10%"><?= lang('status')?></th>
									<th class="text-center" width="20%">
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
									<th class="text-center" width="15%"><?= lang('updatedate')?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($list)): ?>
									<?php foreach ($list as $key => $value): ?>
										<?php 
											$linkEdit = my_library::admin_site().'category/edit/'.$value['id'].'?lang='.$flanguage['lang_code'];
											$linkView = base_url().$value['category_alias'].'.html';
											$status = $this->mcategory->listStatusName($value['category_status']);
											$listLanguage = $this->mcategory_translation->checkLanguage($value['id']);
											$user = $this->muser->getData('user_fullname',array('id' => $value['user']));
										 ?>
										<tr class="showacction">
											<td><h3><?= $value['category_name']?></h3>
												<div style="height: 20px;">
													<div class="actionhover">
														<a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a> | <a href="<?= $linkView?>" class="text-primary" target="_blank"><?= lang('view')?></a><?= $value['id'] > 1 ? ' | <a href="javascript:void(0)" onclick="confirm_delete('.$value['id'].',\''.lang('category').'\')" class="text-danger">'.lang('delete').'</a>' : '';?>
													</div>
												</div>
											</td>
											<td><cite>/<?= $value['category_alias']?>.html</cite></td>
											<td class="text-center"><h4><code><?= $value['id'].' - '.$value['category_component']?></code></h4></td>
											<td class="text-center"><span class="label label-<?= $status['color']?>"><?= $status['name']?></span></td>
											<td class="text-center">
												<?php if (!empty($listLanguage)): ?>
													<?php foreach ($listLanguage as $key => $vallang): ?>
														<img src="<?= my_library::base_file().'language/flag_'.$vallang['language_code'].'.png'?>" style="max-width: 20px;height: auto;">
													<?php endforeach ?>
												<?php endif ?>
											</td>
											<td class="text-center"><?= $value['category_updatedate']?><br><?= lang('by')?> <cite><?= !empty($user) ? $user['user_fullname'] : ''?></cite></td>
										</tr>
										<?php if (isset($value['subcate'])): ?>
											<?php foreach ($value['subcate'] as $key => $val): ?>
												<?php 
													$linkEdit = my_library::admin_site().'category/edit/'.$val['id'].'?lang='.$flanguage['lang_code'];
													$linkView = base_url().$val['category_alias'].'.html';
													$status = $this->mcategory->listStatusName($val['category_status']);
													$listLanguage = $this->mcategory_translation->checkLanguage($val['id']);
													$user = $this->muser->getData('user_fullname',array('id' => $val['user']));
												 ?>
												<tr class="showacction">
													<td style="padding-left: 20px;"><h4 class="text-success"><i class="fa fa-arrow-circle-right fa-lg"></i> <?= $val['category_name']?></h4>
														<div style="height: 20px;">
															<div class="actionhover">
																<a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a> | <a href="<?= $linkView?>" class="text-primary" target="_blank"><?= lang('view')?></a><?= $val['id'] > 1 ? ' | <a href="javascript:void(0)" onclick="confirm_delete('.$val['id'].',\''.lang('category').'\')" class="text-danger">'.lang('delete').'</a>' : '';?>
															</div>
														</div>
													</td>
													<td><cite>/<?= $val['category_alias']?>.html</cite></td>
													<td class="text-center"><h4><code><?= $val['id'].' - '.$val['category_component']?></code></h4></td>
													<td class="text-center"><span class="label label-<?= $status['color']?>"><?= $status['name']?></span></td>
													<td class="text-center">
														<?php if (!empty($listLanguage)): ?>
															<?php foreach ($listLanguage as $key => $vallang): ?>
																<img src="<?= my_library::base_file().'language/flag_'.$vallang['language_code'].'.png'?>" style="max-width: 20px;height: auto;">
															<?php endforeach ?>
														<?php endif ?>
													</td>
													<td class="text-center"><?= $val['category_updatedate']?><br><?= lang('by')?> <cite><?= !empty($user) ? $user['user_fullname'] : ''?></cite></td>
												</tr>
												<?php if (isset($val['sub_subcate'])): ?>
													<?php foreach ($val['sub_subcate'] as $key => $v): ?>
														<?php 
															$linkEdit = my_library::admin_site().'category/edit/'.$v['id'].'?lang='.$flanguage['lang_code'];
															$linkView = base_url().$v['category_alias'].'.html';
															$status = $this->mcategory->listStatusName($v['category_status']);
															$listLanguage = $this->mcategory_translation->checkLanguage($v['id']);
															$user = $this->muser->getData('user_fullname',array('id' => $v['user']));
														 ?>
														<tr class="showacction">
															<td style="padding-left: 40px;"><h5 class="text-primary"><i class="fa fa-arrow-circle-right fa-lg"></i> <?= $v['category_name']?></h5>
																<div style="height: 20px;">
																	<div class="actionhover">
																		<a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a> | <a href="<?= $linkView?>" class="text-primary" target="_blank"><?= lang('view')?></a><?= $v['id'] > 1 ? ' | <a href="javascript:void(0)" onclick="confirm_delete('.$v['id'].',\''.lang('category').'\')" class="text-danger">'.lang('delete').'</a>' : '';?>
																	</div>
																</div>
															</td>
															<td><cite>/<?= $v['category_alias']?>.html</cite></td>
															<td class="text-center"><h4><code><?= $v['id'].' - '.$v['category_component']?></code></h4></td>
															<td class="text-center"><span class="label label-<?= $status['color']?>"><?= $status['name']?></span></td>
															<td class="text-center">
																<?php if (!empty($listLanguage)): ?>
																	<?php foreach ($listLanguage as $key => $vallang): ?>
																		<img src="<?= my_library::base_file().'language/flag_'.$vallang['language_code'].'.png'?>" style="max-width: 20px;height: auto;">
																	<?php endforeach ?>
																<?php endif ?>
															</td>
															<td class="text-center"><?= $v['category_updatedate']?><br><?= lang('by')?> <cite><?= !empty($user) ? $user['user_fullname'] : ''?></cite></td>
														</tr>
													<?php endforeach ?>
												<?php endif ?>
											<?php endforeach ?>
										<?php endif ?>
									<?php endforeach ?>
								<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>