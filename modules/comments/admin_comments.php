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
		if (isset($_POST['save_item']) && $this->verify_fill()) {
			if (isset($_GET['edit_item'])) {
				$this->save_item(intval($_GET['edit_item']));
			} 
			header('Location: '.HOST.'?section='.$_GET['section']);
			die();
		}
	}
	
	function show() {
		if (isset($_GET['edit_item'])) {
			$xml=$this->get_item($_GET['edit_item']);
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
		if (trim($_POST['text'])=='' || trim($_POST['text'])=='') {
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
			XML::from_db('SELECT c.text, DATE_FORMAT(c.date_add,"%d.%m.%Y") as date_add, u.first_name, u.last_name, u.photo, u.profile FROM comments As c, users u WHERE c.id_user=u.id AND c.id=?',$id,'item_comments');
		}
		XML::add_node('item_comments',null, array('today'=>date('d.m.Y')));
	}
	
	function get_list() {
		$this->xsl=MODULES.'comments/list_comments';
		XML::from_db('SELECT c.id, c.text, DATE_FORMAT(c.date_add,"%d.%m.%Y %H:%i:%s") as date_add, u.first_name,u.last_name, u.photo  FROM comments As c, users AS u WHERE c.id_user=u.id ORDER BY c.date_add DESC',null,'list_comments');
		XML::add_node('list_comments',null, array('section'=>$_GET['section']));
	}
	
	function save_item($id) {
		if ($id!=null) {
			if ($id!=0) {			
				$this->db->query('UPDATE INTO comments SET text=? WHERE id=?', $id);		
			}
		} 
	}
	
	function delete_item($id) {
		$this->db->query('DELETE FROM comments WHERE id=?',$id);
	}

	/* function active_item($id) {
		$this->db->query('UPDATE comments SET active=1 WHERE id=?',$id);
	} */
}
