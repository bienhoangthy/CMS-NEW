<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class malbum_translation extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_album_translation";

    public function checkLanguage($album_id)
    {
        $listLanguage = $this->getQuery("language_code", "album_id = ".$album_id, "language_code desc", "");
        return $listLanguage;
    }

    public function checkEditLang($id,$lang)
    {
        $check = $this->getData("id",array('album_id' => $id,'language_code' => $lang));
        if (!empty($check)) {
            return true;
        } else {
            return false;
        }
        
    }
}
