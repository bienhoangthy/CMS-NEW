<?php 
class Googleanalytics extends CI_Controller {
  function __construct() {
   parent::__construct();
 }
 function index() {
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
    $startDate = '2017-10-01';
    $metrics = 'ga:pageviews,ga:sessions';
    $optParams = array("dimensions" => "ga:dateHourMinute");
    $data = $analytics->data_ga->get($profileId, $startDate, 'today', $metrics, $optParams);
    var_dump($data['rows']);
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
    // $this->load->view('admin/analytics/analytics', $data);
  }
}