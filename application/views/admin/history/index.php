<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $title?> </h3>
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
            <div class="">
              <form class="form-horizontal form-label-left" method="get">
                <div class="form-group">
                  <div class="col-md-3 col-sm-4 col-xs-6">
                    <select class="form-control" name="fuser" onchange="this.form.submit()">
                      <?= $fuser?>
                    </select>
                  </div>
                  <div class="col-md-3 col-sm-4 col-xs-6">
                    <select class="form-control" name="fgroup" onchange="this.form.submit()">
                      <?= $fgroup?>
                    </select>
                  </div>
                  <div class="col-md-3 col-sm-4 col-xs-6">
                    <select class="form-control" name="fdepartment" onchange="this.form.submit()">
                      <?= $fdepartment?>
                    </select>
                  </div>
                  <input type="hidden" name="page" value="<?= $page?>">  
                  <button type="button" class="btn btn-danger clear-all"><i class="fa fa-trash-o"></i> <?= lang('clearall')?></button>
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
                      <th width="5%">
                        <input type="checkbox" id="check-all" class="flat">
                      </th>
                      <th width="10%" class="column-title"></th>
                      <th width="15%" class="column-title"><?= lang('user')?> </th>
                      <th width="12%" class="column-title"><?= lang('group')?> </th>
                      <th width="12%" class="column-title"><?= lang('department')?> </th>
                      <th width="11%" class="column-title text-center">IP </th>
                      <th width="10%" class="column-title text-center"><?= lang('time')?> </th>
                      <th width="15%" class="column-title"><?= lang('browser')?> </th>
                      <th width="10%" class="column-title"><?= lang('os')?> </th>
                      <th class="bulk-actions" colspan="8">
                        ( <span class="action-cnt"> </span> )
                        <button type="submit" class="btn btn-danger btn-xs antoo" onclick="return confirm_delete_all();" name="fsubmit" style="margin-bottom: -2px;"><?= lang('deleteall')?></button>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($list)): ?>
                      <?php foreach ($list as $value): ?>
                        <?php 
                        $user = $this->muser->getData("id,user_fullname,user_avatar,user_folder",array('id' => $value['history_user_id']));
                        if ($user) {
                          if ($user['user_avatar'] != '') {
                            $avatar_user = base_url().'media/user/'.$user['user_folder'].'/thumb-'.$user['user_avatar'];
                          } else {
                            $avatar_user = my_library::base_public().'admin/images/user.png';
                          }
                          $myUser = '<a href="'.my_library::admin_site().'user/profile/'.$user['id'].'" target="_blank">'.$user['user_fullname'].'</a>';
                        } else {
                          $avatar_user = my_library::base_public().'admin/images/user.png';
                          $myUser = lang('someone');
                        }
                        $group = $this->mgroup->getData("group_name",array('id' => $value['history_group']));
                        $group_name = $group['group_name'] ?? '';
                        $department = $this->muser->listDepartment($value['history_department']);
                        $department_name = $department['name'] ?? '';
                        ?>
                        <tr class="showacction">
                          <td width="5%" class="a-center">
                            <input type="checkbox" class="flat" value="<?= $value['id']?>" name="table_records[]">
                          </td>
                          <td width="10%"><img src="<?= $avatar_user?>" class="avatar" style="width: 40px;height: auto;" alt="avatar"></td>
                          <td width="15%"><?= $myUser?></td>
                          <td width="12%"><?= $group_name?></td>
                          <td width="12%"><?= $department_name?></td>
                          <td width="11%" class="text-center"><code><?= $value['history_ip']?></code></td>
                          <td width="10%" class="text-center"><?= date("H:i:s <\\b\\r> Y-m-d",strtotime($value['history_time']))?></td>
                          <td width="15%"><?= $value['history_agent']?></td>
                          <td width="10%"><?= $value['history_platform']?></td>
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