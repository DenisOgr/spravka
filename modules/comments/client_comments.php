<?
Class Client_comments {
	private $db;
	function __construct(){
		$this->db=new DB();
	}

	function show($id) {
		$xml=$this->get_list($id);
		return XML::get_dom();
	}

	function get_list($id) {
		XML::from_db('SELECT *, DATE_FORMAT(date_add,"%d.%m.%Y") as date_add FROM comments ORDER BY date_add DESC',null,'comments','item');
		if (isset($_SESSION['uid']) && isset($_SESSION['network'])) {
			XML::from_db('SELECT * FROM users WHERE uid=? AND network=?',array($_SESSION['uid'],$_SESSION['network']), 'comments', 'user');
		}
	}

}
