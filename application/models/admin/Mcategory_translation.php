<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mcategory_translation extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_category_translation";

    public function checkLanguage($category_id)
    {
        $listLanguage = $this->getQuery("language_code", "category_id = ".$category_id, "language_code desc", "");
        return $listLanguage;
    }

    public function checkEditLang($id,$lang)
    {
        $check = $this->getData("id",array('category_id' => $id,'language_code' => $lang));
        if (!empty($check)) {
            return true;
        } else {
            return false;
        }
        
    }
}
