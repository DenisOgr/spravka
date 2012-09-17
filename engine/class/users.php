<?php
class Users {
  private $table, $db;
  function __construct($table) {
    $this->table=$table;
    $this->db = new Db;
    if (isset($_POST['entry'])) {
      $this->login();
    } elseif (isset($_GET['logout'])) {
      $this->logout();
    } elseif (isset($_POST['change_pass'])) {
      $this->change_pass();
    }
  }

  function logout(){
    unset($_SESSION);
    session_destroy();
  }

  function login(){
    if (trim($_POST['login'])!='' && trim($_POST['password'])!='') {
      $login=$this->db->get_row('select * from ! where login=? and password=md5(?)', array($this->table,$_POST['login'],$_POST['password']));
      if ($login) {
        $_SESSION['login']=true;
        $_SESSION['user']=$_POST['login'];
      } else {
        Message::error('Доступ запрещен');
      }
    } else {
      Message::error('Оба поля должны быть заполнены');
    }
  }
  
  function change_pass(){
  	if ($this->is_logged_in()){
	    if (trim($_POST['password'])!='' && trim($_POST['password2'])!='' && $_POST['password']==$_POST['password2']) {
  			$this->set_pass();  			
    	} else {
     	 Message::error('Оба поля должны быть заполнены и их значения должны совпадать.');
    	}
  	}
  }
  
  function set_pass(){
      $this->db->query('UPDATE ! SET password=? where login=?', array($this->table,md5($_POST['password']),$_SESSION['user']));
       Message::success('Пароль изменён.');
  }

  function is_logged_in(){
    return (isset($_SESSION['login']));
  }

  function login_form() {
    XML::add_node('login_form',null,Message::get());
  }

}
?>