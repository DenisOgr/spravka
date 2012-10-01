<?
Class Client_comments {
	private $db;
	function __construct(){
		$this->db=new DB();
	}

	function show($id) {
		if (isset($_POST['save_message'])) {
			$this->db->query('INSERT INTO comments SET id_item=?, date_add=NOW(), id_user=?, text=?, active=1', array($_GET['item'], $_POST['id_user'], $_POST['text']));
			$user = $this->db->get_row('SELECT * FROM users WHERE id=?', array($_POST['id_user']));		
			$send = new sendmail ();
			$send->addHtml ('
					<table>
					<tr>
					<th>Имя</th>
					<td>'.$user['first_name'].' '.$user['first_name'].'</td>
					</tr>
					<tr>
					<th>Отзыв</th>
					<td>'.$_POST['text'].'</td>
					</tr>
					</table>');
			$send->send ( EMAIL_ADMIN, 'Новый отзыв' ); 
		}
		
		$xml=$this->get_list($id);
		return XML::get_dom();
	}

	function get_list($id) {
		if (isset($_GET['item'])) {
			XML::from_array($_GET,'comments','get');
			XML::from_db('SELECT c.*, DATE_FORMAT(c.date_add,"%d.%m.%Y %H:%i:%s") as date_add, u.* FROM comments AS c, users AS u WHERE c.active=1 AND c.id_user=u.id AND c.id_item=? ORDER BY c.date_add DESC',$_GET['item'],'comments','item');
		}
		if (isset($_SESSION['uid']) && isset($_SESSION['network'])) {
			XML::from_db('SELECT * FROM users WHERE uid=? AND network=?',array($_SESSION['uid'],$_SESSION['network']), 'comments', 'user');
		}
	}

}
