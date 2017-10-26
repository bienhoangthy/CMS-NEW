<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mconfig extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_config";
    protected $table_translation = "cms_config_translation";

    public function getConfig($lang='vietnamese')
    {
        $sql = 'select c.config_code,ct.config_name,ct.config_value from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.config_id where c.config_status = 1 and ct.language_code = "'.$lang.'"';
        $query = $this->db->query($sql);
        $list = $query->result_array();
        return $list;
    }
}
