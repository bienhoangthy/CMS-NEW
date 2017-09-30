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
      <form class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" novalidate>
        <div class="col-md-7 col-sm-7 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2><?= lang('baseinfo')?></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_fullname"><?= lang('fullname')?><span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 item">
                  <input id="user_fullname" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="user_fullname" required="required" type="text" value="<?= $formData['user_fullname']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_gender"><?= lang('gender')?><span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 5px;">
                  <p>
                    <?= lang('men')?> 
                    <input type="radio" class="flat" name="user_gender" id="user_gender1" value="1" <?= $formData['user_gender'] == 1 ? 'checked="checked"' : '';?> /> -- <?= lang('women')?> 
                    <input type="radio" class="flat" name="user_gender" id="user_gender2" value="2" <?= $formData['user_gender'] == 2 ? 'checked="checked"' : '';?> />
                  </p>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_birthday"><?= lang('birthday')?><span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 item">
                  <input type="text" id="user_birthday" data-provide="datepicker" data-date-format="yyyy/mm/dd" name="user_birthday" required="required" class="form-control col-md-7 col-xs-12" value="<?= $formData['user_birthday']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_email">Email<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 item">
                  <input type="email" id="user_email" name="user_email" required="required" class="form-control col-md-7 col-xs-12" value="<?= $formData['user_email']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_phone"><?= lang('phone')?><span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 item">
                  <input type="number" id="user_phone" name="user_phone" required="required" data-validate-length-range="10,11" class="form-control col-md-7 col-xs-12" value="<?= $formData['user_phone']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_address"><?= lang('address')?><span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 item">
                  <input id="user_address" class="form-control col-md-7 col-xs-12" name="user_address" required="required" type="text" value="<?= $formData['user_address']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12 item" for="user_department"><?= lang('depertment')?><span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="user_department">
                    <?= $user_department?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_introduction"><?= lang('intro')?> </label>
                <div class="col-md-6 col-sm-6 col-xs-12 item">
                  <textarea id="user_introduction" name="user_introduction" class="form-control col-md-7 col-xs-12"><?= $formData['user_introduction']?></textarea>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="text-center">
                *:<code><?= lang('requiredfields')?></code>
              </div>
            </div>
          </div>
        </div>  
        <div class="col-md-5 col-sm-5 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2><?= lang('account')?> CMS</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_username">Username<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 item">
                  <input id="user_username" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="user_username" required="required" type="text" value="<?= $formData['user_username']?>" <?= $action == 2 ? 'disabled="disabled"' : ''?>>
                </div>
              </div>
              <?php $disabled = ''; ?>
              <?php if ($action == 2): ?>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 item">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="flat" name="checkchangePass" value="1" id="changepass"> <?= lang('changepassword')?>
                    </label>
                  </div>
                </div>
              </div> 
              <?php $disabled = 'disabled="disabled"'; ?>
              <?php endif ?>
              <div class="form-group">
                <label for="user_password" class="control-label col-md-3">Password<span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12 item">
                  <input id="user_password" type="password" name="user_password" data-validate-length="6,8" class="form-control col-md-7 col-xs-12 pass" required="required" <?= $disabled?>>
                </div>
              </div>
              <div class="form-group">
                <label for="re-password" class="control-label col-md-3 col-sm-3 col-xs-12">R-Password<span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12 item">
                  <input id="re-password" type="password" name="re-password" data-validate-linked="user_password" class="form-control col-md-7 col-xs-12 pass" required="required" <?= $disabled?>>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12 item" for="user_group"><?= lang('groupuser')?><span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="user_group">
                    <?= $user_group?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_status"><?= lang('status')?><span class="required">*</span>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12" style="margin-top: 5px;">
                <?= lang('active')?> 
                  <input type="radio" class="flat" name="user_status" id="user_gender1" value="1" <?= $formData['user_status'] == 1 ? 'checked="checked"' : '';?>/> -- <?= lang('inactive')?>
                  <input type="radio" class="flat" name="user_status" id="user_gender2" value="2" <?= $formData['user_status'] == 2 ? 'checked="checked"' : '';?>/>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_avatar"><?= lang('avatar')?> </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <img src="<?= $formData['user_avatar'] != '' ? $formData['user_avatar'] : my_library::base_public().'admin/images/user.png'?>" id="showavatar" alt="avatar" style="max-height: 100px;width: auto; margin-top: 10px;margin-bottom: 5px;">
                  <input type="file" id="uploadavatar" name="user_avatar" accept="image/*">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group pull-right">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
            <button type="submit" class="btn btn-success"><?= lang('save')?></button>
            <button type="reset" class="btn btn-primary"><?= lang('reset')?></button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>