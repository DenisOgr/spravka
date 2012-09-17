<?
Class Admin_messages {
  private $db, $verify=true;

  function __construct(){
  }

  function show() {
    $this->xsl=MODULES.'messages/admin_messages';
    XML::add_node('messages','trash');
    return XML::transform('content',$this->xsl);
  }
}
