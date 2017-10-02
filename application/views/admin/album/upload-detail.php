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
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?= lang('add').lang('photo')?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form method="post" enctype="multipart/form-data" action="<?= my_library::admin_site()?>album/uploadAction">
              <input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
              <input type="hidden" name="id" value="<?= $id?>">
              <input type="file" name="userfile[]" multiple accept="image/*">
              <br>
              <button type="submit" class="btn btn-success"><i class="fa fa-cloud-upload"></i> <?= lang('upload')?></button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?= lang('detailphoto').lang('of')?> album #<?= $id?> <a href="<?= my_library::admin_site()?>album/edit/<?= $id?>"><button type="button" class="btn btn-default"><?= lang('albumedit')?></button></a></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php if (!empty($listPhotos)): ?>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th width="5%">#</th>
                    <th width="60%" class="text-center"><?= lang('listphoto')?></th>
                    <th width="30%"><?= lang('description')?></th>
                    <th width="5%"><?= lang('delete')?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($listPhotos as $value): ?>
                    <?php
                      $picture = $value['picture'] != "" ? my_library::base_file().'album/'.$id.'/'.$value['picture'] : my_library::base_public().'admin/images/image-not-found.jpg';
                     ?>
                    <tr class="showacction" id="photo<?= $value['id']?>">
                      <td width="5%"><p style="font-weight: bold;"><?= $value['id']?></p></td>
                      <td width="55%" class="text-center"><img src="<?= $picture?>" style="width: auto;height: 70px;border-radius: 2px;border: 1px solid #e6e6e6;box-shadow: 2px 0px 2px;" alt="picture"><br><code><?= $value['picture']?></code></td>
                      <td width="35%"><span id="name<?= $value['id']?>"><?= $value['description']?></span>
            						<div class="actionhover">
            							<a href="javascript:;" onclick="editDescription(<?= $value['id']?>)"><button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?= lang('edit').' '.lang('description')?>"><i class="fa fa-pencil"></i></button></a>
            						</div>
                      </td>
                      <td width="5%"><a href="javascript:;" onclick="deletePhoto(<?= $value['id']?>)"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></a></td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
              <?php if (isset($pagination)): ?>
                <ul class="pagination pull-right"><?= $pagination?></ul>
              <?php endif ?>
            <?php else: ?>
              <h4 class="text-danger"><?= lang('listempty')?></h4>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>