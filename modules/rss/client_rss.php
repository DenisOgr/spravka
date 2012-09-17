<?
Class Client_rss {
  private $db, $page, $images_count, $image_width, $image_height;

  function __construct(){
    $this->db=new DB();
   }

  function show($id_section) {
    //XML::from_db('SELECT * FROM baners WHERE id_section=?',$_GET['section'],'baners','item');    
    $xml = $this->db->get_row("SELECT id, xml FROM rss where id_section=?", array($id_section));
    //var_dump($xml);
    //die();
    
    
    $dom = XML::transform(false, 'modules/rss/rss_reader',$xml['xml'],false);
    $html = XML::dom2str($dom);
    $this->db->query("UPDATE `rss` SET `html`='{$html}' WHERE (`id`='{$xml['id']}')");
    
    XML::from_db('SELECT name, url, html FROM rss ',array(),'rss','item');    
    //XML::debug($dom);
    //die();
    
    return XML::get_dom();
  }
}
 