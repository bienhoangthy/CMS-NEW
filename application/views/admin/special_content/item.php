<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $title?> <a href="<?= my_library::admin_site()?>special_content"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-list"></i> <?= lang('list')?></button></a></h3>
      </div>
      <div class="title_right hidden-xs">
        <ol class="breadcrumb pull-right">
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>"><?= lang('dashboard')?></a></li>
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>special_content"><?= lang('list')?></a></li>
          <li class="breadcrumb-item active"><?= $title?></li>
        </ol>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?= lang('listCom').$titleCom?> <small><?= lang('all')?>(<?= $record?>)</small></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="table-responsive">
              <form class="form-horizontal form-label-left" method="post">
                <input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
                <table class="table table-striped jambo_table bulk_action">
                  <thead>
                    <tr class="headings">
                      <th width="10%">
                        <input type="checkbox" id="check-all" class="flat">
                      </th>
                      <th class="column-title" width="10%">ID </th>
                      <th class="column-title" width="80%"><?= lang('name').$titleCom?> </th>
                      </th>
                      <th class="bulk-actions" colspan="7">
                        <a class="antoo" style="color:#fff; font-weight:500;">( <span class="action-cnt"> </span> )</a>
                        <button type="submit" class="btn btn-primary btn-xs" style="margin-bottom: 0;"><?= lang('addcontent')?></button>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($listItem)): ?>
                      <?php foreach ($listItem as $value): ?>
                        <tr class="even pointer">
                          <td class="a-center" width="10%">
                            <input type="checkbox" class="flat" value="<?= $value['id']?>" name="table_records[]">
                          </td>
                          <td width="10%"><?= $value['id']?></td>
                          <td width="80%"><?= $value['name']?></td>
                        </tr>
                      <?php endforeach ?>
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
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel" data-id="<?= $mySpecial_content['id']?>" id="listItem">
          <div class="x_title">
            <h2><?= lang('selectedlist')?> <small><?= lang('all')?>(<b class="text-primary count"><?= count($currentItem)?></b>/<?= $mySpecial_content['sc_quantity']?>)</small> <button type="button" class="btn btn-danger btn-xs delete-all-item"><?= lang('deleteall')?></button></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th width="10%">ID</th>
                  <th width="80%"><?= lang('name')?></th>
                  <th width="10%"><?= lang('delete')?></th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($currentItem)): ?>
                  <?php foreach ($currentItem as $val): ?>
                    <tr id="item<?= $val['id']?>">
                      <td width="10%"><?= $val['id']?></td>
                      <td width="80%"><?= $val['name']?></td>
                      <td width="10%"><button type="button" data-id-item="<?= $val['id']?>" class="btn btn-danger btn-xs delete-item"><i class="fa fa-close"></i></button></td>
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