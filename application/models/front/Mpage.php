<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mpage extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_page";
    protected $table_translation = "cms_page_translation";

    public function _getIDbyAlias($alias)
    {
        $sql = 'select distinct page_id from '.$this->table_translation.' where page_alias = "'.$alias.'"';
        $query = $this->db->query($sql);
        $rs = $query->row_array();
        return $rs['page_id'];
    }

    public function getPagebyAlias($alias='',$obj='*',$lang='vietnamese')
    {
        $id = $this->_getIDbyAlias($alias);
        if ($id) {
            $sql = 'select '.$obj.' from '.$this->table.' p inner join '.$this->table_translation.' pt on p.id = pt.page_id where p.id = '.$id.' and p.page_status = 1 and  pt.language_code = "'.$lang.'"';
            $query = $this->db->query($sql);
            $rs = $query->row_array();
            return $rs;
        }
    }
}
