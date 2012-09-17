<?

class Client_catalogue1 {

  private $db, $page, $images_count, $image_width, $image_height;

  private $count;

  function __construct () {
    $this->db = new DB();
    $this->get_constants();
    $this->count = new Count();
  }

  function show () {
    if (isset($_GET['page'])) {
      $this->page = $_GET['page'];
    } else {
      $this->page = 1;
    }
    if (isset($_GET['item'])) {
      $xml = $this->item($_GET['item']);
      //$this->get_list();
    } else {
      $xml = $this->get_list();
      $xml = $this->links($this->page);
    }
    return XML::get_dom();
  }

  function get_list () {
    $start = ($this->page - 1) * $this->images_count;
    $sec = $_GET['section'];
    /*if (isset($_GET['item'])) {
      $sec=$_GET['section'];
    } else {
      $sec=8;
    }*/
    XML::from_db('SELECT catalogue1.id, catalogue1.name, catalogue1.anons, catalogue1.price, cat_images.id AS picture_id, cat_images.version AS picture_ver, cat_images.extension AS picture_ext
FROM catalogue1
LEFT JOIN (SELECT * FROM cat_images ORDER BY cat_images.id DESC) AS cat_images ON catalogue1.id = cat_images.id_goods
WHERE catalogue1.id_section =?
GROUP BY catalogue1.id
ORDER BY catalogue1.id DESC
LIMIT ? , ?', array($sec , $start , $this->images_count), 'catalogue1', 'item');
    /*print "SELECT catalogue.id, catalogue.name, catalogue.anons, catalogue.price, cat_images.id AS picture_id, cat_images.version AS picture_ver, cat_images.extension AS picture_ext
FROM catalogue
LEFT JOIN cat_images ON catalogue.id = cat_images.id_goods
WHERE catalogue.id_section =$sec
GROUP BY catalogue.id
ORDER BY catalogue.id DESC 
";*/
    /*print "SELECT catalogue.id, catalogue.name, catalogue.anons, catalogue.price, cat_images.id AS picture_id, cat_images.version AS picture_ver, cat_images.extension AS picture_ext
FROM catalogue
LEFT JOIN cat_images ON catalogue.id = cat_images.id_goods
WHERE catalogue.id_section =".$_GET['section']."
GROUP BY catalogue.id
ORDER BY catalogue.id DESC" ;*/
    XML::add_node('catalogue1', null, array('section' => $_GET['section']));
    XML::add_node('catalogue1', 'add_link');
    //$this->links($this->page);
    //$this->show_form();
    //XML::from_db('SELECT * FROM catalogue_anons WHERE id_section=?',array($sec), 'catalogue', 'anons');
    XML::add_node('catalogue1', 'count', $this->count->showSection($_GET['section']));
  }

  function get_constants () {
    $this->images_count = 999;
    $this->image_width = 150;
    $this->image_height = 150;
  }

  function links ($page) {
    $vsego_strok = $this->db->get_one('SELECT COUNT(*) from catalogue1 where id_section=?', array($_GET['section']));
    $vsego_stranic = ceil($vsego_strok / $this->images_count);
    $current_page = 1;
    $stroka = '';
    if ($vsego_stranic > 1) {
      while ($current_page <= $vsego_stranic) {
        if ($current_page != $page) {
          $stroka = $stroka . ' ' . '<a href="?section=' . $_GET['section'] . '&page=' . $current_page . '">' . ' ' . $current_page . '</a>' . '  ';
        } else {
          $stroka = $stroka . ' <b>' . $current_page . '</b>  ';
        }
        $current_page ++;
      }
    }
    XML::add_node('catalogue1', 'links', $stroka);
  }

  function small_images ($id) {
    XML::from_db('SELECT * FROM cat_images WHERE id_goods=? ORDER BY id DESC', $id, 'detail', 'picture');
  }

  function item ($id) {
    Xml::from_db('Select * from catalogue1 where id=?', array($id), 'catalogue1', 'detail');
    $this->small_images($id);
    $count = $this->count->showSection($_GET['section'], $_GET['item']);
    XML::add_node('catalogue', 'count', $count);
  }
}

