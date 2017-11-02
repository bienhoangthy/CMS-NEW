<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= $title?> » Admin CMS</title>
	<link href="<?= my_library::admin_css()?>bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= my_library::admin_css()?>font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?= my_library::admin_css()?>bootstrap-datepicker.css" rel="stylesheet">
	<style type="text/css" media="screen">
		.info-box-icon {
			font-size: 30px;
			height: 53px;
			width: 50px;
			line-height: 50px;
			color: #fff;
			display: block;
			float: left;
			text-align: center;
			background-color: #d2d6de;
		}
		.info-box-content {
			padding: 4px 10px;
			margin-left: 50px;
		}
		.info-box-text {
			font-size: 13px;
		}
		.info-box-number {
			display: block;
			font-weight: 700;
			font-size: 18px;
		}
		.info-box {
			display: block;
			min-height: 50px;
			background: #fff;
			width: 100%;
			box-shadow: 0 1px 1px rgba(0,0,0,.1);
			margin-bottom: 15px;
		}
	</style>
	<script src="<?= my_library::admin_js()?>chart.min.js"></script>
	<script src="<?= my_library::admin_js()?>jquery.min.js"></script>
	<script src="<?= my_library::admin_js()?>bootstrap.min.js"></script>
	<script src="<?= my_library::admin_js()?>bootstrap-datepicker.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div style="text-align: center;">
				<h2><?= $title?> <i class="text-success" id="date-title"><?= $date?></i></h2>
				<div class="input-group" style="width: 30%;margin: 0 auto;">
				  	<input type="text" id="date" readonly="readonly" data-provide="datepicker" data-date-format="yyyy-mm-dd" name="date" class="form-control" value="<?= $date?>"><span class="input-group-addon"><a href="javascript:;" id="update"><i class="fa fa-search"></i></a></span>
				</div>
			</div>
			
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px;position: relative;">
				<div id="loading" style=" position: absolute; left: 0; right: 0; text-align: center; top: 40%;display: none;">
					<img src="<?= my_library::admin_images()?>load.gif" alt="loading" style="width: 70px;height: auto;">
				</div>
				<div id="chart-content">
					<canvas id="lineChart"></canvas>
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-3">
				<div class="info-box">
					<div class="info-box-icon font-white" style="background-color: #3498DB;">
						<i class="fa fa-laptop"></i>
					</div>
					<div class="info-box-content">
						<span class="info-box-text"><?= lang('sessions')?></span>
						<span class="info-box-number" id="ga-sessions"><?= $rs['total_sessions']?></span>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-3">
				<div class="info-box">
					<div class="info-box-icon font-white" style="background-color: #1ABB9C;">
						<i class="fa fa-exchange"></i>
					</div>
					<div class="info-box-content">
						<span class="info-box-text"><?= lang('visits')?></span>
						<span class="info-box-number" id="ga-visits"><?= $rs['total_visits']?></span>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-3">
				<div class="info-box">
					<div class="info-box-icon font-white" style="background-color: #9B59B6;">
						<i class="fa fa-eye"></i>
					</div>
					<div class="info-box-content">
						<span class="info-box-text"><?= lang('pageviews')?></span>
						<span class="info-box-number" id="ga-pageview"><?= $rs['total_pageviews']?></span>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-3">
				<div class="info-box">
					<div class="info-box-icon font-white" style="background-color: #E74C3C;">
						<i class="fa fa-users"></i>
					</div>
					<div class="info-box-content">
						<span class="info-box-text"><?= lang('users')?></span>
						<span class="info-box-number" id="ga-users"><?= $rs['total_users']?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			var data_c = {
				labels: ["0h","1h","2h","3h","4h","5h","6h","7h","8h","9h","10h","11h","12h","13h","14h","15h","16h","17h","18h","19h","20h","21h","22h","23h"],
				datasets: [{
					label: "<?= lang('visits')?>",
					borderColor: 'rgb(22, 160, 133)',
					backgroundColor: 'rgb(46, 204, 113)',
					data: [<?= $rs['visits']?>],fill: false
				},
				{
					label: "<?= lang('pageviews')?>",
					borderColor: 'rgb(142, 68, 173)',
					backgroundColor: 'rgb(155, 89, 182)',
					data: [<?= $rs['pageviews']?>],fill: false
				}]
			};
			var options_c = {
				responsive: true,
				scaleOverride : true,
				scaleSteps : 10,
				scaleStepWidth : 10,
				scaleStartValue : 0,
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				}
			};
			var ctx = document.getElementById("lineChart").getContext("2d");
			var myChart = new Chart(ctx, {type: 'line',data: data_c,options: options_c});
			$('#update').click(function(){
				var date = $('#date').val();
				if (date) {
					$('#loading').show();
					$('#chart-content').css("opacity", "0.2");
					$.ajax({
						cache: false,
						data: {"date":date},
						url: '<?= my_library::admin_site()?>googleanalytics/ajaxAnalyticsHome',
						dataType: 'json',
						success: function(rs) {
							if (rs.status == 1) {
								$.each(rs.vp, function(index, val) {
									myChart.data.datasets[0].data[index] = val[1];
									myChart.data.datasets[1].data[index] = val[2];
								});
								myChart.update();
								$('#loading').hide();
								$('#chart-content').css("opacity", "1");
								$('#date-title').html(date);
								$('#ga-sessions').html(rs.total_sessions);
						        $('#ga-visits').html(rs.total_visits);
						        $('#ga-pageview').html(rs.total_pageviews);
						        $('#ga-users').html(rs.total_users);
							}
						}
					});
				}
			});
		});
	</script>
</body>
</html>