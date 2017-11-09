<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class malbum extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_album";
    protected $table_detail = "cms_album_detail";
    protected $table_translation = "cms_album_translation";

    public function getAlbumbyID($id,$obj='*',$lang='vietnamese')
    {
        $sql = 'select '.$obj.' from '.$this->table.' a inner join '.$this->table_translation.' at on a.id = at.album_id where a.id = '.$id.' and a.album_status = 1 and at.language_code = "'.$lang.'"';
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function getAlbumDetail($album_id,$limit='',$obj='*')
    {
        $sql = 'select '.$obj.' from '.$this->table_detail.' where album_id = '.$album_id;
        if ($limit) {
            $sql .= ' limit ' . $limit;
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getListAlbumbyCategoryID($category_id,$obj='*',$limit='',$lang='vietnamese')
    {
        
    }
}
