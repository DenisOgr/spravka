<?
Class General {
  static function indent($value) {
    return str_repeat('&#160;&#160;&#160;',$value);
  }

  static function date2db($date){
    $date=str_replace('/','.',$date);
    return preg_replace('/([0-9]+)\.([0-9]+)\.([0-9]+)/','\\3-\\2-\\1',$date);
  }

  static function email_inform($to, $subject, $message, $add_from='') {
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=windows-1251\r\n";
    $headers .= "From: " . $add_from .'<'.EMAIL_FROM.'>'."\r\n";
    $headers .= "CC: ".EMAIL_CC;
    $message = str_replace('#2#','2',$message);
    $message = iconv('UTF-8', 'CP1251', $message);
    $subject = iconv('UTF-8', 'CP1251', $subject);
    $f = mail($to, $subject, $message, $headers);
    return $f;
  }

}