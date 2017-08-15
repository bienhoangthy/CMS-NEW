<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $title?></h3>
      </div>
      <div class="title_right hidden-xs">
        <ol class="breadcrumb pull-right">
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>"><?= lang('dashboard')?></a></li>
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>user"><?= lang('list')?></a></li>
          <li class="breadcrumb-item active"><?= $title?></li>
        </ol>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
              <div class="profile_img">
                <div id="crop-avatar">
                  <img class="img-responsive avatar-view" src="<?= $myUser['user_avatar'] != '' ? base_url().'/media/user/'.$myUser['user_folder'].'/'.$myUser['user_avatar'] : my_library::base_public().'admin/images/user.png'?>" alt="<?= $myUser['user_username']?>" title="<?= $myUser['user_fullname']?>" style="width: 220px;height: auto;">
                </div>
              </div>
              <h3><?= $myUser['user_fullname']?></h3>
              <ul class="list-unstyled user_data">
                <li><i class="fa fa-transgender user-profile-icon"></i>&nbsp; <?= $myUser['user_gender'] == 1 ? lang('men') : lang('women')?></li>
                <li><i class="fa fa-calendar user-profile-icon"></i> <?= $myUser['user_birthday']?></li>
                <li><i class="fa fa-map-marker user-profile-icon"></i>&nbsp;&nbsp; <?= $myUser['user_address']?></li>
                <li><i class="fa fa-mobile user-profile-icon"></i>&nbsp;&nbsp; <a href="tel:<?= $myUser['user_phone']?>"><?= $myUser['user_phone']?></a></li>
                <li><i class="fa fa-envelope-o user-profile-icon"></i> <a href="mailto:<?= $myUser['user_email']?>"><?= $myUser['user_email']?></a></li>
              </ul>
              <a href="<?= my_library::admin_site().'user/edit/'.$myUser['id']?>" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i><?= lang('edit').' '.lang('profile')?></a>
              <br />
            </div>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                  <li role="presentation" class="active"><a href="#info" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><?= lang('laborinfo')?></a>
                  </li>
                  <li role="presentation" class=""><a href="#pass" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><?= lang('changepassword')?></a>
                  </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="info" aria-labelledby="profile-tab">
                    <?php 
                      $group = $this->mgroup->getData('group_name',array('id' => $myUser['user_group']));
                      $group_name = !empty($group) ? $group['group_name'] : 'Không xác định';
                      $department_name = $this->muser->listDepartment($myUser['user_department']);
                      $status = $this->muser->listStatusName($myUser['user_status']);
                      $userCreate = $this->muser->getData("id,user_username","id = ".$myUser['user']);
                     ?>
                    <table class="countries_list">
                      <tbody>
                        <tr>
                          <td><h4>Username</h4></td>
                          <td class="text-left"><h4><code><?= $myUser['user_username']?></code></h4></td>
                        </tr>
                        <tr>
                          <td><h4><?= lang('groupuser')?></h4></td>
                          <td class="text-left"><span class="label label-primary"><?= $group_name?></span></td>
                        </tr>
                        <tr>
                          <td><h4><?= lang('depertment')?></h4></td>
                          <td class="text-left"><span class="label label-primary"><?= $department_name['name']?></span></td>
                        </tr>
                        <tr>
                          <td><h4><?= lang('status')?></h4></td>
                          <td class="text-left"><span class="label label-<?= $status['color']?>"><?= $status['name']?></span></td>
                        </tr>
                        <tr>
                          <td><h4><?= lang('craetedate')?></h4></td>
                          <td class="text-left"><?= $myUser['user_createdate']?></td>
                        </tr>
                        <tr>
                          <td><h4><?= lang('lastlogin')?></h4></td>
                          <td class="text-left"><?= $myUser['user_updatedate']?></td>
                        </tr>
                        <tr>
                          <td><h4>User <?= lang('edit')?></h4></td>
                          <td class="text-left"><?= !empty($userCreate) ? lang('by').' <a href="'.my_library::admin_site().'user/profile/'.$userCreate['id'].'">'.$userCreate['user_username'].'</a>' : ''?></td>
                        </tr>
                        <tr>
                          <td><h4><?= lang('intro')?></h4></td>
                          <td class="text-left"><cite title="Source Title"><?= $myUser['user_introduction']?></cite></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="pass" aria-labelledby="profile-tab">
                    <form class="form-horizontal form-label-left" novalidate method="post">
                      <input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
                      <div class="form-group">
                        <label for="old_password" class="control-label col-md-3"><?= lang('currentpass')?></label>
                        <div class="col-md-6 col-sm-6 col-xs-12 item">
                          <input id="old_password" type="password" name="old_password" data-validate-length="6,8" class="form-control col-md-7 col-xs-12" required="required">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="new_password" class="control-label col-md-3"><?= lang('newpass')?></label>
                        <div class="col-md-6 col-sm-6 col-xs-12 item">
                          <input id="new_password" type="password" name="new_password" data-validate-length="6,8" class="form-control col-md-7 col-xs-12" required="required">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="renew_password" class="control-label col-md-3 col-sm-3 col-xs-12"><?= lang('retype')?></label>
                        <div class="col-md-6 col-sm-6 col-xs-12 item">
                          <input id="renew_password" type="password" name="renew_password" data-validate-linked="new_password" class="form-control col-md-7 col-xs-12" required="required">
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="submit" class="btn btn-success"><?= lang('save')?></button>
                          <button type="reset" class="btn btn-primary"><?= lang('reset')?></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>