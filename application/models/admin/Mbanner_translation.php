<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mbanner_translation extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_banner_translation";

    public function checkLanguage($banner_id)
    {
        $listLanguage = $this->getQuery("language_code", "banner_id = ".$banner_id, "language_code desc", "");
        return $listLanguage;
    }

    public function checkEditLang($id,$lang)
    {
        $check = $this->getData("id",array('banner_id' => $id,'language_code' => $lang));
        if (!empty($check)) {
            return true;
        } else {
            return false;
        }
        
    }
}
