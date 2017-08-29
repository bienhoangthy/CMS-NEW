<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?> <a href="<?= my_library::admin_site()?>page/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('addpage')?></button></a></h3>
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
									<th width="25%"><?= lang('titlepage')?></th>
									<th width="15%">Alias</th>
									<th class="text-center" width="15%"><?= lang('template')?></th>
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
											$linkEdit = my_library::admin_site().'page/edit/'.$value['id'].'?lang='.$flanguage['lang_code'];
											$linkView = base_url().$value['page_alias'].'.html';
											$status = $this->mpage->listStatusName($value['page_status']);
											$template = $this->mpage->listTemplate($value['page_template']);
											$listLanguage = $this->mpage_translation->checkLanguage($value['id']);
											$user = $this->muser->getData('user_fullname',array('id' => $value['user']));
										 ?>
										<tr class="showacction">
											<td><h4><?= $value['page_title']?></h4>
												<div style="height: 20px;">
													<div class="actionhover">
														<a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a> | <a href="<?= $linkView?>" class="text-primary" target="_blank"><?= lang('view')?></a> | <a href="javascript:void(0)" onclick="confirm_delete(<?= $value['id']?>)" class="text-danger"><?= lang('delete')?></a>
													</div>
												</div>
											</td>
											<td><cite>/<?= $value['page_alias']?>.html</cite></td>
											<td class="text-center"><h4><code><?= $template['name']?></code></h4></td>
											<td class="text-center"><span class="label label-<?= $status['color']?>"><?= $status['name']?></span></td>
											<td class="text-center">
												<?php if (!empty($listLanguage)): ?>
													<?php foreach ($listLanguage as $key => $vallang): ?>
														<img src="<?= my_library::base_file().'language/flag_'.$vallang['language_code'].'.png'?>" style="max-width: 20px;height: auto;">
													<?php endforeach ?>
												<?php endif ?>
											</td>
											<td class="text-center"><?= $value['page_updatedate']?><br><?= lang('by')?> <cite><?= !empty($user) ? $user['user_fullname'] : ''?></cite></td>
										</tr>
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