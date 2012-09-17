<?php
class Admin_section {
	private $db, $ar, $index, $mites, $cursor, $add_ar;

	function __construct() {
		$this->db=new Db;

		if (isset ($_GET['section_delete']) && isset ($_GET['priority'])) {
			if (!isset($_GET['parent']) || $_GET['parent']==''){
				$_GET['parent']='NULL';
			}
			$this->delete($_GET['section_delete'],$_GET['priority'],$_GET['parent']);
		}

		if (isset($_GET['move_up']) && isset($_GET['priority'])) {
			if (!isset($_GET['parent']) || $_GET['parent']==''){
				$_GET['parent']='NULL';
			}
			$this->move($_GET['priority'],$_GET['move_up'],-1,$_GET['parent']);
		}

		if (isset($_GET['move_down']) && isset($_GET['priority'])) {
			if (!isset($_GET['parent']) || $_GET['parent']==''){
				$_GET['parent']='NULL';
			}
			$this->move($_GET['priority'],$_GET['move_down'],+1,$_GET['parent']);
		}

		if (isset ($_GET['section_edit'])) {
			$this->edit($_GET['section_edit']);
		}

		if (isset ($_GET['section_add'])) {
			$this->add($_GET['section_add']);
		}

		if (isset ($_GET['section_hide'])) {
			$this->show_hide(0,$_GET['section_hide']);
		}

		if (isset ($_GET['section_show'])) {
			$this->show_hide(1,$_GET['section_show']);
		}

		if (isset($_GET['section_image'])) {
			$this->image($_GET['section_image']);
		}

	}

	function move($priority,$id,$k,$parent) {
		if ($parent=='NULL'){
			$this->db->query('UPDATE section SET priority=? WHERE priority=? AND id_parent IS NULL',array($priority,$priority+$k));
		} else {
			$this->db->query('UPDATE section SET priority=? WHERE priority=? AND id_parent=?',array($priority,$priority+$k,$parent));
		}
		$this->db->query('UPDATE section SET priority=? WHERE id=?', array($priority+$k,$id));
	}

	function delete($id,$priority,$parent) {
		$this->db->query('DELETE FROM section WHERE id=?',$id);
		if ($parent=='NULL'){
			$this->db->query('UPDATE section SET priority=priority-1 WHERE priority > ! AND id_parent IS NULL', array($priority));
		} else {
			$this->db->query('UPDATE section SET priority=priority-1 WHERE priority > ! AND id_parent=?', array($priority,$parent));
		}
	}

	function show_hide($visible,$id) {
		$this->db->query('UPDATE section SET visible="'.$visible.'" WHERE id=?', array($id));
	}

	function image($id) {
		$_SESSION['save_info']['class']='Admin_section';
		$_SESSION['save_info']['id']=$id;

		/*if (isset($_POST['section_image'])) {
		$this->db->query('UPDATE section SET image=! WHERE id=!', array($_POST['image'],$id));
		} else {*/
		$this->cursor['section_image']=$id;
		//}
	}

	function save_image($value) {
		$this->db->query('UPDATE section SET image=! WHERE id=!', array($value,$_SESSION['save_info']['id']));
	}

	function add($id) {
		if ($id=='') {
			$id='NULL';
		}
		if (isset($_POST['section_add']) && $_POST['section_name']!='') {
      $mod=$this->db->get_one('SELECT `sub_module` FROM `section` WHERE `id`=?', array($id));
      if(empty($mod)){
      	$mod='articles';
      }
      $this->db->query('INSERT section SET id_parent=!, name=?, module=?, sub_module=?, priority=?', array($id,$_POST['section_name'],$mod,$mod,$_POST['priority']));
		} else {
			$this->cursor['section_add']=$id;
		}
	}

	function edit($id) {
		if (isset($_POST['section_edit']) && $_POST['section_name']!='') {
			$this->db->query('UPDATE section SET name=?,alias=? WHERE id=?', array($_POST['section_name'],$_POST['section_alias'], $id));
		} else {
			$this->cursor['section_edit']=$id;
		}
	}

	function add_ar() {
		$count=count($this->index);
		for ($i=0; $i<$count; $i++) {
			$this->index[$i]['add']=$this->add_ar[$this->index[$i][0]];
		}
	}

	function get_section() {
		$ar=array();
		$res=$this->db->query('SELECT * FROM section ORDER BY priority');
		while ($row=$this->db->fetch($res)) {
			$ar[$row['id_parent']][]=$row['id'];
			$this->add_ar[$row['id']]['name']=$row['name'];
			$this->add_ar[$row['id']]['alias']=$row['alias'];
			$this->add_ar[$row['id']]['priority']=$row['priority'];
			$this->add_ar[$row['id']]['id_parent']=$row['id_parent'];
			$this->add_ar[$row['id']]['visible']=$row['visible'];
			$this->add_ar[$row['id']]['static']=$row['static'];
			$this->add_ar[$row['id']]['image']=$row['image'];
			$this->add_ar[$row['id']]['show_img']=$row['show_img'];
			$this->add_ar[$row['id']]['show_visibility']=$row['show_visibility'];
			$this->add_ar[$row['id']]['sub_module']=$row['sub_module'];
			if (isset($_GET['section']) && $_GET['section']==$row['id']) {
				$this->cursor['current_name']=$row['name'];
				$this->cursor['current_id']=$_GET['section'];
			}
		}
		return $ar;
	}

	function pass($i, $j) {
		if (isset($this->ar[$i][$j]) || ($i==-1 && $j==-1)) {
			if (isset($this->ar[$i][$j])) {
				$id_sect=$this->ar[$i][$j];
				$this->mites[]=array($i,$j);
			} else $id_sect=0;

			$this->index[]=array($id_sect, count($this->mites));
			/*if (isset($_GET['section']) && $_GET['section']==$id_sect) {
			$this->select=count($this->index)-1;
			}*/
			$this->pass($id_sect,0);
		} else {
			if ($i==0) {
				return 1;
			}
			// сделать чтобы стартовало с доступного id а не c 1
			list($i,$j)=@array_pop($this->mites);
			$this->pass($i,$j+1);
		}
	}

	function show() {
		$this->ar=$this->get_section();
		$this->pass(null,0);
		$this->add_ar();
		if (isset($this->cursor)) {
		(is_null($this->index)) ? $this->index=$this->cursor : $this->index=array_merge($this->index,$this->cursor);
		}
		XML::from_array($this->index,'section');


		return XML::get_dom();
		//XML::debug();
		//return XML::transform('section','admin/section');
	}

}
?>