<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $title?></h3>
      </div>
      <div class="title_right hidden-xs">
        <ol class="breadcrumb pull-right">
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>"><?= lang('dashboard')?></a></li>
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>category"><?= lang('list')?></a></li>
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
      <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Cropper</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <button type="button" class="btn btn-primary" data-target="#modal" data-toggle="modal">
              Launch the demo
            </button>
          </div>
        </div>
      </div> 
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="docs-preview clearfix">
          <div class="img-preview preview-lg" style="width: 160px;height: 90px;overflow: hidden;"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Image modal -->
<div class="modal fade" id="modal" role="dialog" aria-labelledby="modalLabel" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #27ae60;">
        <h5 class="modal-title" style="color: #fff;"><i class="fa fa-picture-o fa-lg"></i> <?= lang('image')?></h5>
      </div>
      <div class="modal-body">
        <!-- <label class="control-label col-md-2 col-sm-2 col-xs-12">Ảnh mới</label> -->
        <label class="btn btn-success btn-upload btn-lg" for="inputImage" title="<?= lang('chooseimg')?>"><?= lang('chooseimg')?>
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
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>