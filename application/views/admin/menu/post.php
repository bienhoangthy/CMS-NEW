<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?></h3>
			</div>
			<div class="title_right hidden-xs">
				<ol class="breadcrumb pull-right">
					<li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>"><?= lang('dashboard')?></a></li>
					<li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>menu"><?= lang('list')?></a></li>
					<li class="breadcrumb-item active"><?= $title?></li>
				</ol>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<form class="form-horizontal form-label-left" id="formMenu" data-id="<?= $id?>" method="post" novalidate>
				<input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
				<textarea name="menu_order" id="nestable-output" class="form-control hide"></textarea>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2><?= lang('baseinfo')?></h2>
							<ul class="nav navbar-right panel_toolbox">
								<button type="submit" class="btn btn-success"><?= lang('save')?></button>
								<button type="reset" class="btn btn-primary"><?= lang('reset')?></button>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu_name"><?= lang('menuname')?><span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12 item">
									<input id="menu_name" class="form-control col-md-7 col-xs-12" name="menu_name" required="required" type="text" value="<?= $formData['menu_name']?>">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu_status"><?= lang('status')?></label>
								<div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 8px;">
									<input type="radio" class="flat" name="menu_status" id="menu_status1" value="1" <?= $formData['menu_status'] == 1 ? 'checked="checked"' : '';?>/> <?= lang('active')?> -- 
									<input type="radio" class="flat" name="menu_status" id="menu_status2" value="2" <?= $formData['menu_status'] == 2 ? 'checked="checked"' : '';?>/> <?= lang('inactive')?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-5 col-sm-5 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2><i class="fa fa-archive"></i> <?= lang('ingredient')?></h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
								<div class="panel">
									<a class="panel-heading" role="tab" id="category" data-toggle="collapse" data-parent="#accordion" href="#collapseCate" aria-expanded="true" aria-controls="collapseCate">
										<h4 class="panel-title"><?= lang('category')?></h4>
									</a>
									<div id="collapseCate" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="category">
										<div class="panel-body">
											<ul class="category-tree" style="list-style: none;">
												<?php if (!empty($listCategory)): ?>
													<?php foreach ($listCategory as $key => $value): ?>
														<li><button type="button" class="btn btn-dark btn-xs add-menu" data-id="<?= $value['id']?>" data-name="<?= $value['category_name']?>" data-ingredient-id="1" data-ingredient-name="<?= lang('category')?>" data-toggle="tooltip" data-placement="left" title="<?= lang('addtomenu')?>"><i class="fa fa-share"></i></button><?= $value['category_name']?> / <code><?= $value['category_alias']?></code></li>
														<?php if (isset($value['subcate'])): ?>
															<?php foreach ($value['subcate'] as $key => $val): ?>
																<li>&emsp;<button type="button" class="btn btn-primary btn-xs add-menu" data-id="<?= $val['id']?>" data-name="<?= $val['category_name']?>" data-ingredient-id="1" data-ingredient-name="<?= lang('category')?>" data-toggle="tooltip" data-placement="left" title="<?= lang('addtomenu')?>"><i class="fa fa-share"></i></button><?= $val['category_name']?> / <code><?= $val['category_alias']?></code></li>
																<?php if (isset($val['sub_subcate'])): ?>
																	<?php foreach ($val['sub_subcate'] as $key => $v): ?>
																		<li>&emsp;&emsp;<button type="button" class="btn btn-info btn-xs add-menu" data-id="<?= $v['id']?>" data-name="<?= $v['category_name']?>" data-ingredient-id="1" data-ingredient-name="<?= lang('category')?>" data-toggle="tooltip" data-placement="left" title="<?= lang('addtomenu')?>"><i class="fa fa-share"></i></button><?= $v['category_name']?> / <code><?= $v['category_alias']?></code></li>
																	<?php endforeach ?>
																<?php endif ?>
															<?php endforeach ?>
														<?php endif ?>
													<?php endforeach ?>
												<?php endif ?>
											</ul>
										</div>
									</div>
								</div>
								<div class="panel">
									<a class="panel-heading collapsed" role="tab" id="page" data-toggle="collapse" data-parent="#accordion" href="#collapsePage" aria-expanded="false" aria-controls="collapsePage">
										<h4 class="panel-title"><?= lang('page')?></h4>
									</a>
									<div id="collapsePage" class="panel-collapse collapse" role="tabpanel" aria-labelledby="page">
										<div class="panel-body">
											<ul class="category-tree" style="list-style: none;">
												<?php if (!empty($listPage)): ?>
													<?php foreach ($listPage as $key => $value): ?>
														<li><button type="button" class="btn btn-dark btn-xs add-menu" data-id="<?= $value['id']?>" data-name="<?= $value['page_title']?>" data-ingredient-id="2" data-ingredient-name="<?= lang('page')?>" data-toggle="tooltip" data-placement="left" title="<?= lang('addtomenu')?>"><i class="fa fa-share"></i></button><?= $value['page_title']?> / <code><?= $value['page_alias']?></code></li>
													<?php endforeach ?>
												<?php endif ?>
											</ul>
										</div>
									</div>
								</div>
								<div class="panel">
									<a class="panel-heading collapsed" role="tab" id="link" data-toggle="collapse" data-parent="#accordion" href="#collapseLink" aria-expanded="false" aria-controls="collapseLink">
										<h4 class="panel-title"><?= lang('link')?></h4>
									</a>
									<div id="collapseLink" class="panel-collapse collapse" role="tabpanel" aria-labelledby="link">
										<div class="panel-body">
											<ul class="category-tree" style="list-style: none;">
												<?php if (!empty($listLink)): ?>
													<?php foreach ($listLink as $key => $value): ?>
														<li><button type="button" class="btn btn-dark btn-xs add-menu" data-id="<?= $value['id']?>" data-name="<?= $value['link_name']?>" data-ingredient-id="3" data-ingredient-name="<?= lang('link')?>" data-toggle="tooltip" data-placement="left" title="<?= lang('addtomenu')?>"><i class="fa fa-share"></i></button><?= $value['link_name']?> / <code><?= $value['link']?></code></li>
													<?php endforeach ?>
												<?php endif ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-7 col-sm-7 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2><i class="fa fa-code-fork"></i> <?= lang('structure')?></h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li><a class="close-link"><i class="fa fa-close"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<div class="dd" id="nestable3">
								<ol class="dd-list" id="nestable-content">
									<?php if (!empty($menuDetail)): ?>
										<?php foreach ($menuDetail as $key => $value): ?>
											<?php 
											$name = '';
											$alias = '';
											switch ($value['ingredient']) {
												case 1:
												$ingredient = $this->mcategory_translation->getData("category_name,category_alias",array('category_id' => $value['ingredient_id'],'language_code' => $language));
												if (!empty($ingredient)) {
													$name = $ingredient['category_name'];
													$alias = $ingredient['category_alias'];
												}
												break;
												case 2:
												$ingredient = $this->mpage_translation->getData("page_title,page_alias",array('page_id' => $value['ingredient_id'],'language_code' => $language));
												if (!empty($ingredient)) {
													$name = $ingredient['page_title'];
													$alias = $ingredient['page_alias'];
												}
												break;
												case 3:
												$ingredient_link = $this->mlink->getData("link",array('id' => $value['ingredient_id']));
												$ingredient_link_name = $this->mlink_translation->getData("link_name",array('link_id' => $value['ingredient_id'],'language_code' => $language));
												if (!empty($ingredient_link)) {
													$alias = $ingredient_link['link'];
												}
												if (!empty($ingredient_link_name)) {
													$name = $ingredient_link_name['link_name'];
												}
												break;
											}
											$type = $this->mmenu_detail->listIngredient($value['ingredient']);
											$checked = $value['click_allow'] == 1 ? 'checked="checked"' : '';
											?>
											<li class="dd-item dd3-item" id="nes-<?= $value['id']?>" data-id="<?= $value['id']?>">
												<div class="dd-handle dd3-handle">Drag</div>
												<div class="dd3-content" onclick="showExtra('<?= $value['id']?>')">
													<span class="pull-left"> <?= $name?></span>
													<cite class="pull-right"> <?= $type['name']?></cite>
												</div>
												<div class="item-content" id="extra-<?= $value['id']?>">
													<label>
														<span>Click</span>
														<select class="form-control" name="allow<?= $value['id']?>">
															<option value="1" <?= $value['click_allow'] == 1 ? 'selected' : ''?>><?= lang('allow')?></option>
															<option value="0" <?= $value['click_allow'] == 0 ? 'selected' : ''?>><?= lang('disallowance')?></option>
														</select>
													</label>
													<label>
														<span>Icon</span>
														<input class="form-control" name="icon<?= $value['id']?>" type="text" value="<?= $value['icon']?>">
													</label>
													<label>
														<span>Target</span>
														<select class="form-control" name="target<?= $value['id']?>">
															<option value="_self" <?= $value['target'] == '_self' ? 'selected' : ''?>>_self</option>
															<option value="_blank" <?= $value['target'] == '_blank' ? 'selected' : ''?>>_blank</option>
															<option value="_parent" <?= $value['target'] == '_parent' ? 'selected' : ''?>>_parent</option>
															<option value="_top" <?= $value['target'] == '_top' ? 'selected' : ''?>>_top</option>
														</select>
													</label>
													<button type="button" onclick="removeNes('<?= $value['id']?>')" class="btn btn-danger"><?= lang('remove')?></button>
												</div>
												<?php if (isset($value['child'])): ?>
													<ol class="dd-list">
														<?php foreach ($value['child'] as $key => $val): ?>
															<?php 
															$name = '';
															$alias = '';
															switch ($val['ingredient']) {
																case 1:
																$ingredient = $this->mcategory_translation->getData("category_name,category_alias",array('category_id' => $val['ingredient_id'],'language_code' => $language));
																if (!empty($ingredient)) {
																	$name = $ingredient['category_name'];
																	$alias = $ingredient['category_alias'];
																}
																break;
																case 2:
																$ingredient = $this->mpage_translation->getData("page_title,page_alias",array('page_id' => $val['ingredient_id'],'language_code' => $language));
																if (!empty($ingredient)) {
																	$name = $ingredient['page_title'];
																	$alias = $ingredient['page_alias'];
																}
																break;
																case 3:
																$ingredient_link = $this->mlink->getData("link",array('id' => $val['ingredient_id']));
																$ingredient_link_name = $this->mlink_translation->getData("link_name",array('link_id' => $val['ingredient_id'],'language_code' => $language));
																if (!empty($ingredient_link)) {
																	$alias = $ingredient_link['link'];
																}
																if (!empty($ingredient_link_name)) {
																	$name = $ingredient_link_name['link_name'];
																}
																break;
															}
															$type = $this->mmenu_detail->listIngredient($val['ingredient']);
															$checked = $val['click_allow'] == 1 ? 'checked="checked"' : '';
															?>
															<li class="dd-item dd3-item" id="nes-<?= $val['id']?>" data-id="<?= $val['id']?>">
																<div class="dd-handle dd3-handle">Drag</div>
																<div class="dd3-content" onclick="showExtra('<?= $val['id']?>')">
																	<span class="pull-left"> <?= $name?></span>
																	<cite class="pull-right"> <?= $type['name']?></cite>
																</div>
																<div class="item-content" id="extra-<?= $val['id']?>">
																	<label>
																		<span>Click</span>
																		<select class="form-control" name="allow<?= $val['id']?>">
																			<option value="1" <?= $val['click_allow'] == 1 ? 'selected' : ''?>><?= lang('allow')?></option>
																			<option value="0" <?= $val['click_allow'] == 0 ? 'selected' : ''?>><?= lang('disallowance')?></option>
																		</select>
																	</label>
																	<label>
																		<span>Icon</span>
																		<input class="form-control" name="icon<?= $val['id']?>" type="text" value="<?= $val['icon']?>">
																	</label>
																	<label>
																		<span>Target</span>
																		<select class="form-control" name="target<?= $val['id']?>">
																			<option value="_self" <?= $val['target'] == '_self' ? 'selected' : ''?>>_self</option>
																			<option value="_blank" <?= $val['target'] == '_blank' ? 'selected' : ''?>>_blank</option>
																			<option value="_parent" <?= $val['target'] == '_parent' ? 'selected' : ''?>>_parent</option>
																			<option value="_top" <?= $val['target'] == '_top' ? 'selected' : ''?>>_top</option>
																		</select>
																	</label>
																	<button type="button" onclick="removeNes('<?= $val['id']?>')" class="btn btn-danger"><?= lang('remove')?></button>
																</div>
															</li>
														<?php endforeach ?>
													</ol>
												<?php endif ?>
											</li>
										<?php endforeach ?>
									<?php endif ?>
								</ol>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>