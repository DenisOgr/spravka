<?
Class Client_baners {
  private $db, $page, $images_count, $image_width, $image_height;

  function __construct(){
    $this->db=new DB();
   }

  function show($id) {
    //XML::from_db('SELECT * FROM baners WHERE id_section=?',$_GET['section'],'baners','item');    
    XML::from_db('SELECT * FROM baners WHERE id_section=?',array($id),'baners','item');    
    return XML::get_dom();
  }
}
 