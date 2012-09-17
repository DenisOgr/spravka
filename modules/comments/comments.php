<?
class comments extends Module {

	function __construct() {
		//fb::log($_SESSION);
		if (isset($_GET['ADMIN'])) {
			$field_verify = '{ "empty" : { "text" : "Отзыв", "name" : "Имя", "date_add" : "Дата"}}';
		} else {
			$field_verify = '{ "empty" : { "text" : "Отзыв"}}';
		}
		parent::__construct ( 'comments', null, $field_verify );
	}

	function cmd_list() {
		$this->get_list();
	}

	function brief() {
		$this->item_on_page_client=3;
		$this->get_list();
	}

	function cmd_save() {
		if (parent::verify()) {
			$_POST['active']=1;
			$_POST['name'] = $_SESSION['user']['first_name'].' '.$_SESSION['user']['last_name'];
			$_POST['photo_anons'] = $_SESSION['user']['avatar'];
			$_POST ['text'] = strip_tags ( $_POST ['text'] );
			parent::save(null,'Ваш отзыв добавлен');
			$send = new sendmail ();
			$send->addHtml ('
						<table>
						<tr>
						<th>Имя</th>
						<td>'.$_POST['name'].'</td>
						</tr>
						<tr>
						<th>Отзыв</th>
						<td>'.$_POST['text'].'</td>
						</tr>
						</table>');
			$send->send ( EMAIL_ADMIN, 'Новый отзыв' );
		}
	}

	function get_list() {
		$query = 'SELECT SQL_CALC_FOUND_ROWS a.*, DATE_FORMAT(a.date_add,"%d.%m.%Y") AS date_add FROM `'.$this->table.'` AS a';
		$order=' ORDER BY a.date_add DESC';
		if (isset($_GET['ADMIN'])) {
			parent::get_list($query.$order);
		} else {
			parent::get_list($query.' WHERE a.active=1 '.$order);
		}
	}
}