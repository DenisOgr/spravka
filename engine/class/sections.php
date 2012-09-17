<?php
class sections {
	public $db, $ar, $ar_plain;

	function __construct($all=false) {
		$this->db = new Db ();
		$this->ar=$this->get_sections($all);
	}

	function update_plain() {
		$res = $this->db->query ( 'SELECT * FROM `section` WHERE `sys`="0" ORDER BY `priority`' );
		while ( $row = $this->db->fetch ( $res ) ) {
			$this->ar_plain[$row['id']]=$row;
		}
	}

	function get_sections($all) {
		$ar = array ();
		$add_query = ($all) ? $all : '`sys`="0"';
		$res = $this->db->query ( 'SELECT a.id, a.id_parent, a.name, a.module, (SELECT SUM(count) FROM count WHERE section=a.id) AS count FROM `section` AS a WHERE '.$add_query.' ORDER BY `priority`' );
		while ( $row = $this->db->fetch ( $res ) ) {
			$ar [intval ( $row ['id_parent'] )] [$row ['id']] = $row;
			$this->ar_plain[$row['id']]=$row;
		}
		$ar=array_reverse($ar,true);
		foreach ($ar as $key=>$value) {
			if ($key!=0) {
				$item=array();
				$item[$key]=$ar[$key];
				unset($ar[$key]);
				$ar=$this->get_tree($ar,$item,$key);
			}
		}
		return $ar;
	}

	function get_tree($ar,$item,$key_in) {
		foreach ($ar as $key=>$value) {
			if (is_numeric($key)) {
				if ($key_in==$key) {
					$ar[$key][0]=$item[$key_in];
					return $ar;
				} elseif (is_array($value)) {
					$ar[$key]=$this->get_tree($value,$item,$key_in);
				}
			}
		}
		return $ar;
	}
	
	
	

}