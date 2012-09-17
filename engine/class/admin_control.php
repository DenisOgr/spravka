<?
Class Admin_Control {
  function show() {
    $sec= new Admin_Section;
    $xml_section=$sec->show();

    if (isset($_GET['section'])) {
      if (isset($_GET['meta'])){
        $name_module='meta_tags';
      } elseif (isset($_GET['options'])){
        $name_module='options';
      } else {
        $name_module=$this->get_module_name($_GET['section']);}
        (is_null($name_module)) ? $name_module='Admin_articles' : $name_module='Admin_'.$name_module;
        $module = new $name_module;
    }
    /*if (isset($_GET['meta'])) {
    $meta= new Admin_meta_tags;
    $xml_content=$meta->show();
    echo "Тут мы метимся";
    } else {*/

    (isset($module))
    ?  $xml_content=$module->show()
    :  $xml_content='';
    XML::add_node('root','user',$_SESSION['user']);
    if (isset($_GET['change_pass'])) {
      XML::add_node('change_pass_form');
    }
    XML::add_node('root',false,$xml_section,$xml_content,Message::get());
    XML::add_node('root', 'domain', HOST);
    XML::add_node('root', 'server_root', ROOT);
    //XML::add_node('root','current_id' ,$_GET['section']);
  }

  function get_module_name($id) {
    $db = new Db;
    return $db->get_one('SELECT module FROM section WHERE id=!',$id);
  }
}
?>