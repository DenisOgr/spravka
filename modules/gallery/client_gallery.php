<?
Class Client_gallery {
  private $db, $page, $images_count;

  function __construct(){
    $this->db=new DB();
    $this->get_constants();
  }

  function show($id) {
    if (isset($_GET['page'])) {
      $this->page=$_GET['page'];
    } else {
      $this->page=1;
    }
    $xml=$this->get_list($id);
    //return XML::transform('content',$this->xsl);
    return XML::get_dom();
  }

  function get_list($id) {
    $start=($this->page-1)*$this->images_count;
    XML::from_db('SELECT gallery.* FROM gallery, gallery_vis
     WHERE gallery.id=gallery_vis.id
     AND gallery_vis.id_section=?
     AND gallery.id_section=? ORDER BY id DESC',array($_GET['section'],$id),'gallery','picture');
   // AND gallery.id_section=? ORDER BY id DESC LIMIT ?,?',array($_GET['section'],$id,$start,$this->images_count),'gallery','picture');
    XML::add_node('gallery',null, array('section'=>$_GET['section']));
    XML::add_node('gallery','width',strval($this->image_width+2));
    XML::add_node('gallery','height',strval($this->image_height+2));
    XML::add_node('gallery','long_path',GIMAGE_DIR.THUMB);
    XML::add_node('gallery','short_path',GIMAGE_DIR);
    XML::add_node('gallery','page',strval($this->page));
    $this->links($this->page);
  }

  function get_constants(){
    $this->images_count=14;
    $this->image_width=250;
    $this->image_height=250;
  }

  function links($page){
    $vsego_strok=$this->db->get_one('SELECT COUNT(*) from gallery where id_section=?', array($_GET['section']));
    $vsego_stranic=ceil($vsego_strok/$this->images_count);
    $current_page=1;
    $stroka='';
    if ($vsego_stranic>1){
      while ($current_page<=$vsego_stranic){
        if ($current_page!=$page){
          $stroka=$stroka.' '.'<a href="?section='.$_GET['section'].'&page='.$current_page.'">'.' '.$current_page.'</a>'.'  ';
        } else {
          $stroka=$stroka.' '.$current_page.'  ';
        }
        $current_page++;
      }
    }
    XML::add_node('gallery','links',$stroka);
  }

}
