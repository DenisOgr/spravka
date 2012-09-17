<?php
class Client_links_exchange {
  private $db, $ar, $index, $mites, $cursor, $add_ar, $sections_array, $path_array;

  function __construct() {
    $this->db=new Db;

  }

  function show() {
    if (isset($_GET['all'])) {
      $this->all($_GET['all']);
    } else {
      $this->section_list();
    }
    //$xml=$this->get_info($_GET['section']);
    XML::add_node('links_exchange','id_section',$_GET['section']);
    return XML::get_dom();
  }

  function section_list($id=0){
    XML::from_db('SELECT `links_exchange_sections`.*, count(*)as kol FROM `links_exchange_partners`, `links_exchange_sections` where `links_exchange_sections`.id=`links_exchange_partners`.id_section GROUP BY  `links_exchange_sections`.id', array(),'links_exchange','list');
  }
  
  function all($id) {
    XML::from_db('SELECT * FROM links_exchange_partners where id_section=?', array($id), 'links_exchange','all');
  }
}
?>


