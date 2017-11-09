<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mcategory extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_category";
    protected $table_translation = "cms_category_translation";

    public function _getIDbyAlias($alias)
    {
        $sql = 'select distinct category_id from '.$this->table_translation.' where category_alias = "'.$alias.'"';
        $query = $this->db->query($sql);
        $rs = $query->row_array();
        return $rs['category_id'];
    }

    public function getCategorybyAlias($alias='',$obj='*',$lang='vietnamese')
    {
        $id = $this->_getIDbyAlias($alias);
        if ($id) {
            $sql = 'select '.$obj.' from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.category_id where c.id = '.$id.' and c.category_status = 1 and  ct.language_code = "'.$lang.'"';
            $query = $this->db->query($sql);
            return $query->row_array();
        }
    }
}
