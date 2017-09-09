<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mnews_translation extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_news_translation";

    public function checkLanguage($news_id)
    {
        $listLanguage = $this->getQuery("language_code", "news_id = ".$news_id, "language_code desc", "");
        return $listLanguage;
    }

    public function checkEditLang($id,$lang)
    {
        $check = $this->getData("id",array('news_id' => $id,'language_code' => $lang));
        if (!empty($check)) {
            return true;
        } else {
            return false;
        }
        
    }
}
