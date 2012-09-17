<?

class Client_catalogue {

  private $db, $page, $images_count, $image_width, $image_height;

  private $count;

  function __construct () {
    $this->db = new DB();
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
     // $this->get_list();
    } else {
      $xml = $this->get_list();
      $xml = $this->links($this->page);
    }
    return XML::get_dom();
  }

  function get_list () {
    $start = ($this->page - 1) * $this->images_count;
    $sec = $_GET['section'];
    XML::from_db('SELECT id, name, tel, adres FROM catalogue WHERE id_section =? ORDER BY name', array($_GET['section']), 'catalogue', 'item');
    XML::add_node('catalogue', null, array('section' => $_GET['section']));
    XML::add_node('catalogue', 'add_link');
    //$this->links($this->page);
    //$this->show_form();
    XML::from_db('SELECT * FROM catalogue_anons WHERE id_section=?', array($sec), 'catalogue', 'anons');
    $count = $this->count->showSection($_GET['section']);
    XML::add_node('catalogue', 'count', $count);
  }

  function links ($page) {
    XML::add_node('catalogue', 'links', '');
  }

  function item ($id) {
    Xml::from_db('Select * from catalogue where id=?', array($id), 'catalogue', 'detail');
    $count = $this->count->showSection($_GET['section'],$_GET['item']);
    XML::add_node('catalogue', 'count', $count);
  }
}

