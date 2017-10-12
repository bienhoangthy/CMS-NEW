<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $title?> </h3>
      </div>
      <div class="title_right hidden-xs">
        <ol class="breadcrumb pull-right">
          <li class="breadcrumb-item"><a href="<?= my_library::admin_site()?>"><?= lang('dashboard')?></a></li>
          <li class="breadcrumb-item active"><?= $title?></li>
        </ol>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <ul class="nav navbar-left">
              <li class="pull-left"><p style="padding: 5px;"><?= lang('all')?> (<?= $record?>)</p></li>
            </ul>
            <div class="">
              <form class="form-horizontal form-label-left" method="get">
                <div class="form-group">
                  <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="input-group">
                      <input type="text" name="fkeyword" value="<?= $formData['fkeyword']?>" placeholder="<?= lang('search')?>" class="form-control">
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-4 col-xs-6">
                    <select class="form-control" name="fstatus" onchange="this.form.submit()">
                      <?= $fstatus?>
                    </select>
                  </div>
                  <div class="col-md-3 col-sm-4 col-xs-6">
                    <select class="form-control" name="fcom" onchange="this.form.submit()">
                      <?= $fcom?>
                    </select>
                  </div>
                  <input type="hidden" name="page" value="<?= $page?>">  
                </div>
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
                      <th width="5%">
                        <input type="checkbox" id="check-all" class="flat">
                      </th>
                      <th width="4%" class="column-title"># </th>
                      <th width="16%" class="column-title"><?= lang('member')?> </th>
                      <th width="30%" class="column-title"><?= lang('content')?> </th>
                      <th width="10%" class="column-title">Component </th>
                      <th width="15%" class="column-title"><?= lang('status')?> </th>
                      <th width="10%" class="column-title">IP </th>
                      <th width="10%" class="column-title"><?= lang('time')?> </th>
                      <th class="bulk-actions" colspan="7">
                        ( <span class="action-cnt"> </span> )
                        <button type="submit" class="btn btn-success btn-xs antoo" name="fsubmit" value="1" style="margin-bottom: -2px;"><?= lang('approval')?></button>
                        <button type="submit" class="btn btn-primary btn-xs antoo" name="fsubmit" value="2" style="margin-bottom: -2px;"><?= lang('pending')?></button>
                        <button type="submit" class="btn btn-warning btn-xs antoo" name="fsubmit" value="3" style="margin-bottom: -2px;">Spam</button>
                        <button type="submit" class="btn btn-danger btn-xs antoo" onclick="return confirm_delete_all();" name="fsubmit" value="5" style="margin-bottom: -2px;"><?= lang('deleteall')?></button>
                      </th>
                    </tr>
                  </thead>
                <tbody>
                  <?php if (!empty($list)): ?>
                    <?php foreach ($list as $key => $value): ?>
                      <?php 
                        if ($language == 'english') {
                          $component = ucfirst($value['comment_component']);
                        } else {
                          $com = $this->mcomponent->getData("component_name",array('component' => $value['comment_component']));
                          $component = $com ? $com['component_name'] : '';
                        }
                        $status = $this->mcomment->listStatusName($value['comment_status']);
                        $user_approved = '';
                        if ($value['comment_status'] == 1 || $value['comment_status'] == 3 && $value['user'] > 0) {
                          $user = $this->muser->getData("user_fullname","id = ".$value['user']);
                          $user_approved = $user ? '<br>'.lang('by').$user['user_fullname'] : '';
                        }
                        $operation = '';
                        switch ($value['comment_status']) {
                          case 1:
                            $operation = '<a href="javascript:;" data-operation="3" class="text-warning operation">Spam</a> ';
                            break;
                          case 2:
                            $operation = '<a href="javascript:;" data-operation="1" class="text-success operation">'.lang('approval').'</a> | <a href="javascript:;" data-operation="3" class="text-warning operation">Spam</a> ';
                            break;
                          case 3:
                            $operation = '<a href="javascript:;" data-operation="1" class="text-success operation">'.lang('approval').'</a> ';
                            break;
                          default:
                            $operation = '';
                            break;
                        }
                      ?>
                      <tr class="showacction" id="comment<?= $value['id']?>">
                        <td width="5%" class="a-center ">
                          <input type="checkbox" class="flat" value="<?= $value['id']?>" name="table_records[]">
                        </td>
                        <td width="4%"><b><?= $value['id']?></b></td>
                        <td width="16%"><?= $value['comment_member'] == 0 ? lang('guest') : ''?>
                          <div style="height: 20px;">
                            <div class="actionhover" id="operation<?= $value['id']?>" data-id="<?= $value['id']?>">
                              <?= $operation?>| <a href="javascript:;" class="text-danger delete"><?= lang('delete')?></a>
                            </div>
                          </div>
                        </td>
                        <td width="30%"><cite data-toggle="tooltip" data-placement="bottom" title="<?= $value['comment_content']?>"><?= word_limiter($value['comment_content'],18)?></cite></td>
                        <td width="10%"><?= $component?> :<a href="<?= my_library::admin_site().$value['comment_component'].'/edit/'.$value['comment_ingredient_id']?>" target="_blank">#<?= $value['comment_ingredient_id']?></a></td>
                        <td width="15%" id="status<?= $value['id']?>"><span class="label label-<?= $status['color']?>"><?= $status['name']?></span><?= $user_approved?></td>
                        <td width="10%"><code><?= $value['comment_ip']?></code></td>
                        <td width="10%"><?= date("H:i:s <\b\\r> Y-m-d", strtotime($value['comment_createdate']))?></td>
                      </tr>
                    <?php endforeach ?>
                  <?php else: ?>
                    <p class="text-danger"><?= lang('listempty')?></p>
                  <?php endif ?>
                </tbody>
              </table>
            </form>
            <?php if (isset($pagination)): ?>
              <ul class="pagination pull-right"><?= $pagination?></ul>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>