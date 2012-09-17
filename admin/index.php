<?
header('Content-type: text/html; charset=UTF-8');
session_start();
include '../config.php';
include ENGINE.'init.php';

$user = new Users('supervisor');
if ($user->is_logged_in()){
  $ctrl= new Admin_Control;
  $ctrl->show();
} else {
  $user->login_form();
}
  echo str_replace(':8080','',XML::dom2str(XML::transform(null,ENGINE.'xsl/admin_index')));  
?>