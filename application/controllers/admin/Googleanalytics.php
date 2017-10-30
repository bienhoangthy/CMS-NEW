<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Googleanalytics extends MY_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->lang->load('ga',$this->_data['language']);
    //$this->load->Model("admin/maction");
    //$this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
  }
  public function index() {
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

    $profileId = "ga:163480877";
    $startDate = date("Y-m-d",strtotime('-30 days'));

    //Total sessions
    $total = $analytics->data_ga->get($profileId, $startDate, 'today', 'ga:sessions,ga:visits,ga:pageviews,ga:users,ga:pageviewsPerSession,ga:bounceRate,ga:avgTimeOnPage');
    $this->_data['total'] = $total['rows'][0];

    // Đổi số này sang phút cho thời gian trung bình của phiên
    
    // echo date("H:i:s",$this->_data['total'][6]);die();
    // var_dump($this->_data['total']);die();
    //Visits & Pageviews
    $metrics_vp = 'ga:visits,ga:pageviews';
    $optParams_vp = array("dimensions" => "ga:date");
    $rs_vp = $analytics->data_ga->get($profileId, $startDate, 'today', $metrics_vp, $optParams_vp);
    $rs_vp = $rs_vp['rows'];
    $this->_data['days'] = '';
    $this->_data['visits'] = '';
    $this->_data['pageviews'] = '';
    foreach ($rs_vp as $value) {
      $this->_data['days'] .= '"'.date('m-d',strtotime($value[0])).'",';
      $this->_data['visits'] .= $value[1].',';
      $this->_data['pageviews'] .= $value[2].',';
    }
    $this->_data['days'] = rtrim($this->_data['days'],',');
    $this->_data['visits'] = rtrim($this->_data['visits'],',');
    $this->_data['pageviews'] = rtrim($this->_data['pageviews'],',');
    //Device
    $metrics_d = 'ga:sessions';
    $optParams_d = array("dimensions" => "ga:deviceCategory");
    $rs_d = $analytics->data_ga->get($profileId, $startDate, 'today', $metrics_d, $optParams_d);
    $rs_d = $rs_d['rows'];
    $this->_data['desktop'] = (int)$rs_d[0][1];
    $this->_data['mobile'] = (int)$rs_d[1][1];
    $this->_data['per_desktop'] = ($this->_data['desktop'] * 100)/($this->_data['desktop'] + $this->_data['mobile']);
    $this->_data['per_mobile'] = ($this->_data['mobile'] * 100)/($this->_data['desktop'] + $this->_data['mobile']);
    $this->_data['per_desktop'] = round($this->_data['per_desktop'],1);
    $this->_data['per_mobile'] = round($this->_data['per_mobile'],1);
    //Geo
    $rs_g = $analytics->data_ga->get($profileId, $startDate, 'today', 'ga:sessions', array("dimensions" => "ga:country"));
    $this->_data['rs_g'] = $rs_g['rows'];



    // var_dump($totalUsers['rows'][0][0]);die();
    //$this->_data['visits'] = $value[1].',';
    //$this->_data['pageviews'] = $value[2].',';
    //echo $this->_data['pageviews'];die();
    //var_dump($this->_data['rows']);
    // $metrics = "ga:visits,ga:pageviews,ga:sessions,ga:percentNewVisits,ga:exitRate,ga:pageviewsPerVisit";
    // $optParams = array("dimensions" => "ga:date");
    // $stats = $analytics->data_ga->get($profileId, $startDate, 'today', $metrics, $optParams);

    // $metrics = "ga:visits";
    // //Lấy giá trị theo giờ
    //  $optParamscountry = array("dimensions" => "ga:country");
    //  $optParamsbrowser = array("dimensions" => "ga:browser");
    // //Ở đây mình chỉ muốn hiển thị dữ liệu ngày hôm nay thôi, nên mình sẽ đặt
    // //thuộc tính là today -> today nhé.
    //  $country = $analytics->data_ga->get($profileId, $startDate, 'today', $metrics, $optParamscountry);
    //  $browser = $analytics->data_ga->get($profileId, $startDate, 'today', $metrics, $optParamsbrowser);
    // //Vì lấy nhiều dữ liệu nên mình sẽ lấy mảng rows trong kết quả trả về.
    // $data['country'] = $country['rows'];
    // $data['browser'] = $browser['rows'];
    // //var_dump($data['stats']);
    $this->_data['title'] = lang('title');
    // $this->_data['extraCss'] = ['jqvmap.min.css'];
    // $this->_data['extraJs'] = ['jquery.vmap.js','jquery.vmap.world.js','module/ga.js'];
    $this->my_layout->view("admin/analytics/analytics", $this->_data);
  }

}
