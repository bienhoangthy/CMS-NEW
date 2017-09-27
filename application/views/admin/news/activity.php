<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?> <a href="<?= my_library::admin_site()?>news/index/<?= $state?>"><button type="button" class="btn btn-<?= $stateData['color']?> btn-xs"><i class="fa fa-list"></i> <?= lang('listsingle').$stateData['name']?></button></a> <a href="<?= my_library::admin_site().'news/review/'.$id?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> <?= lang('reviewed')?></button></a></h3>
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
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
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
</div>