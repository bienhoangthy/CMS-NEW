<?php
class MY_Model extends CI_Model {

	protected $table = '';

	public function __construct() {
		parent::__construct();
		// if (CACHE == 1) {
		// 	$this->load->library('memcached_library');
		// }
	}
	/**begin get object
		     * $object= array("a","b")
		     * $where=array("a"=>"b")
		     * $order_by = array("title","id")
		     * $limit = "10,20"
		     * $group_by = array("title", "date")
	*/
	public function getObject($object = '', $where = '', $order_by = '', $limit = '', $group_by = '') {
		if ($object) {
			$this->db->select($object);
		}
		if ($where) {
			$this->db->where($where);
		}
		if ($order_by) {
			$this->db->order_by($order_by);
		}
		if ($limit) {
			/*$l = explode(",", $limit);
				            if (isset($l[1])) {
				                $this->db->limit($l[0], $l[1]);
				            } else {
				                $this->db->limit($l[0]);
			*/
			$this->db->limit($limit);
		}
		if ($group_by) {
			$this->db->group_by($group_by);
		}
		$rs = $this->db->get($this->table);
		return $rs->result_object();
	}
	/**end get object*/

	/**begin get array*/
	public function getArray($object = '', $and = '', $order_by = '', $limit = '') {
		if ($object) {
			$this->db->select($object);
		}
		if ($and) {
			$this->db->where($and);
		}
		if ($order_by) {
			$this->db->order_by($order_by);
		}
		if (!empty($limit)) {
			$this->db->limit($limit);
		}
		$rs = $this->db->get($this->table);
		return $rs->result_array();
	}
	/**end get array*/

	/**begin danh sach array*/
	public function getQuery($object = "", $and = "", $orderby = "", $limit = "") {
		if ($object) {
			$sql = 'select ' . $object . ' ';
		} else {
			$sql = 'select * ';
		}

		$sql .= 'from ' . $this->table;
		if ($and) {
			$sql .= ' where ' . $and;
		}

		if ($orderby) {
			$sql .= ' order by ' . $orderby;
		}

		if ($limit) {
			$sql .= ' limit ' . $limit;
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	/**end danh sach array*/
	
	/**join*/
	public function getQuery_join($object = "", $table_join = '', $and = "", $orderby = "", $limit = "") {
		if ($object) {
			$sql = 'select ' . $object . ' ';
		} else {
			$sql = 'select * ';
		}

		$sql .= 'from ' . $this->table;

		if ($table_join) {
			$sql .= ' join ' . $table_join;
		}

		if ($and) {
			$sql .= ' where ' . $and;
		}

		if ($orderby) {
			$sql .= ' order by ' . $orderby;
		}

		if ($limit) {
			$sql .= ' limit ' . $limit;
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	/**end join*/

	/**begin dem theo query sql*/
	public function countQuery($and = "") {
		$sql = 'select id from ' . $this->table;

		if ($and) {

			$sql .= ' where ' . $and;
		}
		$query = $this->db->query($sql);
		if (isset($query) && is_resource($query)) {
			mysqli_free_result($query);
		}
		$count = $query->num_rows();

		return $count;
	}
	/**end dem theo query sql*/

	/**begin dem theo array*/
	public function countAnd($and = '') {
		if ($and) {
			$this->db->where($and);
		}
		$query = $this->db->get($this->table);
		if (isset($query) && is_resource($query)) {
			mysqli_free_result($query);
		}
		$count = $query->num_rows();
		return $count;
	}
	/**end dem theo array*/

	/**begin lay 1 dong co dieu kien*/
	public function getData($object = '', $and = '') {
		if ($and) {
			if ($object) {
				$this->db->select($object);
			}
			$this->db->where($and);
			$rs = $this->db->get($this->table);
			if (isset($rs) && is_resource($rs)) {
				mysqli_free_result($rs);
			}

			return $rs->row_array();
		}
	}
	/**end lay 1 dong co dieu kien*/

	/**begin lay 1 dong co dieu kien*/
	public function getDataObject($object = '', $and = '') {
		if ($and) {
			if ($object) {
				$this->db->select($object);
			}
			$this->db->where($and);
			$rs = $this->db->get($this->table);
			if (isset($rs) && is_resource($rs)) {
				mysqli_free_result($rs);
			}
			return $rs->row_object();
		}
	}
	/**end lay 1 dong co dieu kien*/

	public function add($data) {
		$this->open();
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function edit($id, $data) {
		$this->open();
		$this->db->where("id", $id);
		$this->db->update($this->table, $data);
		return true;
	}
	public function editAnd($and, $data) {
		$this->open();
		$this->db->where($and);
		$this->db->update($this->table, $data);
		return true;
	}

	/**begin xoa*/
	public function delete($id) {
		if (is_numeric($id)) {
			$this->db->where('id', $id);
		} elseif (is_array($id)) {
			$this->db->where_in('id', $id);
		}
		$this->db->delete($this->table);
		$this->db->query('ANALYZE TABLE ' . $this->table);
		$this->db->query('OPTIMIZE TABLE ' . $this->table);
		return;
	}
	/**end xoa*/

	public function deleteAnd($condition) {
		$this->open();
		if (!empty($condition) && is_array($condition)) {
			foreach ($condition as $key => $value) {
				if (is_numeric($key)) {
					$this->db->where($value);
				} else {
					$this->db->where($key, $value);
				}
			}
		}

		$this->db->delete($this->table);
		$this->db->query('ANALYZE TABLE ' . $this->table);
		$this->db->query('OPTIMIZE TABLE ' . $this->table);
	}

	public function excuteQuery($sql) {
		$this->open();
		$r = $this->db->query($sql);
		if (empty($r) || !is_object($r)) {
			return null;
		}
		return $r->result_array();
	}

	private $isConnected = false;

	public function open() {
		if ($this->isConnected) {
			if (empty($this->db)) {
				$CI = &get_instance();
				$CI->load->database();
				$this->db = $CI->db;
			}
			return;
		}

		$this->isConnected = true;
		$CI = &get_instance();
		if (empty($CI->db)) {
			$CI->load->database();
			$this->db = $CI->db;
		}

		$this->table = $this->dbprefix($this->table);
	}

	public function close() {
		if (!empty($this->db)) {
			$this->db->close();
		}

		$this->isConnected = false;
	}

	public function dbprefix($table) {
		if (!$this->isConnected) {
			$this->open();
		}

		if (empty($this->db->dbprefix) || startsWith($table, $this->db->dbprefix)) {
			return $table;
		}

		return $this->db->dbprefix($table);
	}

	public function beginTransaction() {
		$this->db->trans_begin();
	}

	public function finishTransaction() {
		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	public function commit() {
		$this->db->trans_commit();
	}

	public function rollback() {
		$this->db->trans_rollback();
	}

	/**begin upload file*/
	// public function upload($path, $name, $size = '', $watermark = true) {
	// 	if (!is_dir($path)) {
	// 		mkdir($path, 0777, true);
	// 		chmod($path, 0777);
	// 	}
	// 	$tmpName = pathinfo($_FILES[$name]['name']);
	// 	$config = array('upload_path' => $path,
	// 		'allowed_types' => 'gif|jpg|png',
	// 		'file_name' => mb_strtolower(url_title($tmpName['filename'], '-', true)),
	// 		'max_size' => '10000');
	// 	$this->load->library("upload", $config);
	// 	if (!$this->upload->do_upload($name)) {
	// 		$error = array($this->upload->display_errors());
	// 		return 0;
	// 	} else {
	// 		$image_data = $this->upload->data();
	// 		$this->load->library("image_lib");
	// 		// /*resize*/
	// 		$config['image_library'] = 'gd2';
	// 		$config['source_image'] = $path . '/' . $image_data['file_name'];
	// 		$config['create_thumb'] = false;
	// 		$config['maintain_ratio'] = true;
	// 		if ($size != 'full') {
	// 			$config['maxwidth'] = 900;
	// 			// $config['height']   = 450; // ti le 4:3
	// 		}

	// 		$this->image_lib->initialize($config);
	// 		$this->image_lib->resize(); // resize
	// 		$this->image_lib->clear();
	// 		unset($config);
	// 		/*watemark*/
	// 		// if(file_exists(dir_root.'/public/frontend/images/logo.png') && $watermark==true){
	// 		//     $config['source_image'] = $path.'/'.$image_data['file_name'];
	// 		//     $config['create_thumb'] = FALSE;
	// 		//     $config['wm_type'] = 'overlay';
	// 		//     $config['wm_overlay_path'] = dir_root.'/public/frontend/images/logo.png';
	// 		//     $config['wm_vrt_alignment'] = 'bottom';
	// 		//     $config['wm_hor_alignment'] = 'right';
	// 		//     $config['wm_padding'] = '0';
	// 		//     $config['wm_opacity'] = '50';
	// 		//     $this->image_lib->initialize($config);
	// 		//     $this->image_lib->watermark(); //watemark
	// 		// }
	// 		return $image_data;
	// 	}
	// }
	// /**end upload file*/
	// /**begin upload file*/
	// public function uploadfile($path, $name) {
	// 	if (!is_dir($path)) {
	// 		mkdir($path, 0777, true);
	// 		chmod($path, 0777);
	// 	}
	// 	$tmpName = pathinfo($_FILES[$name]['name']);
	// 	$config = array('upload_path' => $path,
	// 		'allowed_types' => 'doc|pdf|docx|xlsx|xls|gif|jpg|png|txt|zip|rar',
	// 		'file_name' => mb_strtolower(url_title($tmpName['filename'], '-', true)),
	// 		'max_size' => '10000');
	// 	$this->load->library("upload", $config);
	// 	$this->upload->initialize($config);
	// 	if (!$this->upload->do_upload($name)) {
	// 		$error = array($this->upload->display_errors());
	// 		return 0;
	// 	} else {
	// 		$image_data = $this->upload->data();
	// 		return $image_data;
	// 	}
	// }
	// /**end upload file*/

	// /**begin upload video*/
	// public function uploadvideo($path, $name) {
	// 	if (!is_dir($path)) {
	// 		mkdir($path, 0777, true);
	// 		chmod($path, 0777);
	// 	}
	// 	$tmpName = pathinfo($_FILES[$name]['name']);
	// 	$config = array('upload_path' => $path,
	// 		'allowed_types' => 'mp4|3gp|avi|flv|mp3',
	// 		'file_name' => mb_strtolower(url_title($tmpName['filename'], '-', true)),
	// 		'max_size' => '200000');
	// 	$this->load->library("upload", $config);
	// 	$this->upload->initialize($config);
	// 	if (!$this->upload->do_upload($name)) {
	// 		$error = array($this->upload->display_errors());
	// 		return 0;
	// 	} else {
	// 		$image_data = $this->upload->data();
	// 		return $image_data;
	// 	}
	// }
	// /**end upload video*/

	// /**begin upload video*/
	// public function uploadaudio($path, $name) {
	// 	if (!is_dir($path)) {
	// 		mkdir($path, 0777, true);
	// 		chmod($path, 0777);
	// 	}
	// 	$tmpName = pathinfo($_FILES[$name]['name']);
	// 	$config = array('upload_path' => $path,
	// 		'allowed_types' => 'mp3',
	// 		'file_name' => mb_strtolower(url_title($tmpName['filename'], '-', true)),
	// 		'max_size' => '100000');
	// 	$this->load->library("upload", $config);
	// 	$this->upload->initialize($config);
	// 	if (!$this->upload->do_upload($name)) {
	// 		$error = array($this->upload->display_errors());
	// 		return 0;
	// 	} else {
	// 		$image_data = $this->upload->data();
	// 		return $image_data;
	// 	}
	// }
	// /**end upload video*/

	public function trashFile($path, $name) {
		if (file_exists($path . '/' . $name)) {
			unlink($path . '/' . $name);
		}
	}

	public function delFolder($target)
	{
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
            foreach( $files as $file )
            {
                $this->delFolder($file);      
            }
            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );  
        }
    }
}
