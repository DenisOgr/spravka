<?
Class Admin_comments {
	private $db,$var,$verify=true, $index, $cursor;
	
	function __construct(){
		$this->db=new DB();
		if (isset($_GET['delete_item'])) {
			$this->delete_item($_GET['delete_item']);
		}
		if (isset($_POST['cancel'])) {
			unset($_GET['edit_item'],$_GET['add']);
		}
		if (isset($_GET['image_item'])) {
			$this->image($_GET['image_item']);
		}
		
		if (isset($_POST['save_item']) && $this->verify_fill()) {
			if (isset($_GET['edit_item'])) {
				$this->save_item(intval($_GET['edit_item']));
			} else {
				$this->save_item(null);
			}
			header('Location: '.HOST.'?section='.$_GET['section']);
			die();
		}
	}
	
	function show() {
		if (isset($_GET['edit_item'])) {
			$xml=$this->get_item($_GET['edit_item']);
		} elseif (isset($_GET['add'])) {
			$xml=$this->get_item(null);
		} else {
			$xml=$this->get_list();
		}
		if (isset($this->cursor)) {
			(is_null($this->index)) ? $this->index=$this->cursor : $this->index=array_merge($this->index,$this->cursor);
		}	
		//XML::debug();
		return XML::transform('content',$this->xsl);
	}
	
	function verify_fill() {
		if (trim($_POST['name'])=='' || trim($_POST['text'])=='') {
			$this->verify = false;
			Message::error('Поля, отмеченные * обязательны для заполнения');
		}
		return $this->verify;
	}
	
	function get_item($id) {
		$this->xsl=MODULES.'comments/item_comments';
		if (!$this->verify) {
			XML::from_array($_POST,'item_comments');
		} elseif (!is_null($id)) {
			XML::from_db('SELECT *, DATE_FORMAT(date_add,"%d.%m.%Y") as date_add FROM comments WHERE id=?',$id,'item_comments');
		}
		XML::add_node('item_comments',null, array('today'=>date('d.m.Y')));
	}
	
	function get_list() {
		$this->xsl=MODULES.'comments/list_comments';
		XML::from_db('SELECT *, DATE_FORMAT(date_add,"%d.%m.%Y") as date_add, active FROM comments ORDER BY date_add DESC',null,'list_comments');
		XML::add_node('list_comments',null, array('section'=>$_GET['section']));
	}
	
	function save_item($id) {
		if ($id!=null) {
			if ($id!=0) {
				$res=$this->db->query('UPDATE comments SET name=?, date_add=?, text=? WHERE id=?', array($_POST['name'], general::date2db($_POST['date_add']), $_POST['text'], $id));
			}
		} else {
			$res=$this->db->query('INSERT comments SET name=?, date_add=?, text=?', array($_POST['name'], general::date2db($_POST['date_add']), $_POST['text']));
		}
	}
	
	function delete_item($id) {
		$res=$this->db->query('DELETE FROM comments WHERE id=?',$id);
	}

}
