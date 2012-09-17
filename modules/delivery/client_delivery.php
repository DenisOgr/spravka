<?
Class Client_delivery {
  private $db, $page, $images_count, $image_width, $image_height;

  function __construct() {
    $this->db=new DB();
    if (isset($_POST['delivery'])) {
      if ($_POST['delivery'] == 'on') {
        if (isset($_POST['email']) && $_POST['email']!='') {
          $this->delivery_on($_POST['name'], $_POST['email'], $_POST['section']);
        }
      } else {
        if (isset($_POST['email']) && $_POST['email']!='') {
          $this->delivery_off($_POST['email']);
        }
      }
    }
  }

  function show($id) {
    XML::add_node('delivery','section',$id);
    return XML::get_dom();
  }


  function delivery_on($name, $email, $id_section) {
    if ($this->exist_email($email) == false) {
      $this->db->query("INSERT INTO `delivery_clients` (`id`, `name`,`id_section`,`email`) VALUES (NULL,'{$name}' ,'{$id_section}','{$email}')");
      //Message::success("Ваш email успешно добавлен в расслку");
    } else {
      //Message::success("Ваш email уже присутствует");
    }
  }
  
  function delivery_off($email) {
    if ($this->exist_email($email)) {
      
      $this->db->query("DELETE FROM `delivery_clients` WHERE (`email`='{$email}')");
      //Message::success("Ваш email успешно удален с рассылки");
    } else {
      //var_dump($email);
      //Message::error("Данного email нет в рассылке");
    }
  }

  function exist_email($email) {
    $count = $this->db->get_one("SELECT Count(`delivery_clients`.`id`) FROM `delivery_clients` WHERE `delivery_clients`.`email` = '{$email}' ");
    return ($count) ? true : false;
  }
}
