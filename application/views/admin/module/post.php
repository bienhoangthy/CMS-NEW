<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $title?></h3>
      </div>
      <div class="title_right hidden-xs">
        <ol class="breadcrumb pull-right">
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>"><?= lang('dashboard')?></a></li>
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>module"><?= lang('list')?></a></li>
          <li class="breadcrumb-item active"><?= $title?></li>
        </ol>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="alert alert-success alert-dismissible fade in" role="alert" style="width: 500px;max-width: 100%;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <cite><?= lang('editinglang').' "'.$langPost['lang_name'].'"'?></cite>
      </div>
      <form class="form-horizontal form-label-left" method="post" novalidate>
        <div class="col-md-8 col-sm-8 col-xs-12">
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="module_name"><?= lang('modulename')?><span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 item">
                  <input id="module_name" class="form-control col-md-7 col-xs-12" name="module_name" required="required" type="text" value="<?= $formDataLang['module_name']?>" placeholder="Dashboard">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="module_component">Component<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 item">
                  <select class="form-control" name="module_component">
                    <?= $component?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="module_action">Action<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 item">
                  <input id="module_action" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="module_action" required="required" type="text" value="<?= $formData['module_action']?>" placeholder="index">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="module_orderby"><?= lang('orderby')?><span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 item">
                  <input type="number" id="module_orderby" name="module_orderby" required="required" data-validate-length-range="1,2" class="form-control col-md-7 col-xs-12" value="<?= $formData['module_orderby']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="module_icon">Icon
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 item">
                  <input id="module_icon" class="form-control col-md-7 col-xs-12" name="module_icon" placeholder="fa-home" type="text" value="<?= $formData['module_icon']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Link icon
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 10px;">
                  <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="module_status"><?= lang('status')?><span class="required">*</span>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12" style="margin-top: 10px;">
                <?= lang('active')?> 
                  <input type="radio" class="flat" name="module_status" id="group_status1" value="1" <?= $formData['module_status'] == 1 ? 'checked="checked"' : '';?>/> -- <?= lang('inactive')?>
                  <input type="radio" class="flat" name="module_status" id="group_status2" value="2" <?= $formData['module_status'] == 2 ? 'checked="checked"' : '';?>/>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="text-center">
                *:<code><?= lang('requiredfields')?></code>
              </div>
            </div>
          </div>
        </div>  
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2><?= lang('language')?></h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="module_lang"><img src="<?= my_library::base_file().'language/flag_'.$langPost['lang_code'].'.png'?>" style="height: 20px; width: auto;">
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="module_lang" onchange="alertChange('<?= $langPost['lang_code']?>');">
                    <?= $module_lang?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="module_lang"><?= lang('translations')?>:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 8px; margin-left: 10px;">
                  <?php if (!empty($listLanguage)): ?>
                    <?php foreach ($listLanguage as $key => $value): ?>
                      <?php if ($value['lang_code'] != $langPost['lang_code']): ?>
                        <?php 
                          if (isset($id) && $this->mmodule_translation->checkEditLang($id,$value['lang_code']) == true) {
                            $icon = 'edit';$title = lang('edit').' '.$value['lang_name'];
                          } else {
                            $icon = 'plus-square-o';$title = lang('add').' '.$value['lang_name'];
                          }
                          
                         ?>
                        <a href="<?= current_url().'?lang='.$value['lang_code']?>" data-toggle="tooltip" data-placement="right" title="<?= $title?>"><i class="fa fa-<?= $icon?>"></i> <?= $value['lang_name']?></a><img src="<?= my_library::base_file().'language/flag_'.$value['lang_code'].'.png'?>" style="height: 15px; width: auto; margin-left: 5px;"><br>
                      <?php endif ?>
                    <?php endforeach ?>
                  <?php endif ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2><?= lang('moduleparent')?></h2>
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
                  <div class="radio">
                    <label>
                      <input type="radio" <?= $formData['module_parent'] == 0 ? 'checked' : ''?> class="flat" value="0" name="module_parent"> <b class="text-success">Admin Menu</b>
                    </label>
                  </div>
                  <?php if (!empty($myModule)): ?>
                    <?php foreach ($myModule as $key => $value): ?>
                      <div class="radio">
                        <label>
                          <input type="radio" <?= $formData['module_parent'] == $value['id'] ? 'checked' : ''?> class="flat" value="<?= $value['id']?>" name="module_parent"> <?= $value['module_name']?>
                        </label>
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