<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mlink_translation extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_link_translation";

    public function checkLanguage($link_id)
    {
        $listLanguage = $this->getQuery("language_code", "link_id = ".$link_id, "language_code desc", "");
        return $listLanguage;
    }

    public function checkEditLang($id,$lang)
    {
        $check = $this->getData("id",array('link_id' => $id,'language_code' => $lang));
        if (!empty($check)) {
            return true;
        } else {
            return false;
        }
        
    }
}
