<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mspecial_content_translation extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_special_content_translation";

    public function checkLanguage($sc_id)
    {
        $listLanguage = $this->getQuery("language_code", "sc_id = ".$sc_id, "language_code desc", "");
        return $listLanguage;
    }

    public function checkEditLang($id,$lang)
    {
        $check = $this->getData("id",array('sc_id' => $id,'language_code' => $lang));
        if (!empty($check)) {
            return true;
        } else {
            return false;
        }
        
    }
}
