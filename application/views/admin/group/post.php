<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $title?></h3>
      </div>
      <div class="title_right hidden-xs">
        <ol class="breadcrumb pull-right">
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>"><?= lang('dashboard')?></a></li>
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>group"><?= lang('list')?></a></li>
          <li class="breadcrumb-item active"><?= $title?></li>
        </ol>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <form class="form-horizontal form-label-left" method="post" novalidate>
        <div class="col-md-7 col-sm-7 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2><?= lang('groupinfo')?></h2>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="group_name"><?= lang('groupname')?><span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 item">
                  <input id="group_name" class="form-control col-md-7 col-xs-12" name="group_name" required="required" type="text" value="<?= $formData['group_name']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="group_status"><?= lang('status')?><span class="required">*</span>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12" style="margin-top: 5px;">
                <?= lang('active')?> 
                  <input type="radio" class="flat" name="group_status" id="group_status1" value="1" <?= $formData['group_status'] == 1 ? 'checked="checked"' : '';?>/> -- <?= lang('inactive')?>
                  <input type="radio" class="flat" name="group_status" id="group_status2" value="2" <?= $formData['group_status'] == 2 ? 'checked="checked"' : '';?>/>
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
              <h2><?= lang('moduleview')?></h2>
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
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <?php if (!empty($myModule)): ?>
                    <?php foreach ($myModule as $key => $value): ?>
                       <?php $check = is_array($formData['group_module']) && in_array($value['id'],$formData['group_module']) ? 'checked' : '' ?>
                      <div class="">
                        <label>
                          <input type="checkbox" name="module[]" class="js-switch change-check" id="<?= $value['id']?>" value="<?= $value['id']?>" <?= $check?> /> <?= $value['module_name']?>
                        </label>
                        <?php if (isset($value['submodule'])): ?>
                          <?php foreach ($value['submodule'] as $key => $val): ?>
                            <?php $check = is_array($formData['group_module']) && in_array($val['id'],$formData['group_module']) ? 'checked' : '' ?>
                            <div style="margin-left: 30px;">
                              <label>
                                <input type="checkbox" name="module[]" class="js-switch subcheck<?= $value['id']?> subchange" data-parent="<?= $value['id']?>" value="<?= $val['id']?>" <?= $check?> /> <?= $val['module_name']?>
                              </label>
                            </div>
                          <?php endforeach ?>
                        <?php endif ?>
                      </div>
                    <?php endforeach ?>
                  <?php endif ?>
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