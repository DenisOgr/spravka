<?
Class Client_request {

	private $mime_mail,$verify=true;

	function __construct(){
	}

	function verify_fill() {
					Xml::add_node('root','content');
		if (trim($_POST['fio'])=='' || trim($_POST['tel'])==''  || trim($_POST['email'])==''  || trim($_POST['question'])=='') {
			$this->verify = false;
			Xml::add_node('request', 'error', 'Все поля обязательны для заполнения.');
		} elseif ($_POST['email']!='' && !ereg('^[^@]+@[^@]+\.[^@\.]+$',$_POST['email'])) {
			$this->verify = false;
			Xml::add_node('request', 'error','Указан неправильный E-mail.');
		}else {
			Xml::add_node('request', 'success','Информация успешно отправлена.');
		}
		return $this->verify;
	}


	function show() {
		if (isset($_POST['send_re']) && $this->verify_fill()) {
			$this->send_request();
			Xml::add_node('content','request','1');
		} elseif (!$this->verify) {
			XML::from_array($_POST,'content','request_add');
		}
	}

	function send_request(){
		foreach ($_POST as $key => $val) {
			$_POST[$key]=strip_tags($val);
		}
		$mail=new html_mime_mail();
		$html = '<html><body>
		Это письмо сформировано автоматически. Не нужно на него отвечать.
		<br><br>
		<h1>Заявка</h1><br>
		<table>
			<tr><td>ФИО:</td><td>'.$_POST['fio'].'</td></tr>
			<tr><td>Телефон:</td><td>'.$_POST['tel'].'</td></tr>
			<tr><td>Email:</td><td><a href="mailto: '.trim($_POST['email']).'">'.$_POST['email'].'</td></tr>
			<tr><td>Вопрос:</td><td>'.$_POST['question'].'</td></tr>
			</table>
			</body></html>';
		$mail->add_html(iconv('UTF-8', 'CP1251', $html)); //вот вам куча хтмля
		$mail->build_message('w'); // Кодировка...
		$mail->send('ener-info@rambler.ru', 'olgasouz@rambler.ru', iconv('UTF-8', 'CP1251', 'Заявка')) ;
	}
}
?>