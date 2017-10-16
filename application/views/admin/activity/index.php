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
                    <select class="form-control" name="fcomponent" onchange="this.form.submit()">
                      <?= $fcomponent?>
                    </select>
                  </div>
                  <div class="col-md-3 col-sm-4 col-xs-6">
                    <select class="form-control" name="faction" onchange="this.form.submit()">
                      <?= $faction?>
                    </select>
                  </div>
                  <div class="col-md-3 col-sm-4 col-xs-6">
                    <select class="form-control" name="fuser" onchange="this.form.submit()">
                      <?= $fuser?>
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
                      <th width="20%" class="column-title"><?= lang('user')?> </th>
                      <th width="20%" class="column-title"><?= lang('activity')?> </th>
                      <th width="20%" class="column-title"><?= lang('object')?> </th>
                      <th width="15%" class="column-title text-center"><?= lang('time')?> </th>
                      <th width="10%" class="column-title text-center">IP </th>
                      <th class="bulk-actions" colspan="7">
                        ( <span class="action-cnt"> </span> )
                        <button type="submit" class="btn btn-danger btn-xs antoo" onclick="return confirm_delete_all();" name="fsubmit" style="margin-bottom: -2px;"><?= lang('deleteall')?></button>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($list)): ?>
                      <?php foreach ($list as $value): ?>
                        <?php 
                          $user = $this->muser->getData("id,user_fullname,user_avatar,user_folder",array('id' => $value['activity_user']));
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
                          $action = $this->mactivity->listAction($value['activity_action']);
                          $comname = '';
                          if ($language == 'english') {
                            $com = $this->mcomponent->getData("component",array('id' => $value['activity_component']));
                            $comname = ucfirst($com['component']);
                          } else {
                            $com = $this->mcomponent->getData("component,component_name",array('id' => $value['activity_component']));
                            $comname = $com['component_name'];
                          }
                        ?>
                        <tr class="showacction">
                          <td width="5%" class="a-center">
                            <input type="checkbox" class="flat" value="<?= $value['id']?>" name="table_records[]">
                          </td>
                          <td width="10%"><img src="<?= $avatar_user?>" class="avatar" style="width: 40px;height: auto;" alt="avatar"></td>
                          <td width="20%"><?= $myUser?></td>
                          <td width="20%"><i class="text-<?= $action['color']?>"><?= $action['name']?></i></td>
                          <td width="20%"><?= $comname?> "<a href="<?= my_library::admin_site().$com['component'].'/edit/'.$value['activity_id_com']?>" target="_blank">#<?= $value['activity_id_com']?></a>"</td>
                          <td width="15%" class="text-center"><?= date("H:i:s <\\b\\r> Y-m-d",strtotime($value['activity_datetime']))?></td>
                          <td width="10%" class="text-center"><code><?= $value['activity_ip']?></code></td>
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