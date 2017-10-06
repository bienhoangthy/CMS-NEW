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
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><i class="fa fa-flash"></i> <?= $myGroup['group_name']?> <small><?= lang('clickview')?></small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php if ($id == 1): ?>
              <h3 class="text-success"><?= lang('fullpermission')?></h3>
            <?php else: ?>
              <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                <?php if (!empty($listComponent)): ?>
                  <?php $i=1; ?>
                  <?php foreach ($listComponent as $key => $value): ?>
                    <?php $in = $i==1 ? "in" : '';$i++; ?>
                    <div class="panel">
                      <a class="panel-heading collapsed" role="tab" id="heading<?= $value['component'].$value['id']?>" data-toggle="collapse" data-parent="#accordion1" href="#collapse<?= $value['component'].$value['id']?>" aria-expanded="false" aria-controls="collapseTwo">
                        <h4 class="panel-title"><?= $value['component_name']?> <code><?= $value['component']?></code></h4>
                      </a>
                      <div id="collapse<?= $value['component'].$value['id']?>" class="panel-collapse collapse <?= $in?>" role="tabpanel" aria-labelledby="heading<?= $value['component']?>">
                        <div class="panel-body">
                          <?php $listAction = $this->maction->getQuery("","action_value like '".$value['component']."%'"); ?>
                          <?php if (!empty($listAction)): ?>
                            <?php foreach ($listAction as $key => $val): ?>
                              <?php $checked = $this->mpermission->permission($val['action_value'],$myGroup['id']) == true ? 'checked' : '' ?>
                              <div class="col-md-3 col-sm-3 col-xs-12">
                                <label>
                                  <input type="checkbox" class="js-switch change-check" name="<?= $val['action_name']?>" action-value="<?= $val['action_value']?>" group-id="<?= $myGroup['id']?>" <?= $checked?>/> <?= $val['action_name']?>
                                </label>
                              </div>
                            <?php endforeach ?>
                          <?php endif ?>
                        </div>
                      </div>
                    </div>
                  <?php endforeach ?>
                <?php endif ?>
              </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>