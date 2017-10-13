<div class="right_col" role="main">
  <div class="row tile_count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa fa-newspaper-o"></i> <?= lang('publishednews')?></span>
      <div class="count"><?= $news_publish?></div>
      <span class="count_bottom"><i class="green"><?= $news_publish_month?> </i> <?= lang('newsthismonth')?></span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-sitemap"></i> <?= lang('category')?></span>
      <div class="count"><?= $categories?></div>
      <span class="count_bottom"><i class="green"><?= $categories_active?> </i> <?= lang('active')?></span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-group"></i> <?= lang('user')?></span>
      <div class="count"><?= $user?></div>
      <span class="count_bottom"><i class="green"><?= $user_is_active?> </i> <?= lang('active')?></span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-comments-o"></i> <?= lang('comment')?></span>
      <div class="count"><?= $comment?></div>
      <span class="count_bottom"><i class="red"><?= $comment_pending?> </i> <?= lang('pending')?></span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-envelope-o"></i> <?= lang('mailcontact')?></span>
      <div class="count"><?= $mail?></div>
      <span class="count_bottom"><i class="red"><?= $mail_unread?> </i> <?= lang('unread')?></span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-tasks"></i> <?= lang('activity')?></span>
      <div class="count green"><?= $activities?></div>
      <span class="count_bottom"><i class="green"><?= $activities_today?> </i> <?= lang('totay')?></span>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="dashboard_graph">
        <div class="row x_title">
          <div class="col-md-6">
            <h3>Analytics</h3>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row" style="margin-top: 10px;">
    <div class="col-md-6 col-sm-6 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><i class="fa fa-sort-amount-desc"></i> Top <?= lang('news')?></h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
              <li role="presentation" class="active"><a href="#mostview" id="mostview-tab" role="tab" data-toggle="tab" aria-expanded="true"><?= lang('mostviewed')?></a>
              </li>
              <li role="presentation" class=""><a href="#new" role="tab" id="new-tab" data-toggle="tab" aria-expanded="false"><?= lang('latestnews')?></a>
              </li>
            </ul>
            <div id="myTabContent" class="tab-content">
              <div role="tabpanel" class="tab-pane fade active in" id="mostview" aria-labelledby="mostview-tab" style="height: 253px;overflow: auto;">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th width="10%">#</th>
                      <th width="70%"><?= lang('titlenews')?></th>
                      <th width="20%"><?= lang('view')?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($most_view)): ?>
                      <?php $i = 0; ?>
                      <?php foreach ($most_view as $key => $value): ?>
                        <?php $i++;$link = my_library::admin_site().'news/review/'.$value['id'].'?lang='.$language;?>
                        <tr>
                          <th scope="row"><?= $i?></th>
                          <td><a href="<?= $link?>" target="_blank"><?= $value['news_title']?></a></td>
                          <td><span class="badge bg-green"><?= $value['news_view']?></span></td>
                        </tr>
                      <?php endforeach ?>
                    <?php endif ?>
                  </tbody>
                </table>
              </div>
              <div role="tabpanel" class="tab-pane fade" id="new" aria-labelledby="new-tab" style="height: 253px;overflow: auto;">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th width="10%">#</th>
                      <th width="70%"><?= lang('titlenews')?></th>
                      <th width="20%"><?= lang('craetedate')?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($latest_news)): ?>
                      <?php $i = 0; ?>
                      <?php foreach ($latest_news as $key => $value): ?>
                        <?php $i++;$link = my_library::admin_site().'news/review/'.$value['id'].'?lang='.$language;?>
                        <tr>
                          <th scope="row"><?= $i?></th>
                          <td><a href="<?= $link?>" target="_blank"><?= $value['news_title']?></a></td>
                          <td><span class="badge bg-green"><?= date("Y-m-d",strtotime($value['news_createdate']))?></span></td>
                        </tr>
                      <?php endforeach ?>
                    <?php endif ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <div class="x_panel" style="height: 390px;">
        <div class="x_title">
          <h2><i class="fa fa-tasks"></i> <?= lang('recentactivity')?></h2>
          <ul class="nav navbar-right panel_toolbox">
            <input type="hidden" id="page" value="1">
            <li><a class="loadmore" data-load="1"><i class="fa fa-chevron-left"></i></a>
            </li>
            <li><a class="loadmore" data-load="2"><i class="fa fa-chevron-right"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table class="countries_list">
            <tbody>
              <?php if (!empty($listActivities)): ?>
                <?php foreach ($listActivities as $key => $value): ?>
                  <?php 
                    $user = $this->muser->getData("id,user_fullname,user_avatar,user_folder",array('id' => $value['activity_user']));
                    if ($user) {
                      if ($user['user_avatar'] != '') {
                        $avatar_user = base_url().'media/user/'.$user['user_folder'].'/thumb-'.$user['user_avatar'];
                      } else {
                        $avatar_user = my_library::base_public().'admin/images/user.png';
                      }
                      $myUser = '<img src="'.$avatar_user.'" class="avatar" style="width: 30px;height: auto;" alt="avatar">&nbsp;<a href="'.my_library::admin_site().'user/profile/'.$user['id'].'" target="_blank">'.$user['user_fullname'].'</a>';
                    } else {
                      $myUser = lang('someone');
                    }
                    $action = $this->mactivity->listAction($value['activity_action']);
                    $comname = '';
                    if ($language == 'english') {
                      $com = $this->mcomponent->getData("component",array('id' => $value['activity_component']));
                      $comname = ucfirst($com['component']);
                    } else {
                      $com = $this->mcomponent->getData("component,component_name",array('id' => $value['activity_component']));
                      $comname = $com['component_name'];
                    }
                   ?> 
                  <tr>
                    <td><?= $myUser?> <i class="text-<?= $action['color']?>"><?= $action['name']?></i> <?= $comname?> "<a href="<?= my_library::admin_site().$com['component'].'/edit/'.$value['activity_id_com']?>" target="_blank">#<?= $value['activity_id_com']?></a>"</td>
                    <td class="text-right"><i><?= time_elapsed_string($value['activity_datetime'])?></i> <code class="hidden-xs">(<?= $value['activity_ip']?>)</code></td>
                  </tr>
                <?php endforeach ?>
              <?php endif ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><i class="fa fa-sign-in"></i> <?= lang('historylogin')?></h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table class="table table-striped">
            <thead>
              <tr>
                <th></th>
                <th><?= lang('user')?></th>
                <th><?= lang('group')?></th>
                <th><?= lang('time')?></th>
                <th>IP</th>
                <th><?= lang('browser')?></th>
                <th><?= lang('os')?></th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($listLogin)): ?>
                <?php foreach ($listLogin as $key => $value): ?>
                  <?php 
                    $user = $this->muser->getData("id,user_fullname,user_avatar,user_folder",array('id' => $value['history_user_id']));
                    $avatar_user = $user && $user['user_avatar'] != '' ? base_url().'media/user/'.$user['user_folder'].'/thumb-'.$user['user_avatar'] : my_library::base_public().'admin/images/user.png';
                    $fullname = $user['user_fullname'] ?? lang('someone');
                    $group = $this->mgroup->getData("group_name",array('id' => $value['history_group']));
                    $group_name = $group['group_name'] ?? '';;
                   ?>
                  <tr class="showacction">
                    <th><img src="<?= $avatar_user?>" class="avatar" style="width: 35px;height: auto;" alt="avatar"></th>
                    <td><a href="<?= my_library::admin_site().'user/profile/'.$user['id']?>" target="_blank"><?= $fullname?></a></td>
                    <td><?= $group_name?></td>
                    <td><cite><?= time_elapsed_string($value['history_time'])?></cite></td>
                    <td><code><?= $value['history_ip']?></code></td>
                    <td><?= $value['history_agent']?></td>
                    <td><?= $value['history_platform']?></td>
                  </tr>
                <?php endforeach ?>
              <?php endif ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>