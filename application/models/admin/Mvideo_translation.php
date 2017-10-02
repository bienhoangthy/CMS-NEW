<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mvideo_translation extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_video_translation";

    public function checkLanguage($video_id)
    {
        $listLanguage = $this->getQuery("language_code", "video_id = ".$video_id, "language_code desc", "");
        return $listLanguage;
    }

    public function checkEditLang($id,$lang)
    {
        $check = $this->getData("id",array('video_id' => $id,'language_code' => $lang));
        if (!empty($check)) {
            return true;
        } else {
            return false;
        }
        
    }
}
