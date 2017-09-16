<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?> <a href="<?= my_library::admin_site()?>news/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('newsadd')?></button></a></h3>
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
				<div class="x_panel" style="max-height: 150px;">
					<div class="x_title">
						<h3><?= $stateData['name']?> <small><?= lang('all')?>(<?= $record?>)</small></h3>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div id="wizard" class="form_wizard wizard_horizontal">
							<ul class="wizard_steps">
								<li>
									<a <?= $state == 1 ? '' : 'href="'.my_library::admin_site().'news/index/1" class="disabled"'?>>
										<span class="step_no"><i class="fa fa-file-code-o"></i></span>
										<span class="step_descr">
											<?= lang('draft')?>
										</span>
									</a>
								</li>
								<li>
									<a <?= $state == 2 ? '' : 'href="'.my_library::admin_site().'news/index/2" class="disabled"'?>>
										<span class="step_no"><i class="fa fa-edit"></i></span>
										<span class="step_descr">
											<?= lang('pending')?>
										</span>
									</a>
								</li>
								<li>
									<a <?= $state == 3 ? '' : 'href="'.my_library::admin_site().'news/index/3" class="disabled"'?>>
										<span class="step_no"><i class="fa fa-globe"></i></span>
										<span class="step_descr">
											<?= lang('publish')?>
										</span>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="">
							<form class="form-horizontal form-label-left" method="get">
								<div class="form-group">
									<div class="col-md-2 col-sm-2 col-xs-6">
										<div class="input-group">
											<input type="text" name="fkeyword" value="<?= $formData['fkeyword']?>" placeholder="<?= lang('search')?>" class="form-control">
											<span class="input-group-btn">
												<button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
											</span>
										</div>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<select class="form-control" name="fcategory" onchange="this.form.submit()">
											<?= $fcategory?>
										</select>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<select class="form-control" name="fstatus" onchange="this.form.submit()">
											<?= $fstatus?>
											<option <?= $formData['fstatus'] == 10 ? 'selected' : ''?> value="10">- <?= lang('hotnews')?></option>
										</select>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<select class="form-control" name="ftype" onchange="this.form.submit()">
											<?= $ftype?>
										</select>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<select class="form-control" name="forder" onchange="this.form.submit()">
											<option value=""><?= lang('orderby')?></option>
											<option <?= $formData['forder'] == 'latest' ? 'selected' : ''?> value="latest"><?= lang('latest')?></option>
											<option <?= $formData['forder'] == 'oldest' ? 'selected' : ''?> value="oldest"><?= lang('oldest')?></option>
											<option <?= $formData['forder'] == 'mostviewed' ? 'selected' : ''?> value="mostviewed"><?= lang('mostviewed')?></option>
											<option <?= $formData['forder'] == 'craetedate' ? 'selected' : ''?> value="craetedate"><?= lang('craetedate')?></option>
											<option <?= $formData['forder'] == 'publishdate' ? 'selected' : ''?> value="publishdate"><?= lang('publishdate')?></option>
											<option <?= $formData['forder'] == 'updatedate' ? 'selected' : ''?> value="updatedate"><?= lang('updatedate')?></option>
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
					<div class="x_content">
						<div class="table-responsive" style="overflow-x: unset;">
							<form method="post">
								<input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
								<table class="table table-striped jambo_table bulk_action">
									<thead>
										<tr class="headings">
											<th>
												<input type="checkbox" id="check-all" class="flat">
											</th>
											<th class="column-title" width="2%">ID</th>
											<th class="column-title" width="25%"><?= lang('title')?> </th>
											<th class="column-title"></th>
											<th class="column-title"><?= lang('category')?></th>
											<th class="column-title text-center"><?= lang('status')?> </th>
											<th class="column-title text-center">
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
											<th class="column-title"><?= lang('views')?> </th>
											<th class="column-title"><?= lang('updatedate')?> </th>
											<th class="bulk-actions" colspan="8">
												( <span class="action-cnt"> </span> )
												<button type="submit" class="btn btn-primary btn-xs antoo" style="margin-bottom: -2px;">Chuyển bài </button>
												<button type="submit" class="btn btn-info btn-xs antoo" style="margin-bottom: -2px;">Rút bài </button>
												<button type="submit" class="btn btn-danger btn-xs antoo" name="delAll" onclick="return confirm_delete_all();" style="margin-bottom: -2px;"><?= lang('deleteall')?></button>
											</th>
											<th width="10%"></th>
										</tr>
									</thead>
									<tbody>
										<?php if (!empty($list)): ?>
											<?php foreach ($list as $key => $value): ?>
												<?php 
												$picture = $value['news_picture'] != "" ? my_library::base_file().'news/'.$value['id'].'/thumb-'.$value['news_picture'] : my_library::base_public().'admin/images/image-not-found.jpg';
												$category = $this->mcategory_translation->getData("category_name",array('category_id' => $value['news_category'],'language_code' => $flanguage['lang_code']));
												$category_name = $category['category_name'] ?? '';
												$type = $this->mnews->listType($value['news_type']);
												$status = $this->mnews->listStatusName($value['news_status']);
												$linkEdit = my_library::admin_site().'news/edit/'.$value['id'].'?lang='.$flanguage['lang_code'];
												$linkView = base_url().$value['news_alias'].'-post'.$value['id'].'.html';
												$listLanguage = $this->mnews_translation->checkLanguage($value['id']);
												$userUpdate = $this->muser->getData("id,user_username","id = ".$value['user']);
												?>
												<tr class="showacction">
													<td class="a-center ">
														<input type="checkbox" class="flat" value="<?= $value['id']?>" name="table_records[]">
													</td>
													<td><?= $value['id']?></td>
													<td width="30%">
														<a href="<?= $linkView?>" target="_blank"><?= $value['news_title']?></a> - <i class="fa <?= $type['icon']?>" data-toggle="tooltip" data-placement="top" title="<?= $type['name']?>"></i>
													</td>
													<td><img src="<?= $picture?>" class="avatar" style="width: 40px;height: auto;" alt="picture"></td>
													<td><a href="<?= my_library::admin_site().'category/edit/'.$value['news_category']?>" target="_blank"><h5 style="font-weight: bold;" class="text-info"><?= $category_name?></h5></a></td>
													<td class="text-center">
														<span class="label label-<?= $status['color']?>"><?= $status['name']?></span><br>
														<?= $value['news_hot'] == 1 ? '<span class="label label-danger" data-toggle="tooltip" data-placement="top" title="'.lang('hotnews').'">Hot</span> ' : '' ?>
														<?= $value['news_password'] != '' ? '<span class="label label-default" data-toggle="tooltip" data-placement="top" title="'.lang('security').'"><i class="fa fa-key"></i></span>' : '' ?>
													</td>
													<td class="text-center">
														<?php foreach ($listLanguage as $key => $vallang): ?>
															<img src="<?= my_library::base_file().'language/flag_'.$vallang['language_code'].'.png'?>" style="max-width: 20px;height: auto;">
														<?php endforeach ?>
													</td>
													<td><span class="badge bg-green"><?= $value['news_view']?></span></td>
													<td><?= date("Y-m-d", strtotime($value['news_updatedate']))?><?= !empty($userUpdate) ? '<br>'.lang('by').' <a href="'.my_library::admin_site().'user/profile/'.$userUpdate['id'].'">'.$userUpdate['user_username'].'</a>' : ''?></td>
													<td width="10%">
														<div class="btn-group">
															<button data-toggle="dropdown" class="btn btn-dark dropdown-toggle btn-sm" type="button" aria-expanded="false"><?= lang('operations')?> <span class="caret"></span>
															</button>
															<ul role="menu" class="dropdown-menu" style="min-width: 0px;">
																<li><a href="<?= $linkEdit?>"><?= lang('edit')?></a></li>
																<li><a href="javascript:;" data-id="<?= $value['id']?>" class="show-extra"><?= lang('quickedit')?></a></li>
																<?php 
																	$backUrl = '?r='.base64_encode(current_url().$filter);
																	switch ($state) {
																		case 1:
																			$linkPending = my_library::admin_site().'news/pending/'.$value['id'].$backUrl;
																			echo '<li><a href="'.$linkPending.'" style="color: blue;">'.lang('pending').'</a></li>';
																			break;
																		case 2:
																			$linkPublish = my_library::admin_site().'news/publish/'.$value['id'].$backUrl;
																			echo '<li><a href="'.$linkPublish.'" style="color: green;">'.lang('publish').'</a></li>';
																			break;
																		case 3:
																			$linkUnpublish = my_library::admin_site().'news/unpublish/'.$value['id'].$backUrl;
																			echo '<li><a href="'.$linkUnpublish.'" style="color: red;">'.lang('unpublish').'</a></li>';
																			break;
																		default:
																			echo '';
																			break;
																	}
																 ?>
																<li><a href="<?= $linkView?>" target="_blank"><?= lang('reviewed')?></a></li>
																<?php if ($state != 3): ?>
																	<li><a href="javascript:;" onclick="confirm_delete(<?= $value['id']?>)" style="color: red;"><?= lang('delete')?></a></li>
																<?php endif ?>
															</ul>
														</div>
													</td>
												</tr>
												<tr class="edit" id="extra-<?= $value['id']?>">
													<td colspan="2">
														<span class="label label-success"><?= lang('quickedit')?></span><br>
														#<?= $value['id']?>
													</td>
													<td colspan="8">
														<div class="row" style="max-width: 100%;">
															<div class="col-md-5 col-sm-5">
																<div class="form-group">
											                        <label class="control-label col-md-4 col-sm-4"><?= lang('title')?></label>
											                        <div class="col-md-8 col-sm-8">
											                          <input type="text" class="form-control" value="<?= $value['news_title']?>">
											                        </div>
											                    </div>
											                    <div class="clearfix"></div>
											                    <div class="form-group" style="margin-top: 5px;">
											                        <label class="control-label col-md-4 col-sm-4">Alias</label>
											                        <div class="col-md-8 col-sm-8">
											                          <input type="text" class="form-control" value="<?= $value['news_alias']?>">
											                        </div>
											                    </div>
															</div>
															<div class="col-md-3 col-sm-3">
																<div class="form-group">
											                        <label class="control-label col-md-6 col-sm-6"><?= lang('views')?></label>
											                        <div class="col-md-6 col-sm-6">
											                          <input type="number" class="form-control" value="<?= $value['news_view']?>">
											                        </div>
											                    </div>
											                    <div class="clearfix"></div>
											                    <div class="form-group" style="margin-top: 5px;">
											                        <label class="control-label col-md-6 col-sm-6"><?= lang('orderby')?></label>
											                        <div class="col-md-6 col-sm-6">
											                          <input type="number" class="form-control" value="<?= $value['news_orderby']?>">
											                        </div>
											                    </div>
															</div>
															<div class="col-md-2 col-sm-2 ">
																<div class="radio" style="margin-top: 0px;">
										                            <label>
										                              <input type="radio" class="flat"<?= $value['news_status'] == 1 ? ' checked' : ''?> name="status<?= $value['id']?>"> <?= lang('active')?>
										                            </label>
										                        </div>
										                        <div class="radio">
										                            <label>
										                              <input type="radio" class="flat"<?= $value['news_status'] == 2 ? ' checked' : ''?> name="status<?= $value['id']?>"> <?= lang('inactive')?>
										                            </label>
										                        </div>
										                        <div style="margin-left: 20px;">
										                            <label>
										                              	<input type="checkbox" class="js-switch"<?= $value['news_hot'] == 1 ? ' checked' : ''?>/> Hot
										                            </label>
										                        </div>
															</div>
															<div class="col-md-2 col-sm-2 text-center">
																<button type="button" class="btn btn-success"><?= lang('save')?></button><br>
																<button type="button" class="btn btn-default" onclick="closeExtra(<?= $value['id']?>)"><?= lang('cancel')?></button>
															</div>
														</div>
													</td>
												</tr>
											<?php endforeach ?>
										<?php else: ?>
											<p class="text-danger"><?= lang('listempty')?></p>
										<?php endif ?>
									</tbody>
								</table>
							</form>
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