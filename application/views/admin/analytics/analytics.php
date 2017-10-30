<script src="<?= my_library::admin_js()?>chart.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
      <div class="col-md-3 col-sm-3 col-xs-3">
        <div class="info-box">
            <div class="info-box-icon bg-blue font-white">
                <i class="fa fa-laptop"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text"><?= lang('sessions')?></span>
                <span class="info-box-number"><?= $total[0]?></span>
            </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-3 col-xs-3">
        <div class="info-box">
            <div class="info-box-icon bg-green">
                <i class="fa fa-exchange"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text"><?= lang('visits')?></span>
                <span class="info-box-number"><?= $total[1]?></span>
            </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-3 col-xs-3">
        <div class="info-box">
            <div class="info-box-icon bg-purple font-white">
                <i class="fa fa-eye"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text"><?= lang('pageviews')?></span>
                <span class="info-box-number"><?= $total[2]?></span>
            </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-3 col-xs-3">
        <div class="info-box">
            <div class="info-box-icon bg-red">
                <i class="fa fa-users"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text"><?= lang('users')?></span>
                <span class="info-box-number"><?= $total[3]?></span>
            </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-3 col-xs-3">
        <div class="info-box">
            <div class="info-box-icon bg-red">
                <i class="fa fa-pie-chart"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text"><?= lang('pageviewspersession')?></span>
                <span class="info-box-number"><?= round($total[4],2)?></span>
            </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-3 col-xs-3">
        <div class="info-box">
            <div class="info-box-icon bg-red">
                <i class="fa fa-frown-o"></i>
            </div>
            <div class="info-box-content">
                <span class="info-box-text"><?= lang('bouncerate')?></span>
                <span class="info-box-number"><?= round($total[5],2)?>%</span>
            </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><i class="fa fa-line-chart"></i> <?= lang('visits').' & '.lang('pageviews')?> (30<?= lang('days')?>)</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <canvas id="myChartSP"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><i class="fa fa-pie-chart"></i> <?= lang('sessionsbydevice')?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <canvas id="myChartDevice"></canvas>
            <div class="col-md-6 col-sm-6 col-xs-6">
              <h6><i class="fa fa-desktop"></i> <?= lang('desktop')?> <?= $per_desktop?>%</h6>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
              <h6><i class="fa fa-mobile fa-lg"></i> <?= lang('mobile')?> <?= $per_mobile?>%</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><i class="fa fa fa-globe"></i> <?= lang('country')?></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="dashboard-widget-content">
              <div class="col-md-3 hidden-small">
                <table class="countries_list">
                  <tbody>
                    <?php foreach ($rs_g as $value): ?>
                      <tr>
                        <td><?= $value['0']?></td>
                        <td class="fs15 fw700 text-right"><?= $value['1']?></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
              <div id="regions_div" class="col-md-9 col-sm-12 col-xs-12" style="height:230px;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  var ctx = document.getElementById('myChartSP').getContext('2d');
  var chart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: [<?= $days?>],
          datasets: [{
              label: "<?= lang('visits')?>",
              borderColor: 'rgb(22, 160, 133)',
              data: [<?= $visits?>],fill: false,
          },
          {
              label: "<?= lang('pageviews')?>",
              borderColor: 'rgb(41, 128, 185)',
              data: [<?= $pageviews?>],fill: false,
          }]
      },
      options: {
          responsive: true,
          tooltips: {
              mode: 'index',
              intersect: false,
          },
          hover: {
              mode: 'nearest',
              intersect: true
          }
      }
  });

  var ctx = document.getElementById('myChartDevice').getContext('2d');  
  var chart = new Chart(ctx, {
      type: 'pie',
      data: {
          labels: ["Desktop","Mobile"],
          datasets: [{
              data: [<?= $desktop?>,<?= $mobile?>],
              backgroundColor: ['rgb(52, 152, 219)','rgb(230, 126, 34)']
          }]
      },
      options: {
          responsive: true
      }
  });

  google.charts.load('current', {
    'packages':['geochart'],
    'mapsApiKey': 'AIzaSyALFQl8JpbDl5Wr5JqP0Hl3050CAJVwCjQ'
  });
  google.charts.setOnLoadCallback(drawRegionsMap);

  function drawRegionsMap() {
    var data = google.visualization.arrayToDataTable([
      ['Country', '<?= lang('sessions')?>'],
      <?php foreach ($rs_g as $value): ?>
        ['<?= $value['0']?>', <?= $value['1']?>],
      <?php endforeach ?>
    ]);
    var options = {};
    var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
    chart.draw(data, options);
  }  
</script>