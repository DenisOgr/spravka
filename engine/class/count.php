<?

class Count {

  private $db;

  private $path;

  public $url;

  private $data;

  private $xml;

  private $root;

  private $parents;

  function __construct () {
    $this->db = new DB();
    $this->path = ROOT . UPLOADS . 'stat.htm';
    $this->url = HOSTNAME . '/' . UPLOADS . 'stat.htm';
    
    if (date('y')>$this->db->get_one('SELECT year FROM stat')) {
      $this->db->query('UPDATE stat SET year=?',date('y'));
      $this->db->query('DELETE FROM count');      
    }
  }

  public function incSection () {
    $flag = false;
    if (! preg_match('/admin/', $_SERVER["SCRIPT_FILENAME"]) && isset($_GET['section']) && intval($_GET['section']) > 0) {
      $section = $_GET['section'];
      $item = (isset($_GET['item']) && intval($_GET['item']) > 0) ? $_GET['item'] : 0;
      $date = date("n-j");
      if (isset($_COOKIE['idCount'])) {
        if (! isset($_COOKIE['idCount'][$section][$item])) {
          $flag = true;
        } else {
          if ($_COOKIE['idCount'][$section][$item] != $date) {
            $flag = true;
          }
        }
      } else {
        $flag = true;
      }
      //var_dump($flag, $section,$item);
      if ($flag) {
        setcookie("idCount[$section][$item]", $date);
        $query = "SELECT * FROM count WHERE section=$section AND item=$item";
        $result = $this->db->simple_query($query);
        if (mysql_num_rows($result)) {
          $query = "UPDATE count SET count=count+1 WHERE section=$section AND item=$item";
          $this->db->simple_query($query);
        } else {
          $query = "INSERT INTO count (section, count, item) VALUES ($section, 1, $item) ";
          $this->db->simple_query($query);
        }
      }
    }
  }

  public function showSection ($section, $item = false) {
    if (intval($section) > 0) {
    	if (!$item && isset($_GET['item'])) $item=$_GET['item'];
      if ($item && intval($item) > 0) {
        $query = "SELECT count FROM count WHERE section=$section AND item=$item";
      } else {
        $query = "SELECT SUM(count) FROM count WHERE section=$section";
      }
      $result = $this->db->simple_query($query);
      if (mysql_num_rows($result)) {
        $row = mysql_fetch_row($result);
        return $row[0];
      } else {
        return '0';
      }
    }
  }

  public function isStat () {
    return file_exists($this->path);
  }

  public function isData () {
    $query = 'SELECT * FROM count';
    $result = $this->db->simple_query($query);
    return mysql_num_rows($result);
  }

  private function tree ($id, $root) {
    foreach ($this->data as $row) {
      if ($row['id_parent'] == $id) {
        $child = $this->xml->createElement('list');
        $child = $root->appendChild($child);
        $name = $this->xml->createAttribute('name');
        $name = $child->appendChild($name);
        $text = $this->xml->createTextNode($row['name']);
        $name->appendChild($text);
        $value = $this->xml->createAttribute('value');
        $value = $child->appendChild($value);
        $text = $this->xml->createTextNode($row['count']);
        $value->appendChild($text);
        $this->tree($row['id'], $child);
      }
    }
  }

  private function checkTree ($id) {
    $flag = 0;
    foreach ($this->data as $row) {
      if ($row['id'] == $id) {
        $flag = 1;
        break;
      }
    }
    return $flag;
  }

  private function parents () {
    foreach ($this->data as $row) {
      if ($row['id_parent']) {
        array_push($this->parents, $row['id_parent']);
      }
    }
  }

  private function correctTree () {
    foreach ($this->parents as $id) {
      if (! $this->checkTree($id)) {
        $query = "SELECT id, name, id_parent, visible, priority FROM section WHERE id=$id";
        $result = $this->db->simple_query($query);
        $row = mysql_fetch_array($result);
        if (! $row['id_parent'] and ! $row['visible']) {
          continue;
        }
        $row['count'] = 0;
        array_push($this->data, $row);
        $this->parents();
        $this->correctTree();
      }
    }
  }

  public function resetStat () {
    /*$query = 'SELECT MONTH(date) FROM stat';
    $result = $this->db->simple_query($query);
    if (mysql_num_rows($result)) {
      if (mysql_result($result, 0) == date('n')) {return;}
    }
    $date = date('Y-m-d');
    $query = "UPDATE stat SET date='$date'";
    $this->db->simple_query($query);*/

    //var_dump($sec->ar);
    /*$query = 'SELECT * FROM count';
    $result = $this->db->simple_query($query);
    $this->data = array();
    while ($row = mysql_fetch_array($result)) {
      $name = $row['section'];
      $value = $row['count'];
      $query = "SELECT id, name, id_parent, visible, priority FROM section WHERE id=$name";
      $tmp = $this->db->simple_query($query);
      $row = mysql_fetch_array($tmp);
      if (! $row['id_parent'] and ! $row['visible']) {
        continue;
      }
      $row['count'] = $value;
      array_push($this->data, $row);
    }
    $this->parents = array();
    $this->parents();
    $this->correctTree();

    function cmp ($a, $b) {
      if ($a['priority'] == $b['priority']) {return 0;}
      return ($a['priority'] < $b['priority']) ? - 1 : 1;
    }
    usort($this->data, "cmp");
    $this->xml = new DOMDocument();
    $this->root = $this->xml->createElement('root');
    $this->root = $this->xml->appendChild($this->root);
    $this->tree(0, $this->root);
    $xsl = new DOMDocument();
    $xsl->load(ENGINE . 'xsl/count.xsl');
    $xslp = new XSLTProcessor();
    $xslp->importStyleSheet($xsl);
    $fp = fopen($this->path, 'w');
    fwrite($fp, $xslp->transformToXML($this->xml));
    fclose($fp);
    $query = 'DELETE FROM count';
    $this->db->simple_query($query);*/
  }
}
?>