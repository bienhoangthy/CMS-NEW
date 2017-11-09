<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class msetting extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_setting";

    public function getSetting($obj="*")
    {
        $sql = 'select '.$obj.' from '.$this->table.' where id = 1';
        $query = $this->db->query($sql);
        $rs = $query->row();
        return $rs;
    }
}
