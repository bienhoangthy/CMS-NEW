<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?> <a href="<?= my_library::admin_site()?>module/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('addmodule')?></button></a></h3>
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
									<th>ID</th>
									<th><?= lang('modulename')?></th>
									<th><?= lang('status')?></th>
									<!-- <th class="text-center"><?= lang('language')?></th> -->
									<th class="text-center">
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
									<th>ICON</th>
									<th style="width: 100px;">Component</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($list)): ?>
									<?php foreach ($list as $key => $value): ?>
										<?php 
										$status = $this->mmodule->listStatusName($value['module_status']);
										$linkEdit = my_library::admin_site().'module/edit/'.$value['id'].'?lang='.$flanguage['lang_code'];
										$opacity = $value['module_status'] != 1 ? 'style="opacity: 0.2"' : '';
										$listLanguage = $this->mmodule_translation->checkLanguage($value['id']);
										?>
										<tr class="showacction" <?= $opacity?>>
											<th scope="row"><?= $value['id']?></th>
											<td style="width: 400px;"><h3><?= $value['module_name']?></h3>
												<div style="height: 20px;">
													<div class="actionhover">
														<a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a> | <a href="javascript:void(0)" onclick="confirm_delete(<?= $value['id']?>)" class="text-danger"><?= lang('delete')?></a>
													</div>
												</div>
											</td>
											<td>
												<span class="label label-<?= $status['color']?>"><?= $status['name']?></span><br><br>
												<span class="label label-primary"><?= lang('level')?> 1</span>
											</td>
											<td class="text-center">
												<?php if (!empty($listLanguage)): ?>
													<?php foreach ($listLanguage as $key => $vallang): ?>
														<img src="<?= my_library::base_file().'language/flag_'.$vallang['language_code'].'.png'?>" style="max-width: 20px;height: auto;">
													<?php endforeach ?>
												<?php endif ?>
											</td>
											<td><?= $value['module_icon'] != '' ? '<i class="fa '.$value['module_icon'].' fa-2x"></i>' : ''?></td>
											<td class="text-center"><code><?= $value['module_component']?></code></td>
										</tr>
										<?php if (isset($value['submodule'])): ?>
											<?php foreach ($value['submodule'] as $key => $val): ?>
												<?php 
												$status = $this->mmodule->listStatusName($val['module_status']);
												$linkEdit = my_library::admin_site().'module/edit/'.$val['id'].'?lang='.$flanguage['lang_code'];
												$opacitysub = $val['module_status'] != 1 || $value['module_status'] != 1 ? 'style="opacity: 0.2"' : '';
												$listLanguagesub = $this->mmodule_translation->checkLanguage($val['id']);
												?>
												<tr class="showacction" <?= $opacitysub?>>
													<th scope="row"><?= $val['id']?></th>
													<td style="width: 400px;"><h4 style="margin-left: 30px;color: #16a085"><i class="fa fa-arrow-circle-right"></i> <?= $val['module_name']?></h4>
														<div style="height: 20px;margin-left: 30px;">
															<div class="actionhover">
																<a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a> | <a href="javascript:void(0)" onclick="confirm_delete(<?= $val['id']?>)" class="text-danger"><?= lang('delete')?></a>
															</div>
														</div>
													</td>
													<td>
														<span class="label label-<?= $status['color']?>"><?= $status['name']?></span><br><br>
														<span class="label label-info"><?= lang('level')?> 2</span>
													</td>
													<td class="text-center">
														<?php if (!empty($listLanguagesub)): ?>
															<?php foreach ($listLanguagesub as $key => $vallangsub): ?>
																<img src="<?= my_library::base_file().'language/flag_'.$vallangsub['language_code'].'.png'?>" style="max-width: 20px;height: auto;">
															<?php endforeach ?>
														<?php endif ?>
													</td>
													<td></td>
													<td class="text-center"><code><?= $val['module_component']?></code></td>
												</tr>
											<?php endforeach ?>
										<?php endif ?>
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