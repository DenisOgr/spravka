<?

class Error {

  static function report ($param = '', $manual = false) {
    if (is_array($param)) {
      $param = implode('<hr>', $param);
    }
    $serv = array();
    $serv['HTTP_USER_AGENT'] = @$_SERVER['HTTP_USER_AGENT'];
    $serv['HTTP_X_FORWARDED_FOR'] = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $serv['HTTP_X_REAL_IP'] = @$_SERVER['HTTP_X_REAL_IP'];
    $serv['REMOTE_ADDR'] = @$_SERVER['REMOTE_ADDR'];
    if (! $manual) {
      $email=EMAIL_REPORT;
      $default = array('$_SERVER' => $serv , '$_GET' => $_GET , '$_POST' => $_POST , '$_SESSION' => $_SESSION , 'BACKTRACE' => debug_backtrace());
      $subject = 'ERROR report ';
      foreach ($default as $key => $value) {
        $param .= '<hr><b>' . $key . '</b><br>' . highlight_string("<?\n" . stripslashes(str_replace('\\\\', '/', var_export($value, true))) . "\n?>", true);
      }
      $str = '<div style="background: #EEE; margin: 10px 10%; border: 1px solid #CCC; padding:3px;">
         <div style="border: 1px solid #CCC; color: #F00; padding:3px;font-size:14px;">' . $param . '</div></div>';
      $subject .= (isset($_SERVER)) ? $_SERVER['REQUEST_URI'] : 'cron';
    }
    if (DEBUG == 0) {
    /*  if ($_GET['path'] != 'register/') {
        $ml = new sendmail();
        $ml->addHtml($str);
        $ml->send($email, $subject);
      }*/
    } else {
      echo $str;
    }
  }
}
?>