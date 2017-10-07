<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $title?> <a href="<?= my_library::admin_site()?>video"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-list"></i> <?= lang('list')?></button></a> <?php if (isset($id)): ?><a href="<?= my_library::admin_site()?>video/add"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> <?= lang('videoadd')?></button></a></h3><?php endif ?>
      </div>
      <div class="title_right hidden-xs">
        <ol class="breadcrumb pull-right">
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>"><?= lang('dashboard')?></a></li>
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>video"><?= lang('list')?></a></li>
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
      <form class="form-horizontal form-label-left" id="formVideo" method="post">
        <div class="col-md-6 col-sm-6 col-xs-12">
          <button type="reset" class="btn btn-primary pull-right"><?= lang('reset')?></button>
          <button type="submit" class="btn btn-success pull-right"><?= lang('save')?></button>
        </div>
        <input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-xs-12" style="text-align: left !important;" for="video_name"><img src="<?= my_library::base_file().'language/flag_'.$langPost['lang_code'].'.png'?>" class="img-input"> <?= lang('videoname')?><span class="required">*</span>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12 item">
                  <input id="video_name" class="form-control col-md-7 col-xs-12" maxlength="80" name="video_name" required="required" type="text" value="<?= $formDataLang['video_name']?>">
                </div>
              </div>
              <?php if (isset($formDataLang['video_alias']) && isset($id)): ?>
                <div class="form-inline" style="margin-left: 10px;">
                  <div class="form-group">
                    <label class="control-label" style="text-align: left !important;" for="video_alias"><img src="<?= my_library::base_file().'language/flag_'.$langPost['lang_code'].'.png'?>" class="img-input"> <?= lang('staticlink')?> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?= lang('autoinput')?>"></i>
                    </label><br>
                    <code><?= base_url()?></code>
                    <input type="text" class="form-control" id="video_alias" name="video_alias" value="<?= $formDataLang['video_alias']?>" style="max-width: 100%;width: 350px;">
                    <code>-video<?= $id?>.html</code>
                  </div>
                </div>
              <?php endif ?>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important;" for="video_description"><img src="<?= my_library::base_file().'language/flag_'.$langPost['lang_code'].'.png'?>" class="img-input"> <?= lang('description')?>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <textarea name="video_description" id="video_description"><?= $formDataLang['video_description']?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-xs-12" style="text-align: left !important;" for="video_link">Link<span class="required">*</span>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12 item">
                  <input id="video_link" class="form-control col-md-7 col-xs-12" name="video_link" required="required" type="text" value="<?= $formData['video_link']?>">
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
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="video_parent"><?= lang('category')?>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select class="form-control" name="video_parent">
                    <?= $category?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="video_view"><?= lang('views')?>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <input id="video_view" class="form-control" name="video_view" type="number" value="<?= $formData['video_view']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="video_orderby"><?= lang('orderby')?>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <input id="video_orderby" class="form-control" name="video_orderby" type="number" value="<?= $formData['video_orderby']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="video_hot"><?= lang('hot')?>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <label style="margin-top: 5px;">
                    <input type="checkbox" name="video_hot" value="1" class="js-switch"<?= $formData['video_hot'] == 1 ? ' checked' : ''?>/>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="video_status"><?= lang('status')?><span class="required">*</span>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12" style="margin-top: 8px;">
                  <input type="radio" class="flat" name="video_status" id="video_status1" value="1" <?= $formData['video_status'] == 1 ? 'checked="checked"' : '';?>/> <?= lang('active')?><br>
                  <input type="radio" class="flat" name="video_status" id="video_status2" value="2" <?= $formData['video_status'] == 2 ? 'checked="checked"' : '';?>/> <?= lang('inactive')?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="video_lang"><img src="<?= my_library::base_file().'language/flag_'.$langPost['lang_code'].'.png'?>" style="height: 20px; width: auto;">
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select class="form-control" name="video_lang" onchange="alertChange('<?= $langPost['lang_code']?>');">
                    <?= $video_lang?>
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
                        if (isset($id) && $this->mvideo_translation->checkEditLang($id,$value['lang_code']) == true) {
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
              <h2><?= lang('typicalphoto')?></h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <?php if ($formData['video_picture'] != ''): ?>
                <button type="button" class="btn btn-success btn-xs" data-target="#modal" data-toggle="modal">
                  <?= lang('editphoto')?>
                </button>
                <button type="button" id="button-delimg" class="btn btn-danger btn-xs" onclick="deleteImg(<?= $id?>)">
                  <?= lang('deletephoto')?>
                </button><br>
                <img src="<?= my_library::base_file().'video/'.$id.'/'.$formData['video_picture']?>" id="current-image" alt="<?= lang('typicalphoto')?>" style="width: 320px;height: 180px; margin-bottom: 10px;position: absolute;">
              <?php else: ?>
                <button type="button" class="btn btn-success btn-xs" data-target="#modal" data-toggle="modal">
                  <?= lang('addphoto')?>
                </button>
              <?php endif ?>
              <div class="docs-preview clearfix">
                <div class="img-preview preview-lg" style="width: 320px;height: 180px;overflow: hidden;"></div>
              </div>
            </div>
          </div>
        </div> 
      </form>
    </div>
  </div>
</div>

<!-- Image modal -->
<div class="modal fade" id="modal" role="dialog" aria-labelledby="modalLabel" tabindex="-1" style="z-index: 9999999;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="width: 1000px;">
      <div class="modal-header" style="background-color: #27ae60;">
        <h5 class="modal-title" style="color: #fff;font-weight: bold;"><i class="fa fa-picture-o fa-lg"></i> <?= lang('image')?></h5>
      </div>
      <div class="modal-body">
        <label class="btn btn-success btn-upload btn-lg" for="inputImage" title="<?= lang('chooseimg')?>">
          <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
          <span class="fa fa-upload"></span>
        </label>
        <div class="clearfix"></div>
        <div class="row" style="margin-top: 10px;">
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="image-wrapper" style="width: 100%;height: 431px;box-shadow: inset 0px 0px 1px 1px #888888;">
              <div class="img-container">
                <img id="image" src="#" style="max-width: 100%;">
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="docs-preview clearfix">
              <div class="img-preview preview-lg" style="width: 192px;height: 108px;overflow: hidden;background-color: #DDDDDD;margin-bottom: 5px;"></div>
              <div class="img-preview preview-md" style="width: 160px;height: 90px;overflow: hidden;background-color: #DDDDDD;margin-bottom: 5px;"></div>
              <div class="img-preview preview-sm" style="width: 80px;height: 45px;overflow: hidden;background-color: #DDDDDD;margin-bottom: 5px;"></div>
            </div>
            <div class="docs-data" style="margin-top: 23px;">
              <div class="input-group input-group-sm">
                <label class="input-group-addon" for="dataX">X</label>
                <input type="text" class="form-control" id="dataX" placeholder="x">
                <span class="input-group-addon">px</span>
              </div>
              <div class="input-group input-group-sm">
                <label class="input-group-addon" for="dataY">Y</label>
                <input type="text" class="form-control" id="dataY" placeholder="y">
                <span class="input-group-addon">px</span>
              </div>
              <div class="input-group input-group-sm">
                <label class="input-group-addon" for="dataWidth">Width</label>
                <input type="text" class="form-control" id="dataWidth" placeholder="width">
                <span class="input-group-addon">px</span>
              </div>
              <div class="input-group input-group-sm">
                <label class="input-group-addon" for="dataHeight">Height</label>
                <input type="text" class="form-control" id="dataHeight" placeholder="height">
                <span class="input-group-addon">px</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="save-image" class="btn btn-primary" disabled="disabled" data-dismiss="modal"><?= lang('drop')?></button>
        <button type="button" id="destroy-image" class="btn btn-default" data-dismiss="modal"><?= lang('cancel')?></button>
      </div>
    </div>
  </div>
</div>