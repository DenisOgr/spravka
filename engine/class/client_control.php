<?

class Client_control {

  private $db;

  function __construct () {
    //$this->db = new Db;
    if (empty($_GET['section'])) {
      $_GET['section'] = 1;
    }
  }

  function show () {
    $xml_content = array();
    $sec = new Client_section();
    $xml_section = $sec->show();
    $meta = new Client_meta_tags();
    $xml_content['meta'] = $meta->show();
    //var_dump($xml_content);
    //XML::debug($meta->show());
    $main = $main_contact = $main_special = $main_news = null;
    $present = $sec->get_present($_GET['section']);
    foreach ($present as $section) {
      $name_module = $sec->get_module_name($section['id']);
      (is_null($name_module)) ? $name_module = 'Client_articles' : $name_module = 'Client_' . $name_module;
      $module = new $name_module();
      $xml_content[$section['id']] = $module->show($section['id']);
    }
    if (isset($_GET['search'])) {
      $search = new Client_search();
      $xml_content[] = $search->show();
    }
    //var_dump($xml_content);
    XML::add_node('root', false, $xml_section/*, Message::get()*/);
    //XML::header(false);
    XML::from_array($xml_content, 'content', null);
    XML::add_node('root', 'domain', HOST);
    XML::add_node('root', 'server_root', ROOT);
    //XML::debug();
  }
}
?>