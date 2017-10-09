<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $title?> <a href="<?= my_library::admin_site()?>special_content"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-list"></i> <?= lang('list')?></button></a> <?php if (isset($id)): ?><a href="<?= my_library::admin_site()?>special_content/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('specialcontentadd')?></button></a><?php endif ?></h3>
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
        <div class="alert alert-success alert-dismissible fade in" role="alert" style="max-width: 100%;">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <cite><?= lang('editinglang').' "'.$langPost['lang_name'].'"'?></cite>
        </div>
      </div>
      <form class="form-horizontal form-label-left" method="post">
        <div class="col-md-6 col-sm-6 col-xs-12">
          <button type="reset" class="btn btn-primary pull-right"><?= lang('reset')?></button>
          <button type="submit" class="btn btn-success pull-right"><?= lang('save')?></button>
        </div>
        <input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
        <div class="clearfix"></div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <div class="form-group">
                <label class="control-label col-md-12 col-sm-12 col-xs-12" style="text-align: left !important;" for="sc_name"><img src="<?= my_library::base_file().'language/flag_'.$langPost['lang_code'].'.png'?>" class="img-input"> <?= lang('specialcontenttitle')?><span class="required">*</span>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12 item">
                  <input id="sc_name" class="form-control col-md-7 col-xs-12" maxlength="80" name="sc_name" required="required" type="text" value="<?= $formDataLang['sc_name']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-xs-12" style="text-align: left !important;" for="sc_description"><img src="<?= my_library::base_file().'language/flag_'.$langPost['lang_code'].'.png'?>" class="img-input"> <?= lang('description')?>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <textarea name="sc_description" style="width: 100%;"><?= $formDataLang['sc_description']?></textarea>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <label class="control-label col-md-12 col-sm-12 col-xs-12" style="text-align: left !important;" for="code_position"><?= lang('positioncode')?><span class="required">*</span>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12 item">
                  <input id="code_position" class="form-control col-md-7 col-xs-12" name="code_position" required="required" type="text" value="<?= $formData['code_position']?>">
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="special_content_lang"><img src="<?= my_library::base_file().'language/flag_'.$langPost['lang_code'].'.png'?>" style="height: 20px; width: auto;">
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <select class="form-control" name="special_content_lang" onchange="alertChange('<?= $langPost['lang_code']?>');">
                    <?= $special_content_lang?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= lang('translations')?>:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 8px;">
                  <?php if (!empty($listLanguage)): ?>
                    <?php foreach ($listLanguage as $value): ?>
                      <?php if ($value['lang_code'] != $langPost['lang_code']): ?>
                        <?php 
                        if (isset($id) && $this->mspecial_content_translation->checkEditLang($id,$value['lang_code']) == true) {
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
              <div class="ln_solid"></div>
              <div class="text-center">
                *:<code><?= lang('requiredfields')?></code>
              </div>
            </div>
          </div>
        </div> 
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sc_component">Component
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <select class="form-control" id="sc_component" name="sc_component">
                    <?= $component?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sc_category"><?= lang('category')?>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <select class="form-control" id="sc_category" name="sc_category">
                    <?= $category ?? '';?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sc_orderby"><?= lang('item')?>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <select class="form-control" name="sc_orderby">
                    <?= $orderby?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sc_quantity"><?= lang('quantity')?>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input id="sc_quantity" class="form-control" name="sc_quantity" type="number" value="<?= $formData['sc_quantity']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sc_cache">Cache
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <label style="margin-top: 5px;">
                    <input type="checkbox" name="sc_cache" value="1" class="js-switch"<?= $formData['sc_cache'] == 1 ? ' checked' : ''?>/>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sc_time_cache"><?= lang('cachetime')?>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input id="sc_time_cache" class="form-control" name="sc_time_cache" type="number" value="<?= $formData['sc_time_cache']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sc_status"><?= lang('status')?><span class="required">*</span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12" style="margin-top: 8px;">
                  <input type="radio" class="flat" name="sc_status" id="sc_status1" value="1" <?= $formData['sc_status'] == 1 ? 'checked="checked"' : '';?>/> <?= lang('active')?><br>
                  <input type="radio" class="flat" name="sc_status" id="sc_status2" value="2" <?= $formData['sc_status'] == 2 ? 'checked="checked"' : '';?>/> <?= lang('inactive')?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>