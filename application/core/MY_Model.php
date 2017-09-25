<?php
class MY_Model extends CI_Model {

	protected $table = '';

	public function __construct() {
		parent::__construct();
	}

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
