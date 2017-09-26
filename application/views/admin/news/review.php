<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?> <a href="<?= my_library::admin_site()?>news/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('newsadd')?></button></a></h3>
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
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							</li>
							<li><a class="close-link"><i class="fa fa-close"></i></a>
							</li>
						</ul>
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
						<small><?= lang('publishdate')?>: <i class="fa fa-calendar"></i> <?= date("d-m-Y",strtotime($myNews['news_publicdate']))?> - <i class="fa fa-clock-o"> </i><?= date("H:i:s",strtotime($myNews['news_publicdate']))?><?php if ($myNews['news_author'] != ''): ?> | <?= lang('author')?>: <i class="fa fa-user"></i> <?= $myNews['news_author']?><?php endif ?><?php if ($myNews['news_source'] != ''): ?> | <?= lang('source')?>: <i class="fa fa-recycle"></i> <?= $myNews['news_source']?><?php endif ?> | <?= lang('views')?>: <i class="fa fa-eye"></i> <?= $myNews['news_view']?></small>
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
					</div>
				</div>
			</div>
		</div>
	</div>
</div>