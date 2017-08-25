<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mpage_translation extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_page_translation";

    public function checkLanguage($page_id)
    {
        $listLanguage = $this->getQuery("language_code", "page_id = ".$page_id, "language_code desc", "");
        return $listLanguage;
    }

    public function checkEditLang($id,$lang)
    {
        $check = $this->getData("id",array('page_id' => $id,'language_code' => $lang));
        if (!empty($check)) {
            return true;
        } else {
            return false;
        }
        
    }
}
