<?
Class Client_news {
  private $db;
  function __construct(){    
    $this->db=new DB();    
  }

  function show($id) {  
    if (isset($_GET['item'])) {
      $xml=$this->get_item($_GET['item']);
      $xml=$this->get_list($id);
    } elseif (isset($_GET['archive'])) {
      $xml=$this->get_list($id);
      $xml=$this->get_archive();
    } else {
      $xml=$this->get_list($id);
    }    
    return XML::get_dom();    
  }

  function get_item($id) {    
    XML::from_db('SELECT *, DATE_FORMAT(date,"%d.%m.%Y") as date FROM news WHERE id=?',$id,'news','item');    
  }

  function get_list($id) {
XML::from_db('SELECT id, title, id_section, anons, image, DATE_FORMAT(date,"%d.%m.%Y") as date FROM news as n WHERE id_section=? ORDER BY n.date DESC LIMIT 5',$id,'news','list');         
    //XML::add_node('news','id_section',$id); 
  }

  function get_archive() {
XML::from_db('SELECT id, title, id_section, anons, image, DATE_FORMAT(date,"%d.%m.%Y") as date FROM news as n WHERE id_section=? ORDER BY n.date DESC',$_GET['section'],'news','archive');         

    //XML::add_node('news','id_section',$id); 
  }
}
