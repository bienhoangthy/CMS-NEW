$(document).ready(function(){
  loadAnalytic('today');
  $('#yesterday').click(function(){
    var url = $(this).attr('data-url');
    $.fancybox.open({
      href : url,
      type : 'iframe'
    });
  });
  $('.loadmore').click(function() {
    var load = $(this).attr('data-load');
    var page = $('#page').val();
   	var url = configs.admin_site+configs.controller+'/ajaxActivity';
   	$.ajax({
   		dataType: 'json',
   		data: {'load':load,'page':page},
   		cache: false,
   		url: url,
   		success: function(rs){
   			var table = $('#table-activity');
   			table.empty();
   			table.html(rs.html);
   			$('#page').val(rs.page);
   			$('.page-html').html(rs.page);
   			if (rs.page > 1) {$('.previous').show('slow');} else {$('.previous').hide('slow');}
        if (rs.html == '') {$('.next').hide('slow');} else {$('.next').show('slow');}
   		}
   	});
  });
});

var visits = "Lượt ghé thăm";var pageviews = "Xem trang";
if (configs.lang == 'english') {var visits = "Visits";var pageviews = "Pageviews";}

function loadAnalytic(date)
{
  $.ajax({
    cache: false,
    data: {"date":date},
    url: configs.admin_site+'googleanalytics/ajaxAnalyticsHome',
    dataType: 'json',
    success: function(rs) {
      if (rs.status == 1) {
        var ctx = document.getElementById('lineChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["0h","1h","2h","3h","4h","5h","6h","7h","8h","9h","10h","11h","12h","13h","14h","15h","16h","17h","18h","19h","20h","21h","22h","23h"],
                datasets: [{
                    label: visits,
                    borderColor: 'rgb(22, 160, 133)',
                    backgroundColor: 'rgb(46, 204, 113)',
                    data: [rs.vp[0][1],rs.vp[1][1],rs.vp[2][1],rs.vp[3][1],rs.vp[4][1],rs.vp[5][1],rs.vp[6][1],rs.vp[7][1],rs.vp[8][1],rs.vp[9][1],rs.vp[10][1],rs.vp[11][1],rs.vp[12][1],rs.vp[13][1],rs.vp[14][1],rs.vp[15][1],rs.vp[16][1],rs.vp[17][1],rs.vp[18][1],rs.vp[19][1],rs.vp[20][1],rs.vp[21][1],rs.vp[22][1],rs.vp[23][1]],fill: false
                },
                {
                    label: pageviews,
                    borderColor: 'rgb(142, 68, 173)',
                    backgroundColor: 'rgb(155, 89, 182)',
                    data: [rs.vp[0][2],rs.vp[1][2],rs.vp[2][2],rs.vp[3][2],rs.vp[4][2],rs.vp[5][2],rs.vp[6][2],rs.vp[7][2],rs.vp[8][2],rs.vp[9][2],rs.vp[10][2],rs.vp[11][2],rs.vp[12][2],rs.vp[13][2],rs.vp[14][2],rs.vp[15][2],rs.vp[16][2],rs.vp[17][2],rs.vp[18][2],rs.vp[19][2],rs.vp[20][2],rs.vp[21][2],rs.vp[22][2],rs.vp[23][2]],fill: false
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
        $('#ga-sessions').html(rs.total_sessions);
        $('#ga-visits').html(rs.total_visits);
        $('#ga-pageview').html(rs.total_pageviews);
        $('#ga-users').html(rs.total_users);
        $('#ga-home').show('slow');
      }
    }
  });
}


