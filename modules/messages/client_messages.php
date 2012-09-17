<?
Class Client_messages {
	private $verify=true;
  function __construct(){
  }

  function show($id) {
    XML::add_node('messages');
		//$this->show_comments();
		//$this->show_anket();
		
			if (isset($_POST['send_re']) && $this->verify_fill()) {
			$this->send_request();
			Xml::add_node('messages','request','1');
		} elseif (isset($_POST['send2']) && $this->verify_fill2()) {
			$this->send_request2();
			Xml::add_node('messages','request','1');
		} elseif (!$this->verify) {
			XML::from_array($_POST,'messages','request_add');
		}
		
    return XML::get_dom();
  }


	function verify_fill() {
		if (trim($_POST['fio'])=='' || trim($_POST['tel'])==''  || trim($_POST['email'])==''  || trim($_POST['question'])=='') {
			$this->verify = false;
			Xml::add_node('messages', 'error', 'Все поля обязательны для заполнения.');
		} elseif ($_POST['email']!='' && !ereg('^[^@]+@[^@]+\.[^@\.]+$',$_POST['email'])) {
			$this->verify = false;
			Xml::add_node('messages', 'error','Указан неправильный E-mail.');
		}else {
			Xml::add_node('messages', 'success','Информация успешно отправлена.');
		}
		return $this->verify;
	}

	
	function verify_fill2() {
		if (trim($_POST['pole1'])=='' || 
		trim($_POST['pole2'])=='' || 
		trim($_POST['pole3'])=='' || 
		trim($_POST['pole6'])=='' || 
		trim($_POST['pole9'])=='') {
			$this->verify = false;
			Xml::add_node('messages', 'error', 'Поля отмеченные * обязательны для заполнения.');
		} elseif ($_POST['pole7']!='' && !ereg('^[^@]+@[^@]+\.[^@\.]+$',$_POST['pole7'])) {
			$this->verify = false;
			Xml::add_node('messages', 'error','Указан неправильный E-mail.');
		}else {
			Xml::add_node('messages', 'success','Информация успешно отправлена.');
		}
		return $this->verify;
	}
  
  
	function send_request(){
		foreach ($_POST as $key => $val) {
			$_POST[$key]=strip_tags($val);
		}
		$mail=new html_mime_mail();
		$html = '<html><body>
		Это письмо сформировано автоматически. Не нужно на него отвечать.
		<br><br>
		<h2>Заказать услугу/задать вопрос</h2><br>
		<table>
			<tr><td>ФИО:</td><td>'.$_POST['fio'].'</td></tr>
			<tr><td>Телефон:</td><td>'.$_POST['tel'].'</td></tr>
			<tr><td>Email:</td><td><a href="mailto: '.trim($_POST['email']).'">'.$_POST['email'].'</td></tr>
			<tr><td>Вопрос:</td><td>'.$_POST['question'].'</td></tr>
			</table>
			</body></html>';
		$mail->add_html(iconv('UTF-8', 'CP1251', $html)); //вот вам куча хтмля
		$mail->build_message('w'); // Кодировка...
		$mail->send('zombi_113@ukr.net', 'zombi_113@ukr.net', iconv('UTF-8', 'CP1251', 'Заказать услугу/задать вопрос')) ;
	}
  
	function send_request2(){
		foreach ($_POST as $key => $val) {
			$_POST[$key]=strip_tags($val);
		}
		$mail=new html_mime_mail();
		$html = '<html><body>
		Это письмо сформировано автоматически. Не нужно на него отвечать.
		<br><br>
		<h2>Заявка на подбор персонала</h2><br>
		
		<table align="left">
              <tr>
                <td>Контактное лицо для обсуждения заказа (ФИО):</td>
                <td>
                  '.$_POST['pole1'].'
                </td>
              </tr>
              <tr>
                <td>Должность:</td>
                <td>
                  '.$_POST['pole2'].'
                </td>
              </tr>
              <tr>
                <td>Компания:</td>
                <td>
                  '.$_POST['pole3'].'
                </td>
              </tr>
              <tr>
                <td>Направление деятельности:</td>
                <td>
                  '.$_POST['pole4'].'
                </td>
              </tr>
              <tr>
                <td>Адрес:</td>
                <td>
                  '.$_POST['pole5'].'
                </td>
              </tr>
              <tr>
                <td>Тел./Факс:</td>
                <td>
                  '.$_POST['pole6'].'
                </td>
              </tr>
              <tr>
                <td>e-mail:</td>
                <td>
									<a href="mailto: '.trim($_POST['pole7']).'">'.$_POST['pole7'].'</a>
								</td>
              </tr>
              <tr>
                <td>web-сайт:</td>
                <td>
                  '.$_POST['pole8'].'
                </td>
              </tr>
              <tr>
                <td>Вакансия:</td>
                <td>
                  '.$_POST['pole9'].'
                </td>
              </tr>
              <tr>
                <td>Должностные обязанности:</td>            
                <td>
                  '.$_POST['pole10'].'
                </td>
              </tr>
              <tr>
                <td>Уровень образования:</td>
                <td>
                  '.$_POST['pole11'].'
                </td>
              </tr>
              <tr>
                <td>Возраст:</td>
                <td>
                  '.$_POST['pole12'].'
                </td>
              </tr>
              <tr>
                <td>Иностранные языки:</td>
                <td>
                  '.$_POST['pole13'].'
                </td>
              </tr>
              <tr>
                <td>Проффесиональные навыки:</td>            
                <td>
                  '.$_POST['pole14'].'
                </td>
              </tr>
              <tr>
                <td>Дополнительные требования:</td>            
                <td>
                  '.$_POST['pole15'].'
                </td>
              </tr>
              <tr>
                <td>Размер оплаты труда (оклад) + бонусы, премии, %</td>
                <td>
                  '.$_POST['pole16'].'
                </td>
              </tr>
              <tr>
                <td>Дополнительная информация:</td>            
                <td>
                  '.$_POST['pole17'].'
                </td>
              </tr>
            </table>
			</body></html>';
		$mail->add_html(iconv('UTF-8', 'CP1251', $html)); //вот вам куча хтмля
		$mail->build_message('w'); // Кодировка...
		$mail->send('zombi_113@ukr.net', 'zombi_113@ukr.net', iconv('UTF-8', 'CP1251', 'Заявка на подбор персонала')) ;
	}
  
  
}

?>