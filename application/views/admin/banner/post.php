<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $title?> <a href="<?= my_library::admin_site()?>banner"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-list"></i> <?= lang('list')?></button></a> <?php if (isset($id)): ?><a href="<?= my_library::admin_site()?>banner/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('banneradd')?></button></a></h3><?php endif ?>
      </div>
      <div class="title_right hidden-xs">
        <ol class="breadcrumb pull-right">
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>"><?= lang('dashboard')?></a></li>
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>banner"><?= lang('list')?></a></li>
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
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-xs-12" style="text-align: left !important;" for="banner_title"><?= lang('bannertitle')?><span class="required">*</span>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12 item">
                  <input id="banner_title" class="form-control col-md-7 col-xs-12" maxlength="80" name="banner_title" required="required" type="text" value="<?= $formDataLang['banner_title']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important;" for="banner_description"><?= lang('description')?>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <textarea name="banner_description" style="width: 100%;" rows="5"><?= $formDataLang['banner_description']?></textarea>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-xs-12" style="text-align: left !important;" for="banner_link">Link
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <input id="banner_link" class="form-control col-md-7 col-xs-12" name="banner_link" type="text" value="<?= $formData['banner_link']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-xs-12" style="text-align: left !important;" for="banner_type"><?= lang('type')?>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <select class="form-control" id="banner_type" name="banner_type">
                    <?= $type?>
                  </select>
                </div>
              </div>
              <div class="content-type" style="border: dashed 1px green;margin-left: 10px;margin-right: 10px;">
                <div class="form-group" id="type1" style="display: none;">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="banner_picture"><?= lang('chooseimg')?>
                  </label>
                  <div class="col-md-10 col-sm-10 col-xs-12">
                    <input type="file" name="banner_picture" accept="image/*" style="margin-top: 6px;">
                  </div>
                </div>
                <div class="form-group" id="type2" style="display: none;margin-top: 10px;">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="banner_html">Html
                  </label>
                  <div class="col-md-10 col-sm-10 col-xs-12">
                    <textarea name="banner_html" style="width: 100%;" rows="3"></textarea>
                  </div>
                </div>
                <div class="form-group" id="type3" style="display: none;margin-top: 10px;">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="banner_iframe">Iframe
                  </label>
                  <div class="col-md-10 col-sm-10 col-xs-12">
                    <input class="form-control col-md-7 col-xs-12" name="banner_iframe" type="text" placeholder="Url...">
                  </div>
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
            <div class="x_content">
              <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="banner_position"><?= lang('position')?>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <select class="form-control" name="banner_position">
                    <?= $position?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="banner_orderby"><?= lang('orderby')?>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input id="banner_orderby" class="form-control" name="banner_orderby" type="number" value="<?= $formData['banner_orderby']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="banner_status"><?= lang('status')?><span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12" style="margin-top: 8px;">
                  <input type="radio" class="flat" name="banner_status" id="banner_status1" value="1" <?= $formData['banner_status'] == 1 ? 'checked="checked"' : '';?>/> <?= lang('active')?><br>
                  <input type="radio" class="flat" name="banner_status" id="banner_status2" value="2" <?= $formData['banner_status'] == 2 ? 'checked="checked"' : '';?>/> <?= lang('inactive')?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="banner_lang"><img src="<?= my_library::base_file().'language/flag_'.$langPost['lang_code'].'.png'?>" style="height: 20px; width: auto;">
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select class="form-control" name="banner_lang" onchange="alertChange('<?= $langPost['lang_code']?>');">
                    <?= $banner_lang?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12"><?= lang('translations')?>:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 8px;">
                  <?php if (!empty($listLanguage)): ?>
                    <?php foreach ($listLanguage as $key => $value): ?>
                      <?php if ($value['lang_code'] != $langPost['lang_code']): ?>
                        <?php 
                        if (isset($id) && $this->mbanner_translation->checkEditLang($id,$value['lang_code']) == true) {
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
      </form>
    </div>
  </div>
</div>