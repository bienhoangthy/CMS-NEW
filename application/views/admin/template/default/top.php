<div class="top_nav">
  <div class="nav_menu">
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <img src="<?= $user_active['active_user_avatar']?>" alt="<?= $user_active['active_user_fullname']?>"><?= $user_active['active_user_fullname']?>
            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu dropdown-usermenu pull-right">
            <li><a href="<?= my_library::admin_site().'user/profile/'.$user_active['active_user_id']?>"> <?= lang('profile')?><i class="fa fa-user pull-right"></i> </a></li>
            <li><a href="<?= my_library::admin_site()?>index/lock"><i class="fa fa-lock pull-right"></i> <?= lang('lock')?></a></li>
            <li><a href="<?= my_library::admin_site()?>index/logout"><i class="fa fa-sign-out pull-right"></i> <?= lang('logout')?></a></li>
          </ul>
        </li>
        <li role="presentation" class="dropdown">
          <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-envelope-o"></i>
            <?php if ($mailUnread > 0): ?>
              <span class="badge bg-green"><?= $mailUnread?></span>
            <?php endif ?>
          </a>
          <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
            <?php if (!empty($listMailUnread)): ?>
              <?php foreach ($listMailUnread as $key => $value): ?>
                <li>
                  <a href="<?= my_library::admin_site().'mail/index/'.$value['id']?>">
                    <span>
                      <span><?= $value['mail_fullname']?> (<?= $value['mail_email']?>)</span>
                    </span>
                    <span class="message" style="font-weight: bold;">
                      <?= $value['mail_title']?>
                    </span>
                    <p style="font-style: italic;font-size: 10px;"><?= $value['mail_senddate']?></p>
                  </a>
                </li>
              <?php endforeach ?>
            <?php endif ?>
            <li>
              <div class="text-center">
                <a href="<?= my_library::admin_site()?>mail">
                  <strong><?= lang('viewall')?></strong>
                  <i class="fa fa-angle-right"></i>
                </a>
              </div>
            </li>
          </ul>
        </li>
        <li role="presentation" class="dropdown">
          <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
            <img src="<?= my_library::base_public().'admin/images/flag_'.$language.'.png'?>" style="height: 20px; width: auto;" alt="<?= $language?>">
          </a>
          <ul class="dropdown-menu list-unstyled" role="menu">
            <li>
              <a href="<?= my_library::admin_site().'language/setlanguage/vietnamese?redirect='.base64_encode(current_url())?>">Tiếng Việt <img class="pull-right" style="height: 20px; width: auto;" src="<?= my_library::base_public().'admin/images/flag_vietnamese.png'?>"></a>
              <a href="<?= my_library::admin_site().'language/setlanguage/english?redirect='.base64_encode(current_url())?>">English <img class="pull-right" style="height: 20px; width: auto;" src="<?= my_library::base_public().'admin/images/flag_english.png'?>"></a>
            </li>
          </ul>
        </li>
        <li>
          <a href="<?= my_library::base_url()?>" target="_blank">
            <i class="fa fa-globe"></i> <?= lang('viewwebsite')?>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</div>