<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('home',$this->_data['language']);
    }
    public function index()
    {
        $this->mpermission->checkPermission("home","index",$this->_data['user_active']['active_user_group']);
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

        //Activity
        $this->load->Model("admin/mactivity");
        $this->load->Model("admin/mcomponent");
        $this->load->helper("timeelapsed");
        $this->_data['activities'] = $this->mactivity->countQuery('');
        $this->_data['activities_today'] = $this->mactivity->countQuery('date(activity_datetime) = "'.date("Y-m-d").'"');
        $this->_data['listActivities'] = $this->mactivity->getQuery("","","id desc","0,10");

        //History login
        $this->load->Model("admin/mhistory");
        $this->load->Model("admin/mgroup");
        $this->_data['listLogin'] = $this->mhistory->getQuery("","","id desc","0,10");

        $this->_data['extraJs'] = ['module/home.js'];
    	$this->my_layout->view("admin/home/index", $this->_data);
    }
}
