<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mconfig extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->Model("admin/mconfig_translation");
    }
    protected $table = "cms_config";
    protected $table_translation = "cms_config_translation";

    public function getConfig($lang='vietnamese',$limit = '')
    {
        // if ($lang == 'show_all') {
        //     //$sql = 'select c.id,c.config_code,c.config_status,c.config_user,ct.config_name,ct.config_value from '.$this->table.' c right join '.$this->table_translation.' ct on c.id = ct.config_id order by c.id asc';
        //     $sql = 'select c.id,c.config_code,c.config_status,c.config_user,ct.config_name,ct.config_value from '.$this->table.' c left join '.$this->table_translation.' ct on c.id = ct.config_id order by c.id asc';
        // } else {
            
        // }
        $sql = 'select c.id,c.config_code,c.config_status,c.config_user,ct.id as id_lang,ct.config_name,ct.config_value from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.config_id where ct.language_code = "'.$lang.'" order by c.id asc';
        if ($limit != '') {
            $sql .= ' limit '.$limit;
        }
        $query = $this->db->query($sql);
        $list = $query->result_array();
        return $list;
    }

    public function countConfig($lang='vietnamese')
    {
        $sql = 'select count(*) as total from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.config_id where ct.language_code = "'.$lang.'" order by c.id asc';
        $query = $this->db->query($sql);
        $total = $query->row_array();
        return $total['total'];
    }

    public function listStatusName($item = "")
    {
        $arr = array(
            1 => array(
                'name'  => lang('active'),
                'color' => 'success'
            ),
            2 => array(
                'name'  => lang('inactive'),
                'color' => 'danger'
            )
        );
        if (is_numeric($item)) {
            return $arr[$item];
        } else {
            return $arr;
        }
    }

    public function dropdownlistStatus($active = '')
    {
        $html = '';
        $data = $this->listStatusName();
        if ($data) {
            $html .= '<option value="all">-- '.lang('choosestatus').' --</option>';
            foreach ($data as $key => $value) {
                $selected = $active == $key ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $key . '">- ' . $value["name"] . '</option>';
            }
        } else {
            $html .= '<option value="0">Data empty</option>';
        }
        return $html;
    }

    public function editLogo()
    {
        $this->load->library('upload');
        $folder = realpath(APPPATH . "../media/logo").'/';

        $link_old_logo = $folder.'logo.png';
        if (file_exists($link_old_logo)) {
            unlink($link_old_logo);
        }
        $config['upload_path']          = $folder;
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 2000;
        $config['file_name'] = 'logo.png';
        $this->upload->initialize($config);
        if ( ! $this->upload->do_upload('logo'))
        {
            $error = array('error' => $this->upload->display_errors());
        }
        else
        {
            $data = $this->upload->data();
            return $data;
        }
    }

    public function editFavicon()
    {
        $this->load->library('upload');
        $folder = realpath(APPPATH . "../");
        $link_old_favicon = $folder.'/favicon.ico';
        if (file_exists($link_old_favicon)) {
            unlink($link_old_favicon);
        }
        $config['upload_path']          = $folder;
        $config['allowed_types']        = 'jpg|png|ico';
        $config['max_size']             = 1000;
        $config['file_name'] = 'favicon.ico';
        $this->upload->initialize($config);
        if ( ! $this->upload->do_upload('favicon'))
        {
            $error = array('error' => $this->upload->display_errors());
        }
        else
        {
            $data = $this->upload->data();
            return $data;
        }
    }
}
