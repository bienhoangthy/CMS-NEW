<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mlanguage extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_language";


    public function getLanguage()
    {
        $sql = 'select lang_name,lang_code,lang_flag from '.$this->table.' where lang_status = 1';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
