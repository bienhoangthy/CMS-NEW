<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Googleanalytics extends MY_Controller {
  public function __construct()
  {
    parent::__construct();
  }
  public function index() {
    if ($this->_data['setting']['use_ga'] != 1) {
      redirect(base_url() . 'not-found');
    }
  	$this->lang->load('ga',$this->_data['language']);
    $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
  	$this->mpermission->checkPermission("googleanalytics","index",$this->_data['user_active']['active_user_group']);
    $this->load->library("My_google");
    $client_id = '370f1c259af738164bb1329b5ef36fce76fb06c2'; 
    $service_account_name = 'thycmsga@formal-being-184008.iam.gserviceaccount.com'; 
    $key_file_location = BASEPATH.'../application/third_party/google-api-php-client/CMS-Google-Analytics-370f1c259af7.p12';

    $client = new Google_Client();
    $client->setApplicationName("Admin CMS");
    $analytics = new Google_Service_Analytics($client);

    if (isset($_SESSION['service_token'])) {
      $client->setAccessToken($_SESSION['service_token']);
    }
    $key = file_get_contents($key_file_location);
    $cred = new Google_Auth_AssertionCredentials(
      $service_account_name,
      array(
        'https://www.googleapis.com/auth/analytics',
      ),
      $key,
      'notasecret'
    );
    $client->setAssertionCredentials($cred);
    if($client->getAuth()->isAccessTokenExpired()) {
      $client->getAuth()->refreshTokenWithAssertion($cred);
    }
    $_SESSION['service_token'] = $client->getAccessToken();

    $profileId = "ga:".$this->_data['setting']['ga_profile_id'];

    $startDate = $this->_data['since'] = $_GET['since'] ?? date("Y-m-d",strtotime('-30 days'));
    $endDate = $this->_data['to'] = $_GET['to'] ?? date("Y-m-d");

    //Total
    $total = $analytics->data_ga->get($profileId, $startDate, $endDate, 'ga:sessions,ga:visits,ga:pageviews,ga:users,ga:pageviewsPerSession,ga:bounceRate,ga:avgSessionDuration,ga:percentNewSessions');
    $this->_data['total'] = $total['rows'][0];

    //avgSessionDuration
    $total_s = round($this->_data['total'][6],0);
    $h = round(($total_s / 3600),0);
    $m = round((($total_s % 3600) / 60),0);
    $s = ($total_s % 3600) % 60;
    $this->_data['avgSessionDuration'] = '0'.$h.':'.$m.':'.$s;

    //%New Sessions
    $this->_data['percentNewSessions'] = ($this->_data['total'][7] * 100) / $this->_data['total'][0];
    $this->_data['percentNewSessions'] = round($this->_data['percentNewSessions'],1);

    //Visits & Pageviews
    $metrics_vp = 'ga:visits,ga:pageviews';
    $optParams_vp = array("dimensions" => "ga:date");
    $rs_vp = $analytics->data_ga->get($profileId, $startDate, $endDate, $metrics_vp, $optParams_vp);
    $rs_vp = $rs_vp['rows'];
    $this->_data['days'] = '';
    $this->_data['visits'] = '';
    $this->_data['pageviews'] = '';
    foreach ($rs_vp as $value) {
      $this->_data['days'] .= '"'.date('d-m',strtotime($value[0])).'",';
      $this->_data['visits'] .= $value[1].',';
      $this->_data['pageviews'] .= $value[2].',';
    }
    $this->_data['days'] = rtrim($this->_data['days'],',');
    $this->_data['visits'] = rtrim($this->_data['visits'],',');
    $this->_data['pageviews'] = rtrim($this->_data['pageviews'],',');

    //Device
    $metrics_d = 'ga:sessions';
    $optParams_d = array("dimensions" => "ga:deviceCategory");
    $rs_d = $analytics->data_ga->get($profileId, $startDate, $endDate, $metrics_d, $optParams_d);
    $rs_d = $rs_d['rows'];
    $this->_data['desktop'] = isset($rs_d[0][1]) ? (int)$rs_d[0][1] : 0;
    $this->_data['mobile'] = isset($rs_d[1][1]) ? (int)$rs_d[1][1] : 0;
    $this->_data['per_desktop'] = ($this->_data['desktop'] * 100)/($this->_data['desktop'] + $this->_data['mobile']);
    $this->_data['per_mobile'] = ($this->_data['mobile'] * 100)/($this->_data['desktop'] + $this->_data['mobile']);
    $this->_data['per_desktop'] = round($this->_data['per_desktop'],1);
    $this->_data['per_mobile'] = round($this->_data['per_mobile'],1);

    //Geo
    $rs_g = $analytics->data_ga->get($profileId, $startDate, $endDate, 'ga:sessions', array("dimensions" => "ga:country"));
    $this->_data['rs_g'] = $rs_g['rows'];

    //Top Most Visit Pages
    $rs_mvp = $analytics->data_ga->get($profileId, $startDate, $endDate, 'ga:pageviews', array("dimensions" => "ga:pagePath","sort" => "-ga:pageviews","max-results" => 10));
    $this->_data['tmvp'] = $rs_mvp['rows'];

    $this->_data['title'] = lang('title');
    $this->_data['extraCss'] = ['bootstrap-datepicker.css'];
    $this->_data['extraJs'] = ['bootstrap-datepicker.min.js'];
    $this->my_layout->view("admin/analytics/analytics", $this->_data);
  }

  public function ajaxAnalyticsHome($ajaxHome = true)
  {
    $rs = array("status" => 0);
    if ($this->_data['setting']['use_ga'] == 1) {
      $date = $this->input->get('date');
      $date = $date ?? 'today';
      $this->load->library("My_google");
      $client_id = '370f1c259af738164bb1329b5ef36fce76fb06c2'; 
      $service_account_name = 'thycmsga@formal-being-184008.iam.gserviceaccount.com'; 
      $key_file_location = BASEPATH.'../application/third_party/google-api-php-client/CMS-Google-Analytics-370f1c259af7.p12';

      $client = new Google_Client();
      $client->setApplicationName("Admin CMS");
      $analytics = new Google_Service_Analytics($client);

      if (isset($_SESSION['service_token'])) {
        $client->setAccessToken($_SESSION['service_token']);
      }
      $key = file_get_contents($key_file_location);
      $cred = new Google_Auth_AssertionCredentials(
        $service_account_name,
        array(
          'https://www.googleapis.com/auth/analytics',
        ),
        $key,
        'notasecret'
      );
      $client->setAssertionCredentials($cred);
      if($client->getAuth()->isAccessTokenExpired()) {
        $client->getAuth()->refreshTokenWithAssertion($cred);
      }
      $_SESSION['service_token'] = $client->getAccessToken();
      $profileId = "ga:".$this->_data['setting']['ga_profile_id'];
      $total = $analytics->data_ga->get($profileId, $date, $date, 'ga:sessions,ga:users');
      $total = $total['rows'];

      //Visits & Pageviews
      $total_visits = 0;
      $total_pageviews = 0;
      $vp = $analytics->data_ga->get($profileId, $date, $date, 'ga:visits,ga:pageviews', array("dimensions" => "ga:hour"));
    }
    if ($ajaxHome == true) {
    	foreach ($vp['rows'] as $value) {
	        $total_visits += $value[1];$total_pageviews += $value[2];
	      }
	      $rs = array("status" => 1,"total_sessions" => $total[0][0],"total_users" => $total[0][1],"total_visits" => $total_visits,"total_pageviews" => $total_pageviews,"vp" => $vp['rows']);
    	echo json_encode($rs);
    } else {
    	$visits = '';$pageviews = '';
    	foreach ($vp['rows'] as $value) {
    		$visits .= $value[1].',';$pageviews .= $value[2].',';
    		$total_visits += $value[1];$total_pageviews += $value[2];
    	}
    	$visits = rtrim($visits,',');$pageviews = rtrim($pageviews,',');
    	$rs = array("total_sessions" => $total[0][0],"total_users" => $total[0][1],"total_visits" => $total_visits,"total_pageviews" => $total_pageviews,"visits" => $visits,"pageviews" => $pageviews);
    	return $rs;
    }
  }

  public function analyticsbydate()
  {
  	$this->lang->load('ga',$this->_data['language']);
  	$rs = $this->ajaxAnalyticsHome(false);
  	$date = $this->input->get('date') ?? date("Y-m-d");
  	$data = array('title' => lang('title'),'rs' => $rs,'date' => $date);
  	$this->load->view("admin/analytics/date", $data);
  }
}