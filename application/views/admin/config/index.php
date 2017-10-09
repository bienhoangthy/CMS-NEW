<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?> <a href="<?= my_library::admin_site()?>config/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('configadd')?></button></a> <a href="<?= my_library::admin_site()?>config/logo_favion"><button type="button" class="btn btn-success btn-xs">Logo & Favicon</button></a></h3>
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
									<th width="20%"><?= lang('name')?></th>
									<th width="30%"><?= lang('value')?></th>
									<th class="text-center" width="10%"><?= lang('code')?></th>
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
									<th class="text-center" width="10%"><?= lang('user')?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($list)): ?>
									<?php foreach ($list as $key => $value): ?>
										<?php 
										$linkEdit = my_library::admin_site().'config/edit/'.$value['id'].'?lang='.$flanguage['lang_code'];
										$status = $this->mconfig->listStatusName($value['config_status']);
										$listLanguage = $this->mconfig_translation->checkLanguage($value['id']);
										$user = $this->muser->getData('user_fullname',array('id' => $value['config_user']));
										?>
										<tr class="showacction">
											<td><?= $value['config_name']?>
												<div style="height: 20px;">
													<div class="actionhover">
														<a href="javascript:void(0)" onclick="quickedit('<?= $value['id_lang']?>','<?= $value['config_name']?>')" class="text-primary"><?= lang('quickedit')?></a> | <a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a> | <a href="javascript:;" data-id="<?= $value['id']?>" data-name="<?= lang('config')?>" class="text-danger delete"><?= lang('delete')?></a>
													</div>
												</div>
											</td>
											<td id="value<?= $value['id_lang']?>"><p data-toggle="tooltip" data-placement="bottom" title="<?= $value['config_value']?>"><?= word_limiter($value['config_value'], 10);?></p></td>
											<td class="text-center"><code><?= $value['config_code']?></code></td>
											<td class="text-center"><span class="label label-<?= $status['color']?>"><?= $status['name']?></span></td>
											<td class="text-center">
												<?php if (!empty($listLanguage)): ?>
													<?php foreach ($listLanguage as $key => $vallang): ?>
														<img src="<?= my_library::base_file().'language/flag_'.$vallang['language_code'].'.png'?>" style="max-width: 20px;height: auto;">
													<?php endforeach ?>
												<?php endif ?>
											</td>
											<td class="text-center"><?= !empty($user) ? $user['user_fullname'] : ''?></td>
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