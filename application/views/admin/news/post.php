<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $title?></h3>
      </div>
      <div class="title_right hidden-xs">
        <ol class="breadcrumb pull-right">
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>"><?= lang('dashboard')?></a></li>
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>news"><?= lang('list')?></a></li>
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
      <form class="form-horizontal form-label-left" id="formNews" method="post" enctype="multipart/form-data" novalidate>
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-xs-12" style="text-align: left !important;" for="news_title"><?= lang('titlenews')?><span class="required">*</span>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12 item">
                  <input id="news_title" class="form-control col-md-7 col-xs-12" name="news_title" required="required" type="text" value="<?= $formDataLang['news_title']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-xs-12" style="text-align: left !important;" for="news_summary"><?= lang('summary')?>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <textarea style="width: 100%;" name="news_summary"><?= $formDataLang['news_summary']?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important;" for="news_detail"><?= lang('detail')?>
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <textarea name="news_detail" id="news_detail"><?= $formDataLang['news_detail']?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important;" for="news_seo_title">SEO Title
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <input id="news_seo_title" class="form-control col-md-7 col-xs-12" name="news_seo_title" type="text" value="<?= $formDataLang['news_seo_title']?>">
                  <p class="text-info well well-sm no-shadow">
                    <i class="fa fa-info-circle"></i> <?= lang('seotitle')?>
                  </p>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important;" for="news_seo_description">SEO Description
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <input id="news_seo_description" class="form-control col-md-7 col-xs-12" name="news_seo_description" type="text" value="<?= $formDataLang['news_seo_description']?>">
                  <p class="text-info well well-sm no-shadow">
                    <i class="fa fa-info-circle"></i> <?= lang('seodescription')?>
                  </p>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important;" for="news_seo_keyword">SEO Keyword
                </label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <input id="news_seo_keyword" class="form-control col-md-7 col-xs-12" name="news_seo_keyword" type="text" value="<?= $formDataLang['news_seo_keyword']?>">
                  <p class="text-info well well-sm no-shadow">
                    <i class="fa fa-info-circle"></i> <?= lang('seokeyword')?>
                  </p>
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
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="news_type"><?= lang('choosetype')?>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select class="form-control" name="news_type">
                    <?= $type?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="news_layout"><?= lang('layout')?>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select class="form-control" name="news_layout">
                    <?= $layout?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="news_view"><?= lang('views')?>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <input id="news_view" class="form-control" name="news_view" type="number" value="<?= $formData['news_view']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="news_orderby"><?= lang('orderby')?>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <input id="news_orderby" class="form-control" name="news_orderby" type="number" value="<?= $formData['news_orderby']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="news_orderby"><?= lang('hotnews')?>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <label style="margin-top: 5px;">
                    <input type="checkbox" name="news_hot" value="1" class="js-switch"<?= $formData['news_hot'] == 1 ? ' checked' : ''?>/>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="news_status"><?= lang('status')?><span class="required">*</span>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12" style="margin-top: 8px;">
                  <input type="radio" class="flat" name="news_status" id="news_status1" value="1" <?= $formData['news_status'] == 1 ? 'checked="checked"' : '';?>/> <?= lang('active')?><br>
                  <input type="radio" class="flat" name="news_status" id="news_status2" value="2" <?= $formData['news_status'] == 2 ? 'checked="checked"' : '';?>/> <?= lang('inactive')?>
                </div>
              </div>
            </div>
          </div>
        </div> 
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="news_category"><?= lang('category')?>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select class="form-control" name="news_category">
                    <?= $category?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="news_author"><?= lang('author')?>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <input id="news_author" class="form-control" name="news_author" type="text" value="<?= $formData['news_author']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="news_source"><?= lang('source')?>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <input id="news_source" class="form-control" name="news_source" type="text" value="<?= $formData['news_source']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="news_password"><?= lang('password')?>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <input id="news_password" class="form-control" name="news_password" type="text" value="<?= $formData['news_password']?>">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <div class="form-group">
                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="news_lang"><img src="<?= my_library::base_file().'language/flag_'.$langPost['lang_code'].'.png'?>" style="height: 20px; width: auto;">
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <select class="form-control" name="news_lang" onchange="alertChange('<?= $langPost['lang_code']?>');">
                    <?= $news_lang?>
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
                        if (isset($id) && $this->mnews_translation->checkEditLang($id,$value['lang_code']) == true) {
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
              <?php if ($formData['news_picture'] != ''): ?>
                <button type="button" class="btn btn-success btn-xs" data-target="#modal" data-toggle="modal">
                  <?= lang('editphoto')?>
                </button>
                <button type="button" id="button-delimg" class="btn btn-danger btn-xs" onclick="deleteImg(<?= $id?>)">
                  <?= lang('deletephoto')?>
                </button><br>
                <img src="<?= my_library::base_file().'news/'.$id.'/'.$formData['news_picture']?>" id="current-image" alt="<?= lang('typicalphoto')?>" style="width: 320px;height: 180px; margin-bottom: 10px;position: absolute;">
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
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2><?= lang('tag')?></h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="control-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <input id="tags_1" type="text" name="news_tag" class="tags form-control" value="<?= $formData['news_tag']?>" />
                  <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                </div>
              </div>
            </div>
          </div>
        </div> 
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="form-group pull-right">
            <input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
            <button type="submit" class="btn btn-success"><?= lang('save')?></button>
            <button type="reset" class="btn btn-primary"><?= lang('reset')?></button>
          </div>
        </div> 
      </form>
    </div>
  </div>
</div>

<!-- Image modal -->
<div class="modal fade" id="modal" role="dialog" aria-labelledby="modalLabel" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="width: 1000px;">
      <div class="modal-header" style="background-color: #27ae60;">
        <h5 class="modal-title" style="color: #fff;font-weight: bold;"><i class="fa fa-picture-o fa-lg"></i> <?= lang('image')?></h5>
      </div>
      <div class="modal-body">
        <label class="btn btn-success btn-upload btn-lg" for="inputImage" title="<?= lang('chooseimg')?>">
          <input type="file" class="sr-only" id="inputImage" name="file">
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