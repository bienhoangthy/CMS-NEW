<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mvideo extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_video";
    protected $table_translation = "cms_video_translation";

    public function getVideobyID($id,$obj='*',$lang='vietnamese')
    {
        $sql = 'select '.$obj.' from '.$this->table.' v inner join '.$this->table_translation.' vt on v.id = vt.video_id where v.id = '.$id.' and v.video_status = 1 and vt.language_code = "'.$lang.'"';
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function getListVideoCategoryID($category_id,$obj='*',$limit='',$lang='vietnamese')
    {
        
    }
}
