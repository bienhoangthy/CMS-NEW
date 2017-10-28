<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {
        'packages':['geochart','corechart'],
        'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
      });
      google.charts.setOnLoadCallback(drawRegionsMap);
      google.charts.setOnLoadCallback(drawChart);
      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
        	['Country', 'Visits'],
        	<?php foreach ($country as $value): ?>
        		<?php echo "['".$value[0]."', ".$value[1]."]," ?>
        	<?php endforeach ?>
        ]);

        var options = {};

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="regions_div" style="width: 900px; height: 500px;"></div>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>