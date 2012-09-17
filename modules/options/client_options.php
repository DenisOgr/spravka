<?
Class Client_meta_tags {
  private $db;

  function __construct(){
    $this->db=new DB();
  }

  function show() {
    $xml=$this->get_info($_GET['section']);
    //XML::debug();
    return XML::get_dom();
  }

  function get_info($id=1) {
    //echo "Ну типа показыаем мы теги меты";
    $current=$this->db->get_row('SELECT * FROM meta_tags where id_section=?',array($id));
    if (!isset($current['id'])) {
      $main=$this->db->get_row('SELECT * FROM meta_tags where id_section=?',array(1));
      XML::from_array($main,'meta_tags');
    } else {
      XML::from_array($current,'meta_tags');
    }
  }
}
