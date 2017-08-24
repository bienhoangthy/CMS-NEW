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
			<div class="alert alert-success alert-dismissible fade in" role="alert" style="width: 500px;max-width: 100%;">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<cite><?= lang('editinglang').' "'.$langPost['lang_name'].'"'?></cite>
			</div>
			<div class="col-md-5 col-sm-5 col-xs-12">
				<form class="form-horizontal form-label-left" method="post" novalidate>
					<div class="x_panel">
						<div class="x_title">
							<h2><?= lang('addlink')?></h2>
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
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="link_name"><?= lang('titlelink')?><span class="required">*</span>
								</label>
								<div class="col-md-7 col-sm-7 col-xs-12 item">
									<input id="link_name" class="form-control col-md-7 col-xs-12" name="link_name" required="required" type="text" value="<?= $formDataLang['link_name']?>">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="link"><?= lang('link')?><span class="required">*</span>
								</label>
								<div class="col-md-7 col-sm-7 col-xs-12 item">
									<input id="link" class="form-control col-md-7 col-xs-12" name="link" required="required" type="text" value="<?= $formData['link']?>" placeholder="https://google.com">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="link_description"><?= lang('description')?>
								</label>
								<div class="col-md-7 col-sm-7 col-xs-12 item">
									<textarea name="link_description" class="form-control col-md-7 col-xs-12"><?= $formDataLang['link_description']?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="link_status"><?= lang('status')?><span class="required">*</span>
								</label>
								<div class="col-md-7 col-sm-7 col-xs-12" style="margin-top: 10px;">
									<?= lang('active')?> 
									<input type="radio" class="flat" name="link_status" id="link_status1" value="1" <?= $formData['link_status'] == 1 ? 'checked="checked"' : '';?>/> -- <?= lang('inactive')?>
									<input type="radio" class="flat" name="link_status" id="link_status2" value="2" <?= $formData['link_status'] == 2 ? 'checked="checked"' : '';?>/>
								</div>
							</div>
							<div class="ln_solid"></div>
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="link_lang"><img src="<?= my_library::base_file().'language/flag_'.$langPost['lang_code'].'.png'?>" style="height: 20px; width: auto;">
								</label>
								<div class="col-md-7 col-sm-7 col-xs-12">
									<select class="form-control" name="link_lang" onchange="alertChange('<?= $langPost['lang_code']?>');">
										<?= $link_lang?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12"><?= lang('translations')?>:
								</label>
								<div class="col-md-7 col-sm-7 col-xs-12" style="margin-top: 8px; margin-left: 10px;">
									<?php if (!empty($listLanguage)): ?>
										<?php foreach ($listLanguage as $key => $value): ?>
											<?php if ($value['lang_code'] != $langPost['lang_code']): ?>
												<?php 
												if (isset($id) && $this->mlink_translation->checkEditLang($id,$value['lang_code']) == true) {
													$icon = 'edit';$title = lang('edit').' '.$value['lang_name'];
												} else {
													$icon = 'plus-square-o';$title = lang('add').' '.$value['lang_name'];
												}

												?>
												<a href="<?= current_url().'?flanguage='.$value['lang_code']?>" data-toggle="tooltip" data-placement="right" title="<?= $title?>"><i class="fa fa-<?= $icon?>"></i> <?= $value['lang_name']?></a><img src="<?= my_library::base_file().'language/flag_'.$value['lang_code'].'.png'?>" style="height: 15px; width: auto; margin-left: 5px;"><br>
											<?php endif ?>
										<?php endforeach ?>
									<?php endif ?>
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
						<h2><?= lang('list')?> <small><?= lang('all')?> (<?= $record?>)</small></h2>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							</li>
							<li><a class="close-link"><i class="fa fa-close"></i></a>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table class="table table-hover">
							<thead>
								<tr>
									<th><?= lang('titlelink')?></th>
									<th><?= lang('link')?></th>
									<th><?= lang('status')?></th>
									<th class="text-center" width="20%">
										<div class="btn-group">
											<button data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-xs" type="button" aria-expanded="false"><?= $langPost['lang_name']?> <span class="caret"></span></button>
											<ul role="menu" class="dropdown-menu">
												<?php if (!empty($listLanguage)): ?>
													<?php foreach ($listLanguage as $key => $value): ?>
														<li><a href="<?= current_url().'?flanguage='.$value['lang_code']?>"><?= $value['lang_name']?></a></li>
													<?php endforeach ?>
												<?php endif ?>
											</ul>
										</div>
									</th>
									<th class="text-center"><?= lang('craetedate')?></th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($list)): ?>
									<?php foreach ($list as $key => $value): ?>
										<?php 
											$status = $this->mlink->listStatusName($value['link_status']);
											$listLanguageCur = $this->mlink_translation->checkLanguage($value['id']);
											$linkEdit = my_library::admin_site().'link/edit/'.$value['id'].'?flanguage='.$langPost['lang_code'];
											$user = $this->muser->getData('user_fullname',array('id' => $value['user']));
										 ?>	
										<tr class="showacction">
											<td><h5 id="title<?= $value['id']?>"><?= $value['link_name']?></h5>
												<div style="height: 20px; width: 100px;">
													<div class="actionhover">
														<a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a> | <a href="javascript:void(0)" onclick="confirm_delete(<?= $value['id']?>)" class="text-danger"><?= lang('delete')?></a>
													</div>
												</div>
											</td>
											<td><code><?= $value['link']?></code></td>
											<td><span class="label label-<?= $status['color']?>"><?= $status['name']?></span></td>
											<td class="text-center">
												<?php if (!empty($listLanguageCur)): ?>
													<?php foreach ($listLanguageCur as $key => $vallang): ?>
														<img src="<?= my_library::base_file().'language/flag_'.$vallang['language_code'].'.png'?>" style="max-width: 20px;height: auto;">
													<?php endforeach ?>
												<?php endif ?>
											</td>
											<td class="text-center"><?= $value['link_createdate']?><br><cite><?= !empty($user) ? $user['user_fullname'] : ''?></cite></td>
										</tr>
									<?php endforeach ?>
								<?php else: ?>
									<p class="text-danger"><?= lang('listempty')?></p>
								<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>