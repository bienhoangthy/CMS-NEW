<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;text-align: center;">
            <a href="<?= my_library::admin_site()?>" class="site_title"><i class="fa fa-github"></i> <span>Admin <span class="text-success">CMS</span></span></a>
          </div>
          <div class="clearfix"></div>
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="<?= $user_active['active_user_avatar']?>" class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span><?= lang('welcom')?>,</span>
              <h2><?= $user_active['active_user_fullname']?></h2>
            </div>
            <div class="clearfix"></div>
          </div>
          <br />
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3><?= lang('week').' '.date("W").' | '.date("Y-m-d")?></h3>
              <ul class="nav side-menu">
                <?php if ($user_active['active_user_module'] != ''): ?>
                  <?php foreach ($myModule as $key => $value): ?>
                    <?php if (in_array($value['id'],$user_active['active_user_module'])): ?>
                      <?php if (isset($value['submodule'])): ?>
                        <li><a><i class="fa <?= $value['module_icon']?>"></i> <?= $value['module_name']?> <span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <?php foreach ($value['submodule'] as $key => $val): ?>
                              <?php if (in_array($val['id'],$user_active['active_user_module'])): ?>
                                <li><a href="<?= my_library::admin_site().$val['module_component']?>"><?= $val['module_name']?></a></li>
                              <?php endif ?>
                            <?php endforeach ?>
                          </ul>
                        </li>
                      <?php else: ?>
                        <li><a href="<?= my_library::admin_site().$value['module_component']?>"><i class="fa <?= $value['module_icon']?>"></i> <?= $value['module_name']?></a></li>
                      <?php endif ?>
                    <?php endif ?>
                  <?php endforeach ?>
                <?php endif ?>
              </ul>
              </div>
          </div>
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="<?= lang('profile')?>" href="<?= my_library::admin_site().'user/profile/'.$user_active['active_user_id']?>">
              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="<?= lang('system')?>" href="<?= my_library::admin_site()?>system">
              <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="<?= lang('lock')?>" href="<?= my_library::admin_site()?>index/lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="<?= lang('logout')?>" href="<?= my_library::admin_site()?>index/logout">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
        </div>
      </div>