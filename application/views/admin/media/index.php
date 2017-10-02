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
      <iframe  width="100%" height="650" frameborder="0"
        src="<?= my_library::base_public()?>filemanager/dialog.php?type=0&akey=e807f1fcf82d132f9bb018ca6738a19f">
      </iframe>
    </div>
  </div>
</div>