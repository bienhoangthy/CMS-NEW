<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?> <a href="<?= my_library::admin_site()?>news/index/<?= $state?>"><button type="button" class="btn btn-<?= $stateData['color']?> btn-xs"><i class="fa fa-list"></i> <?= lang('listsingle').$stateData['name']?></button></a> <a href="<?= my_library::admin_site()?>news/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('newsadd')?></button></a></h3>
			</div>
			<div class="title_right hidden-xs">
				<ol class="breadcrumb pull-right">
					<li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>"><?= lang('dashboard')?></a></li>
					<li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>news"><?= lang('list')?></a></li>
					<li class="breadcrumb-item active"><?= $title?></li>
				</ol>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-9 col-sm-9 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2><?= $myNews_lang['news_title']?> <img src="<?= my_library::base_file().'language/flag_'.$langPost['lang_code'].'.png'?>" style="max-width: 20px;height: auto;"></h2>
						<div class="pull-right">
							<a href="<?= my_library::admin_site()?>news/edit/<?= $id.'?lang='.$langPost['lang_code']?>"><button type="button" class="btn btn-dark"><i class="fa fa-edit"></i> <?= lang('edit')?></button></a>
							<?php $backUrl = '?r='.base64_encode(current_url());
							switch ($state) {
								case 1:
								echo '<a href="'.my_library::admin_site().'news/pending/'.$id.$backUrl.'"><button type="button" class="btn btn-primary"><i class="fa fa-long-arrow-right"></i> '.lang('pending').'</button></a><a href="javascript:;" onclick="confirm_delete('.$id.')"><button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> '.lang('delete').'</button></a>';
								break;
								case 2:
								echo '<a href="'.my_library::admin_site().'news/draft/'.$id.$backUrl.'"><button type="button" class="btn btn-info"><i class="fa fa-long-arrow-left"></i> '.lang('draft').'</button></a><a href="'.my_library::admin_site().'news/publish/'.$id.$backUrl.'"><button type="button" class="btn btn-success"><i class="fa fa-long-arrow-right"></i> '.lang('publish').'</button></a><a href="javascript:;" onclick="confirm_delete('.$id.')"><button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> '.lang('delete').'</button></a>';
								break;
								case 3:
								echo '<a href="'.my_library::admin_site().'news/unpublish/'.$id.$backUrl.'"><button type="button" class="btn btn-primary"><i class="fa fa-long-arrow-left"></i> '.lang('pending').'</button></a>';
								break;
								default:
								echo '';
								break;
							}
							?>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<?php $myCategory = $this->mcategory_translation->getData("category_name",array('category_id' => $myNews['news_category'],'language_code' => $langPost['lang_code'])); ?>
						<?php if ($myCategory): ?>
							<a href="<?= my_library::admin_site().'category/edit/'.$myNews['news_category']?>" target="_blank"><span class="label label-success"><?= $myCategory['category_name']?></span></a>
						<?php endif ?>
						<?php if ($myNews['news_hot'] == 1): ?>
							<span class="label label-danger">Hot</span>
						<?php endif ?>
						<small><?php if ($myNews['news_publicdate'] != '0000-00-00 00:00:00'): ?><?= lang('publishdate')?>: <i class="fa fa-calendar"></i> <?= date("d-m-Y",strtotime($myNews['news_publicdate']))?> - <i class="fa fa-clock-o"></i> <?= date("H:i:s",strtotime($myNews['news_publicdate']))?> | <?php endif ?><?php if ($myNews['news_author'] != ''): ?><?= lang('author')?>: <i class="fa fa-user"></i> <?= $myNews['news_author']?> | <?php endif ?><?php if ($myNews['news_source'] != ''): ?><?= lang('source')?>: <i class="fa fa-recycle"></i> <?= $myNews['news_source']?> | <?php endif ?><?= lang('views')?>: <i class="fa fa-eye"></i> <?= $myNews['news_view']?></small>
						<blockquote>
							<cite title="Source Title"><?= $myNews_lang['news_summary']?></cite>
						</blockquote>
						<article class="news-content">
							<?= $myNews_lang['news_detail']?>
						</article>
						<div class="ln_solid"></div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h2><?= lang('tag')?></h2> <i class="fa fa-tags"></i>
							<?php if ($myNews['news_tag'] != ''): ?>
								<?php $tags = explode(',', $myNews['news_tag']); ?>
								<?php foreach ($tags as $value): ?>
									<?php if ($value != ''): ?>
										<span class="label label-info"><?= $value?></span>
									<?php endif ?>
								<?php endforeach ?>
							<?php endif ?>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
							<h2><?= lang('activitiesHistory')?></h2>
							<div class="x_content table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th width="50%"><?= lang('operations')?></th>
											<th width="15%"><?= lang('date')?></th>
											<th width="15%"><?= lang('time')?></th>
											<th width="20%">IP</th>
										</tr>
									</thead>
									<tbody>
										<?php if (!empty($listActivity)): ?>
											<?php foreach ($listActivity as $value): ?>
												<?php 
													$user = $this->muser->getData("id,user_fullname","id = ".$value['activity_user']);
													$fullname = $user['user_fullname'] ?? '';
													$action = $this->mactivity->listAction($value['activity_action']);
												 ?>
												<tr>
													<td><?= $fullname?> <i class="text-<?= $action['color']?>"><?= $action['name']?></i> <?= lang('news')?> #<?= $value['activity_id_com']?>.</td>
													<td><?= date("Y-m-d", strtotime($value['activity_datetime']))?></td>
													<td><?= date("H:i:s", strtotime($value['activity_datetime']))?></td>
													<td><?= $value['activity_ip']?></td>
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
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2><?= lang('typicalphoto')?></h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<?php if ($myNews['news_picture'] != ''): ?>
							<img src="<?= my_library::base_file().'news/'.$id.'/'.$myNews['news_picture']?>" alt="<?= lang('typicalphoto')?>" width="100%">
						<?php endif ?>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2><?= lang('infonews')?></h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table class="table table-hover">
							<tbody>
								<tr>
									<td><b><?= lang('language')?></b></td>
									<td>
										<?php foreach ($listLanguage as $vallang): ?>
											<a href="<?= current_url().'?lang='.$vallang['language_code']?>"><img src="<?= my_library::base_file().'language/flag_'.$vallang['language_code'].'.png'?>" style="max-width: 20px;height: auto;"></a>
										<?php endforeach ?>
									</td>
								</tr>
								<tr>
									<td><b><?= lang('type')?></b></td>
									<td><?= $type['name']?> <i class="fa <?= $type['icon']?>"></i></td>
								</tr>
								<tr>
									<td><b><?= lang('layout')?></b></td>
									<td><?= $layout['name']?></td>
								</tr>
								<tr>
									<td><b><?= lang('state')?></b></td>
									<td><span class="label label-<?= $stateData['color']?>"><?= $stateData['name']?></span></td>
								</tr>
								<tr>
									<td><b><?= lang('status')?></b></td>
									<td><span class="label label-<?= $status['color']?>"><?= $status['name']?></span></td>
								</tr>
								<tr>
									<td><b><?= lang('orderby')?></b></td>
									<td><span class="badge bg-green"><?= $myNews['news_orderby']?></span></td>
								</tr>
								<tr>
									<td><b><?= lang('craetedate')?></b></td>
									<td><?= $myNews['news_createdate']?></td>
								</tr>
								<tr>
									<td><b><?= lang('updatedate')?></b></td>
									<td><?= $myNews['news_updatedate']?></td>
								</tr>
								<tr>
									<td><b><?= lang('password')?></b></td>
									<?php if ($myNews['news_password'] == ''): ?>
										<td><span class="badge bg-red"><?= lang('no')?></span></td>
									<?php else: ?>
										<td><span class="badge bg-green"><?= lang('yes')?></span></td>
									<?php endif ?>
								</tr>
								<tr>
									<td><b><?= lang('user')?></b></td>
									<td><?= $user_fullname?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>