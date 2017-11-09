<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mnews extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_news";
    protected $table_translation = "cms_news_translation";

    public function getNewsbyID($id,$obj='*',$lang='vietnamese')
    {
        $sql = 'select '.$obj.' from '.$this->table.' n inner join '.$this->table_translation.' nt on n.id = nt.news_id where n.id = '.$id.' and n.news_status = 1 and n.news_state = 3 and n.news_publicdate < "'.date("Y-m-d H:i:s").'" and nt.language_code = "'.$lang.'"';
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function getListNewsbyCategoryID($category_id,$obj='*',$limit='',$lang='vietnamese')
    {
        
    }
}
