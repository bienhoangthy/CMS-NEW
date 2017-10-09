<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $title?> <a href="<?= my_library::admin_site()?>special_content"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-list"></i> <?= lang('list')?></button></a></h3>
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
        <div class="x_panel">
          <div class="x_title">
            <div class="">
              <form class="form-horizontal form-label-left" method="get">
                
              </form>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="table-responsive">
              <form method="post">
                <input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
                <table class="table table-striped jambo_table bulk_action">
                  <thead>
                    <tr class="headings">
                      <th>
                        <input type="checkbox" id="check-all" class="flat">
                      </th>
                      <th class="column-title">Tên bài viết</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="showacction">
                      <td class="a-center ">
                        <input type="checkbox" class="flat" value="1" name="table_records[]">
                      </td>
                      <td><code>Test</code></td>
                    </tr>
                  </tbody>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <div class="">
              <form class="form-horizontal form-label-left" method="get">
                
              </form>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="table-responsive">
              <form method="post">
                <input type="hidden" name="<?= $token_name?>" value="<?= $token_value?>">
                <table class="table table-striped jambo_table bulk_action">
                  <thead>
                    <tr class="headings">
                      <th>
                        <input type="checkbox" id="check-all" class="flat">
                      </th>
                      <th class="column-title">Tên bài viết</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="showacction">
                      <td class="a-center ">
                        <input type="checkbox" class="flat" value="1" name="table_records[]">
                      </td>
                      <td><code>Test</code></td>
                    </tr>
                  </tbody>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>