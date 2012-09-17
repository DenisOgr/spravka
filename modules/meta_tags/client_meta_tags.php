<?

class Client_meta_tags {

  private $db;

  function __construct () {
    $this->db = new DB();
  }

  function show () {
    $xml = $this->get_info($_GET['section']);
    return XML::get_dom();
  }

  function get_info ($id = 1) {
    $current = $this->db->get_row('SELECT * FROM meta_tags where id_section=?', array($id));
    // Если нет мета тегов для текущего раздела
    if (! isset($current['id'])) {
      $main = $this->db->get_row('SELECT * FROM meta_tags where id_section=?', array(1));
      if (! isset($main['id'])) {
        $this->db->query('INSERT meta_tags SET id_section=?', array(1));
        $main = $this->db->get_row('SELECT * FROM meta_tags where id_section=?', array(1));
      }
      $ar = $main;
    } else {
      $ar = $current;
    }
    $meta_modules = array('articles' , 'catalogue' , 'catalogue1');
    $module = $this->db->get_one('SELECT module FROM section WHERE id=?', array($id));
    if (in_array($module, $meta_modules)) {
      $query='SELECT meta_title AS title, meta_description AS description, meta_keywords AS keywords FROM ' . $module;  
      if (isset($_GET['item'])) {
        $meta_item = $this->db->get_row($query.' WHERE id=?', array($_GET['item']));
      } else {
        $meta_item = $this->db->get_row($query.' WHERE id_section=?', array($id));
      }      
    }
    if (isset($meta_item) && is_array($meta_item)) {
      foreach ($meta_item as $key => $value) {
        if ($value != '') {
          $ar[$key] = $value;
        }
      }
    }
    XML::from_array($ar, 'meta_tags');
  }
}
