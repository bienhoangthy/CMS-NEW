<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $title?></h3>
      </div>
      <div class="title_right hidden-xs">
        <ol class="breadcrumb pull-right">
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>"><?= lang('dashboard')?></a></li>
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>config"><?= lang('list')?></a></li>
          <li class="breadcrumb-item active"><?= $title?></li>
        </ol>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Logo <small><?= lang('notelogo')?></small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <form class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
            <div class="x_content">
              <div class="form-group">
                <img src="<?= my_library::base_file()?>logo/logo.png" id="showlogo" alt="logo" style="max-width: 100%;height: 70px;"><br>
                <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                  <input type="file" id="uploadlogo" name="logo" required="required" accept="image/*">
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="pull-right">
                <input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
                <button type="submit" class="btn btn-success"><?= lang('save')?></button>
                <button type="reset" class="btn btn-primary"><?= lang('reset')?></button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Favicon <small><?= lang('notefavicon')?></small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <form class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
            <div class="x_content">
              <div class="form-group">
                <img src="<?= base_url()?>favicon.ico" id="showfavicon" alt="favicon" style="max-width: 100%;height: 70px;"><br>
                <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                  <input type="file" id="uploadfavicon" name="favicon" required="required" accept="image/*">
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="pull-right">
                <input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
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