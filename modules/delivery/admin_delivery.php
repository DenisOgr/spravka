<?
Class Admin_delivery {
  private $db,$var,$verify=true;

  function __construct(){
    $this->db=new DB();
    if (isset($_POST['save']) && $this->verify_fill()) {
      if ($this->exist_delivery($_GET['section'])) {
        $this->save_item(intval($_GET['section']));
      } else {
        $this->save_item(null);
      }
      header('Location: '.HOST.'?section='.$_GET['section']);
      die();
    } elseif (isset($_POST['test_delivery'])) {
      //echo 'test_delivery';
      $this->test_delivery();
    } elseif (isset($_POST['in_start_delivery'])) {
      //var_dump($_POST['in_start_delivery']);
      
      if ($_POST['in_start_delivery'] == 'new') {
        $this->start_delivery(COUNT_DELIVERY, $_GET['section'], 0, 1);
      } else {
        $this->start_delivery(COUNT_DELIVERY, $_GET['section']);
      }
    } elseif (isset($_POST['error_delivery'])) {
      //echo 'error_delivery';
      $this->start_delivery(COUNT_DELIVERY, $_GET['section'], 1);;
    }

  }

  function show() {
    $this->xsl=MODULES.'delivery/admin_delivery';

    if (isset($_GET['section'])) {
      $xml1=$this->get_item($_GET['section']);
      $xml2=$this->get_email($_GET['section']);
      
    }
    /* elseif (isset($_GET['add'])) {
    $xml=$this->get_item(null);
    } else {
    $xml=$this->get_list();
    }
    */
    //XML::debug();

    return XML::transform('content',$this->xsl);
  }

  function verify_fill() {
    if (trim($_POST['text'])=='') {
      $this->verify = false;
      Message::error('Поля, отмеченные * обязательны для заполнения');
    }
    return $this->verify;
  }

  function get_item($id) {
    if (!is_null($id)) {
      XML::from_db( 'SELECT * FROM delivery WHERE id_section=?',$id,'delivery','item');
    } else {
      XML::from_array($_POST,'delivery','item');
    }
  }
  
  function get_email($id_section) {
      $info['all'] = $this->db->get_one("SELECT Count(`delivery_clients`.`id`) FROM `delivery_clients` WHERE id_section=?", array($id_section));
      $info['not_send'] = $this->db->get_one("SELECT Count(`delivery_clients`.`id`) as not_send FROM `delivery_clients` WHERE `delivery_clients`.`status` = ? and id_section = ?", array(0, $id_section));
      $info['send'] = $this->db->get_one("SELECT Count(`delivery_clients`.`id`) as send FROM `delivery_clients` WHERE `delivery_clients`.`status` = ? and id_section= ?",array(1, $id_section));
      $info['error_send'] = $this->db->get_one("SELECT Count(`delivery_clients`.`id`) as error_send FROM `delivery_clients` WHERE `delivery_clients`.`status` = ? and id_section = ?", array(2, $id_section));
      $info['finished'] = ($info['all'] == $info['send']) ? (1) : (0);
      XML::from_array($info, 'delivery', 'info');
      XML::from_db( 'SELECT `delivery_clients`.`id`, `delivery_clients`.`name`, `delivery_clients`.`email`, `delivery_clients`.`status` FROM `delivery_clients`
      WHERE `delivery_clients`.`id_section` = ? ORDER BY `delivery_clients`.`status` DESC', $id_section, 'delivery','stat');
  }


  function save_item($id) {
    if ($id!=null) {
      $res=$this->db->query('UPDATE delivery SET text=?, subject=? WHERE id_section=?', array($_POST['text'], $_POST['subject'], $_GET['section']));
    } else {
      $res=$this->db->query('INSERT delivery SET id_section=?, text=?, subject=? ', array($_GET['section'], $_POST['text'], $_POST['subject']));
    }
  }


  function exist_delivery($id_section) {
    $count = $this->db->get_one("SELECT Count(`delivery`.`id_section`) FROM `delivery` WHERE `delivery`.`id_section` = '{$id_section}'");
    return ($count) ? true : false;
  }

  function send_mail($mail, $subject, $message) {
    return General::email_inform($mail, $subject, $message);
  }

  function test_delivery() {
    if (isset($_GET['section'])) {
      $id = $_GET['section'];
      $text_mail = $this->db->get_row("SELECT `delivery`.`subject`, `delivery`.`text` FROM `delivery` WHERE `delivery`.`id_section` = '{$id}'");
      if ($this->send_mail(EMAIL_ADMIN,$text_mail['subject'],$text_mail['text']) == true) {
        Message::success('Тестовая рассылка отправлена вам на e-mail.');
      } else {
        Message::error('Произошла ошибка, при отправке тестовой рассылки.');
      }
    }
  }
  
  function start_delivery($count, $id_section, $error=0, $new=0) {
    if ($new) {
      $this->db->query("UPDATE `delivery_clients` SET `status`='0' WHERE (`id_section`='{$id_section}' )");
    }
    $text_mail = $this->db->get_row("SELECT `delivery`.`subject`, `delivery`.`text` FROM `delivery` WHERE `delivery`.`id_section` = '{$id_section}'");
    if ($count==0 || $count < 0) {
      $count = 10;
    }
    ($error == 1) ? ($status = 2) : ($status = 0);
    $data = $this->db->get_all("SELECT `delivery_clients`.`id`, `delivery_clients`.`email` FROM `delivery_clients` WHERE `delivery_clients`.`id_section` = '{$id_section}' AND `delivery_clients`.`status` = {$status} LIMIT {$count}");
    //var_dump($data);
    foreach ($data as $value) {
    	if ($this->send_mail($value['email'], $text_mail['subject'], $text_mail['text'])) {
    	  $this->set_status_delivery($value['id'], 1);
    	} else {
    	  $this->set_status_delivery($value['id'], 2);
    	}
    }
  }
  
  
  function set_status_delivery($id, $status) {
    $this->db->query("UPDATE `delivery_clients` SET `status`='{$status}' WHERE (`id`='{$id}') ");
  }
  
}
