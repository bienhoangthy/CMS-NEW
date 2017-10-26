<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('home',$this->_data['language']);
        $this->load->Model("admin/mactivity");
        $this->load->Model("admin/mcomponent");
        $this->load->helper("timeelapsed");
    }
    public function index()
    {
        $this->mpermission->checkPermission("home","index",$this->_data['user_active']['active_user_group']);
        // $this->load->library("My_google");
        // $client = new Google_Client();
        // $client->setApplicationName("CMS");
        // $client->setDeveloperKey("AIzaSyCcc5Oo3bhB_k6rMGMBDY2Bm8QIF75XvIw");
        

        $this->_data['title'] = lang('dashboard');
        //Total news publish
        $this->load->Model("admin/mnews");
        $this->_data['news_publish'] = $this->mnews->countQuery('news_status = 1 and news_state = 3');
        //Today
        $this->_data['news_publish_month'] = $this->mnews->countQuery('news_status = 1 and news_state = 3 and month(news_publicdate) = "'.date("m").'" and year(news_publicdate) = "'.date("Y").'"');
        //Most view
        $this->_data['most_view'] = $this->mnews->getNews("n.id,n.news_view,nt.news_title",'news_status = 1 and news_state = 3 and nt.language_code = "'.$this->_data['language'].'"','n.news_view desc','0,10');
        //Latest
        $this->_data['latest_news'] = $this->mnews->getNews("n.id,n.news_createdate,nt.news_title",'nt.language_code = "'.$this->_data['language'].'"','n.news_createdate desc','0,10');

        //User
        $this->_data['user'] = $this->muser->countQuery('');
        //User active
        $this->_data['user_is_active'] = $this->muser->countQuery('user_status = 1');

        //Categories
        $this->load->Model("admin/mcategory");
        $this->_data['categories'] = $this->mcategory->countQuery('id <> 1');
        $this->_data['categories_active'] = $this->mcategory->countQuery('category_status = 1 and id <> 1');

        //Comment
        $this->load->Model("admin/mcomment");
        $this->_data['comment'] = $this->mcomment->countQuery('');
        $this->_data['comment_pending'] = $this->mcomment->countQuery('comment_status = 2');

        //Mail contact
        $this->_data['mail'] = $this->mmail->countQuery('');
        $this->_data['mail_unread'] = $this->mmail->countQuery('mail_status = 1');

        //Setting Display
        $this->load->Model("admin/msetting");
        $this->_data['mySetting'] = $this->msetting->getSetting("write_log,write_history_login");
        if ($this->_data['mySetting']['write_log'] == 1) {
            $this->_data['listActivities'] = $this->mactivity->getQuery("","","id desc","0,10");
        }
        //Activity
        $this->_data['activities'] = $this->mactivity->countQuery('');
        $this->_data['activities_today'] = $this->mactivity->countQuery('date(activity_datetime) = "'.date("Y-m-d").'"');

        //History login
        if ($this->_data['mySetting']['write_history_login'] == 1) {
            $this->load->Model("admin/mhistory");
            $this->load->Model("admin/mgroup");
            $this->_data['listLogin'] = $this->mhistory->getQuery("","","id desc","0,10");
        }

        $this->_data['extraJs'] = ['module/home.js'];
    	$this->my_layout->view("admin/home/index", $this->_data);
    }

    public function ajaxActivity()
    {
    	$html = '';
    	$load = $this->input->get('load');
    	$page = $this->input->get('page');
    	if ($load && $page) {
    		$listActivities = array();
    		if ($load == 1) {
    			$page = $page - 1;
    		} else {
    			$page = $page + 1;
    		}
    		$start = ($page - 1) * 10;
    		$listActivities = $this->mactivity->getQuery("","","id desc",$start.",10");
    		if (!empty($listActivities)) {
    			foreach ($listActivities as $value) {
    				$user = $this->muser->getData("id,user_fullname,user_avatar,user_folder",array('id' => $value['activity_user']));
                    if ($user) {
                      if ($user['user_avatar'] != '') {
                        $avatar_user = base_url().'media/user/'.$user['user_folder'].'/thumb-'.$user['user_avatar'];
                      } else {
                        $avatar_user = my_library::base_public().'admin/images/user.png';
                      }
                      $myUser = '<img src="'.$avatar_user.'" class="avatar" style="width: 30px;height: auto;" alt="avatar">&nbsp;<a href="'.my_library::admin_site().'user/profile/'.$user['id'].'" target="_blank">'.$user['user_fullname'].'</a>';
                    } else {
                      $myUser = lang('someone');
                    }
                    $action = $this->mactivity->listAction($value['activity_action']);
                    $comname = '';
                    if ($this->_data['language'] == 'english') {
                      $com = $this->mcomponent->getData("component",array('id' => $value['activity_component']));
                      $comname = ucfirst($com['component']);
                    } else {
                      $com = $this->mcomponent->getData("component,component_name",array('id' => $value['activity_component']));
                      $comname = $com['component_name'];
                    }
                    $html .= '<tr><td>'.$myUser.' <i class="text-'.$action['color'].'">'.$action['name'].'</i> '.$comname.' "<a href="'.my_library::admin_site().$com['component'].'/edit/'.$value['activity_id_com'].'" target="_blank">#'.$value['activity_id_com'].'</a>"</td><td class="text-right"><i>'.time_elapsed_string($value['activity_datetime']).'</i> <code class="hidden-xs">('.$value['activity_ip'].')</code></td></tr>';
    			}
    		}
    	}
    	$rs = array('html' => $html,'page' => $page);
    	echo json_encode($rs);
    }
}
