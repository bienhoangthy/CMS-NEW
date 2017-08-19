<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $title?> <a href="<?= my_library::admin_site()?>user/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('adduser')?></button></a></h3>
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
        <div class="x_panel">
          <div class="x_title">
            <ul class="nav navbar-left">
              <li class="pull-left"><p style="padding: 5px;"><?= lang('all')?> (<?= $record?>)</p></li>
            </ul>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="">
              <form class="form-horizontal form-label-left" method="get">
                <div class="form-group">
                  <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="input-group">
                      <input type="text" name="fkeyword" value="<?= $formData['fkeyword']?>" placeholder="<?= lang('search')?>" class="form-control">
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-4 col-xs-6">
                    <select class="form-control" name="fstatus" onchange="this.form.submit()">
                      <?= $fstatus?>
                    </select>
                  </div>
                  <div class="col-md-3 col-sm-4 col-xs-6">
                    <select class="form-control" name="fgroup" onchange="this.form.submit()">
                      <?= $fgroup?>
                    </select>
                  </div>
                  <input type="hidden" name="page" value="<?= $page?>">  
                </div>
              </form>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="table-responsive">
              <form method="post">
                <input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
                <table class="table table-striped jambo_table bulk_action">
                  <thead>
                    <tr class="headings">
                      <th>
                        <input type="checkbox" id="check-all" class="flat">
                      </th>
                      <th class="column-title" style="width: 200px;"><?= lang('fullname')?> </th>
                      <th class="column-title"></th>
                      <th class="column-title">Username </th>
                      <th class="column-title">Email - <?= lang('phone')?> </th>
                      <th class="column-title"><?= lang('groupuser')?> </th>
                      <th class="column-title"><?= lang('status')?> </th>
                      <th class="column-title"><?= lang('craetedate')?> </th>
                      <th class="bulk-actions" colspan="11">
                        <button type="submit" class="btn btn-danger btn-xs antoo" name="delAll" onclick="return confirm_delete_all();" style="margin-bottom: -2px;"><?= lang('deleteall')?> ( <span class="action-cnt"> </span> )</button>
                      </th>
                    </tr>
                  </thead>
                <tbody>
                  <?php if (!empty($list)): ?>
                    <?php foreach ($list as $key => $value): ?>
                      <?php 
                      $avatar = $value['user_avatar'] != "" ? my_library::base_file().'user/'.$value['user_folder'].'/thumb_'.$value['user_avatar'] : my_library::base_public().'admin/images/user.png';
                      $group = $this->mgroup->getData("group_name","id = ".$value['user_group']);
                      $status = $this->muser->listStatusName($value['user_status']);
                      $linkEdit = my_library::admin_site().'user/edit/'.$value['id'];
                      $linkProfile = my_library::admin_site().'user/profile/'.$value['id'];
                      $userCreate = $this->muser->getData("id,user_username","id = ".$value['user']);
                      ?>
                      <tr class="showacction">
                        <td class="a-center ">
                          <input type="checkbox" class="flat" value="<?= $value['id']?>" name="table_records[]">
                        </td>
                        <td><?= $value['user_fullname']?>
                          <div style="height: 20px;">
                            <div class="actionhover">
                              <a href="<?= $linkEdit?>" class="text-primary"><?= lang('edit')?></a> | <a href="<?= $linkProfile?>" class="text-success">Profile</a><?= $value['id'] > 1 ? ' | <a href="javascript:void(0)" onclick="confirm_delete('.$value['id'].')" class="text-danger">'.lang('delete').'</a>' : '';?>
                            </div>
                          </div>
                        </td>
                        <td><img src="<?= $avatar?>" class="avatar" alt="Avatar"></td>
                        <td><code><?= $value['user_username']?></code><br>ID: <?= $value['id']?></td>
                        <td><a href="mailto:<?= $value['user_email']?>"><?= $value['user_email']?></a><br><?= $value['user_phone']?></td>
                        <td><?= $group['group_name']?></td>
                        <td><span class="label label-<?= $status['color']?>"><?= $status['name']?></span></td>
                        <td><?= date("Y-m-d", strtotime($value['user_createdate']))?><?= !empty($userCreate) ? '<br>'.lang('by').' <a href="'.my_library::admin_site().'user/profile/'.$userCreate['id'].'">'.$userCreate['user_username'].'</a>' : ''?></td>
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
</div>