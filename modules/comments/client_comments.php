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
		if (isset($_POST['token'])) {
			$s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
			$user = json_decode($s, true);
			var_dump($user);echo '<hr/>';
			if (isset($user) && !isset($user['error'])) {
				var_dump('1');
				XML::from_array($user, 'comments', 'user');
			}
		}
		//$user['network'] - соц. сеть, через которую авторизовался пользователь
		//$user['identity'] - уникальная строка определяющая конкретного пользователя соц. сети
		//$user['first_name'] - имя пользователя
		//$user['last_name'] - фамилия пользователя

		XML::from_db('SELECT *, DATE_FORMAT(date_add,"%d.%m.%Y") as date_add FROM comments ORDER BY date_add DESC',null,'comments','item');
	}

}
