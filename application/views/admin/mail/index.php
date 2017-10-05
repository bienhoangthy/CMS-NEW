<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $title?></h3>
      </div>
      <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="<?= lang('search')?>...">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?= lang('inbox')?><small><?= lang('all')?>(<?= $record?>)</small></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <div class="col-sm-4 mail_list_column">
                <a href="<?= current_url()?>"><button class="btn btn-sm btn-success btn-block" type="button"><i class="fa fa-refresh"></i> <?= lang('reload')?></button></a>
                <?php if (!empty($list)): ?>
                  <?php foreach ($list as $key => $value): ?>
                    <?php 
                      $name = $value['mail_fullname'] ?? $value['mail_email'];
                      $type = $this->mmail->listType($value['mail_type']);
                      $linkView = my_library::admin_site().'mail/index/'.$value['id'];
                      if ($query != '') {
                        $linkView .= '?'.$query;
                      }
                      $style_div = "";
                      $style_p = "";
                      if ($value['mail_status'] == 1) {
                        $style_div = 'border-left: solid green;';
                        $style_p = 'class="text-primary" style="font-weight: bold;"';
                      }
                      $style_div .= $id == $value['id'] ? 'background-color: gainsboro;' : '';
                     ?>
                    <a href="<?= $linkView?>">
                      <div class="mail_list" style="<?= $style_div?>">
                        <div class="left" style="margin-left: 3px;margin-top: 3px;">
                          <i class="fa <?= $type['icon']?>" data-toggle="tooltip" data-placement="left" title="<?= $type['name']?>"></i> <?php if ($value['mail_important'] == 1): ?><i class="fa fa-star text-warning" data-toggle="tooltip" data-placement="left" title="<?= lang('mailimportant')?>"></i><?php endif ?>
                        </div>
                        <div class="right" style="margin-top: 3px;">
                          <h3><?= $name?></h3>
                          <p <?= $style_p?>><?= $value['mail_title']?></p>
                          <cite><?= $value['mail_email']?></cite> <i class="fa fa-clock-o"></i> <small <?= $style_p?>><?= date("H:i - Y/m/d", strtotime($value['mail_senddate']))?></small>
                        </div>
                      </div>
                    </a>
                  <?php endforeach ?>
                <?php else: ?>
                  <a href="#">
                    <div class="mail_list">
                      <div class="right">
                        <h3 class="text-danger"><?= lang('listempty')?></h3>
                      </div>
                    </div>
                  </a>
                <?php endif ?>
                <?php if (isset($pagination)): ?>
                  <ul class="pagination pull-right"><?= $pagination?></ul>
                <?php endif ?>
              </div>
              <div class="col-sm-8 mail_view">
                <div class="inbox-body">
                  <?php if (!empty($myMail)): ?>
                    <?php
                      $myMailStatus = $this->mmail->listStatusName($myMail['mail_status']);
                      $myMailType = $this->mmail->listType($myMail['mail_type']);
                    ?>
                    <div class="mail_heading row">
                      <div class="col-md-8">
                        <div class="btn-group">
                          <button class="btn btn-sm btn-primary" type="button"><i class="fa fa-reply"></i> Reply</button>
                          <button class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Forward"><i class="fa fa-share"></i></button>
                          <button class="btn btn-sm btn-default" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Print"><i class="fa fa-print"></i></button>
                          <button class="btn btn-sm btn-default" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Trash"><i class="fa fa-trash-o"></i></button>
                        </div>
                        <span class="label label-<?= $myMailStatus['color']?>"><?= $myMailStatus['name']?></span>
                      </div>
                      <div class="col-md-4 text-right">
                        <p class="date"> <i class="fa fa-clock-o"></i> <?= date("H:i:s - Y/m/d", strtotime($value['mail_senddate']))?></p>
                      </div>
                      <div class="col-md-12">
                        <h4><?php if ($myMail['mail_important'] == 1): ?><i class="fa fa-star text-warning" data-toggle="tooltip" data-placement="top" title="<?= lang('mailimportant')?>"></i><?php endif ?> <?= $myMail['mail_title']?></h4>
                      </div>
                    </div>
                    <div class="sender-info">
                      <div class="row">
                        <div class="col-md-12">
                          <strong><?= $myMail['mail_fullname']?></strong>
                          <span>(<?= $myMail['mail_email']?>)</span>
                        </div>
                      </div>
                    </div>
                    <div class="view-mail">
                      <p><?= $myMail['mail_content']?></p>
                    </div>
                    <div class="attachment">
                      <p>
                        <span><i class="fa <?= $myMailType['icon']?>"></i> <?= $myMailType['name']?></span> - 
                        <span><i class="fa fa-home"></i> <?= lang('address')?>: </span> <strong><?= $myMail['mail_address']?></strong> - 
                        <span><i class="fa fa-phone"></i> <?= lang('phone')?>: </span> <strong><?= $myMail['mail_phone']?></strong>
                      </p>
                      <p>
                        <?php if ($myMail['mail_status'] == 2): ?>
                          Readed by Hoàng Thy at <?= date("H:i:s - Y/m/d", strtotime($myMail['readdate']))?>
                        <?php endif ?>
                      </p>
                    </div>
                    <div class="btn-group">
                      <button class="btn btn-sm btn-primary" type="button"><i class="fa fa-reply"></i> Reply</button>
                      <button class="btn btn-sm btn-default" type="button"  data-placement="top" data-toggle="tooltip" data-original-title="Forward"><i class="fa fa-share"></i></button>
                      <button class="btn btn-sm btn-default" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Print"><i class="fa fa-print"></i></button>
                      <button class="btn btn-sm btn-default" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Trash"><i class="fa fa-trash-o"></i></button>
                    </div>
                  <?php endif ?>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>