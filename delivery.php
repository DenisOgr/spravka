<?
header('Content-type: text/html; charset=UTF-8');
session_start();
include 'config.php';
include 'engine/init.php';


function start_delivery( $id_section) {
  $db = new Db();
  $text_mail = $db->get_row("SELECT `delivery`.`subject`, `delivery`.`text` FROM `delivery` WHERE `delivery`.`id_section` = '{$id_section}'");
  $data = $db->get_all("SELECT `delivery_clients`.`id`, `delivery_clients`.`email` FROM `delivery_clients` WHERE `delivery_clients`.`id_section` = '{$id_section}' AND `delivery_clients`.`status` = 0 LIMIT ".COUNT_DELIVERY);
  foreach ($data as $value) {
    if (send_mail($value['email'], $text_mail['subject'], $text_mail['text'])) {
      set_status_delivery($value['id'], 1);
    } else {
      set_status_delivery($value['id'], 2);
    }
  }
}

function send_mail($mail, $subject, $message) {
  return General::email_inform($mail, $subject, $message);
}

function set_status_delivery($id, $status) {
  $db = new Db();
  $db->query("UPDATE `delivery_clients` SET `status`='{$status}' WHERE (`id`='{$id}') ");
}

start_delivery('18');
?>