<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?= $title?></h3>
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
						<h2><i class="fa fa-language"></i> <?= lang('select')?></h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<form method="get">
	                          <select class="form-control" name="file" required="required" onchange="this.form.submit();">
	                            <option value=""><?= lang('choosefile')?></option>
	                            <?php foreach ($files as $value): ?>
	                            	<?php $ext = explode('.',$value); ?>
	                            	<?php if ($ext[1] == 'php'): ?>
	                            		<?php $title_file = explode('_', $ext[0]);$title_file = ucfirst($title_file['0']); ?>
	                            		<option <?= $filename == $ext[0] ? 'selected' : ''?> value="<?= $ext[0]?>"><?= $title_file?></option>
	                            	<?php endif ?>
	                            <?php endforeach ?>
	                          </select>
	                    </form>
					</div>
				</div>
			</div>
			<?php if (isset($filename) && $filename != ''): ?>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input type="hidden" name="filename" value="<?= $filename?>" id="filename">
	                <div class="x_panel">
	                  <div class="x_title">
	                    <h2><i class="fa fa-edit"></i> <?= lang('element')?> <small><?= lang('clickedit')?></small></h2>
	                    <ul class="nav navbar-right panel_toolbox">
	                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	                      </li>
	                      <li><a class="close-link"><i class="fa fa-close"></i></a>
	                      </li>
	                    </ul>
	                    <div class="clearfix"></div>
	                  </div>
	                  <div class="x_content">
	                    <table class="table table-hover">
	                      <thead>
	                        <tr>
	                          <th width="20%"><?= lang('variable')?></th>
	                          <th width="40%"><img src="<?= my_library::admin_images()?>flag_vietnamese.png" style="height: 15px;" alt="vietnamese"> Việt Nam</th>
	                          <th width="40%"><img src="<?= my_library::admin_images()?>flag_english.png" style="height: 15px;" alt="english"> English</th>
	                        </tr>
	                      </thead>
	                      <tbody>
	                      	<?php foreach ($arrContent as $key => $value): ?>
	                      		<?php 
	                      			$line_vn = explode(" = ", $value);
	                      			$line_en = explode(" = ", $arrEN[$key]);
            						$textvn = trim($line_vn[1],"'");
            						$texten = trim($line_en[1],"'");
	                      		 ?>
	                      		 <tr>
		                          <td><code><?= $line_vn[0]?></code></td>
		                          <td><a href="javascript:;" class="translation" data-lang="vietnamese" data-content="<?= $textvn?>"><?= $textvn?></a></td>
		                          <td><a href="javascript:;" class="translation" data-lang="english" data-content="<?= $texten?>"><?= $texten?></a></td>
		                        </tr>
	                      	<?php endforeach ?>
	                      </tbody>
	                    </table>

	                  </div>
	                </div>
	              </div>
			<?php endif ?>
		</div>
	</div>
</div>