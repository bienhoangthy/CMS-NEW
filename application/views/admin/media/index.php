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
      <iframe src="<?= my_library::base_public()?>elfinder/elfinder.html" style="width: 100%; height: 500px;border: none;"></iframe>
    </div>
  </div>
</div>