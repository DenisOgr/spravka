<?
Class Message {
  //private static $messages=array();

  static function error($str,$area='content') {
    $_SESSION['messages'][$area]['error'][]=$str;
  }

  static function success($str,$area='content') {
    $_SESSION['messages'][$area]['success'][]=$str;
  }

  static function get() {
    if (isset($_SESSION['messages'])) {
      $messages=array('messages'=>$_SESSION['messages']);
      unset($_SESSION['messages']);
    } else {
      $messages=array();
    }
    return $messages;
  }
}
?>