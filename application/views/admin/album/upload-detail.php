<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $title?> <a href="<?= my_library::admin_site()?>album"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-list"></i> <?= lang('list')?></button></a> <a href="<?= my_library::admin_site()?>album/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('albumadd')?></button></a></h3>
      </div>
      <div class="title_right hidden-xs">
        <ol class="breadcrumb pull-right">
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>"><?= lang('dashboard')?></a></li>
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>album"><?= lang('list')?></a></li>
          <li class="breadcrumb-item active"><?= $title?></li>
        </ol>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?= lang('detailphoto').lang('of')?> album #<?= $id?> <a href="<?= my_library::admin_site()?>album/edit/<?= $id?>"><button type="button" class="btn btn-default"><?= lang('albumedit')?></button></a></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form method="post" enctype="multipart/form-data" action="<?= my_library::admin_site()?>album/uploadAction">
              <input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
              <input type="hidden" name="id" value="<?= $id?>">
              <input type="file" name="userfile[]" multiple>
              <br>
              <button type="submit" class="btn btn-success"><i class="fa fa-cloud-upload"></i> <?= lang('upload')?></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>