<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mconfig_translation extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_config_translation";

    public function checkLanguage($config_id)
    {
        $listLanguage = $this->getQuery("language_code", "config_id = ".$config_id, "language_code desc", "");
        return $listLanguage;
    }

    public function checkEditLang($id,$lang)
    {
        $check = $this->getData("id",array('config_id' => $id,'language_code' => $lang));
        if (!empty($check)) {
            return true;
        } else {
            return false;
        }
        
    }
}
