<?
Class Client_registration {
  private $db, $verify=true;
  function __construct(){
    $this->db=new DB();
    if (isset($_POST['send']) && $this->verify_fill()) {
      $this->send();
    } else {
      $this->form();
    }
  }

  function show() {
    return XML::get_dom();
  }

  function verify_fill() {
    if (trim($_POST['name'])=='' || trim($_POST['phone'])=='' || (!isset($_POST['service'])) || trim($_POST['date'])=='' || trim($_POST['hour'])=='' || trim($_POST['minute'])=='') {
      $this->verify = false;
      Message::error('Ошибка! Все поля обязательны для заполнения!');
    } else {
      Message::success('Заявка отправлена');
    }
    return $this->verify;
  }

  function send() {
                        $services=array('консультация','лечение','удаление','протезирование','имплантация');
    $message='<table>
                        <tr>
                            <td width="50%">Ф.И.О.</th>
                            <td>
                            '.$_POST['name'].'    
                            </td>
                        </tr>
                        <tr>
                            <td>Контактный телефон</th>
                            <td>
                            '.$_POST['phone'].'
                            </td>
                        </tr>
                        <tr>
                            <td>Услуга</th>
                            <td>
                            '.$services[$_POST['service']-1].'
                            </td>
                        </tr>
                        <tr>
                            <td>день и время на которые хотели бы записаться на прием</th>
                            <td>
                               '.$_POST['date'].' '.$_POST['hour'].':'.$_POST['minute'].' 
                            </td>
                        </tr>
                </table>';
    General::email_inform(EMAIL_ADMIN,'Запись пациента',$message);
    $this->db->query('INSERT `registration` SET name=?, phone=?, service=?, date=?', array($_POST['name'], $_POST['phone'], $services[$_POST['service']-1], General::date2db($_POST['date']).' '.$_POST['hour'].':'.$_POST['minute']));
    XML::add_node('content','registration','send');
  }

  function form() {
    if (!$this->verify) {
      XML::add_node('content','registration',$_POST);
    }
    $day=60*60*24;
    XML::add_node('content','registration',array('date'=>date('d.m.y',time()+$day)));

  }
}
