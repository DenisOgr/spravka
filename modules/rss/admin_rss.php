<?
Class Admin_rss {
  private $db,$var,$verify=true;

  function __construct(){
    $this->db=new DB();
    if (isset($_GET['delete'])) {
      $this->delete_item($_GET['delete']);
    }
    if (isset($_POST['save']) && $this->verify_fill()) {
      if (isset($_GET['edit'])) {
        $this->save_item(intval($_GET['edit']));
      } else {
        $this->save_item(null);
      }
      header('Location: '.HOST.'?section='.$_GET['section']);
      die();
    }
  }

  function show() {
    $this->xsl=MODULES.'rss/admin_rss';
    if (isset($_GET['edit'])) {
      $xml=$this->get_item($_GET['edit']);
    } elseif (isset($_GET['add'])) {
      $xml=$this->get_item(null);
    } else {
      $xml=$this->get_list();
    }
    //XML::debug();
    XML::add_node('section',null, array('section'=>$_GET['section']));
    return XML::transform('content',$this->xsl);
  }

  function verify_fill() {
    if (trim($_POST['url'])=='') {
      $this->verify = false;
      Message::error('Поля, отмеченные * обязательны для заполнения');
    }
    return $this->verify;
  }

  function get_item($id) {
    if (!is_null($id)){
      XML::from_db('SELECT * FROM rss WHERE id=?',$id,'rss','item');
    } else {
      XML::from_array($_POST,'rss','item');
    }
    //XML::debug();
  }

  function get_list() {
    XML::from_db('SELECT * FROM rss WHERE id_section=? ORDER BY id DESC',$_GET['section'],'rss','list');
    XML::add_node('rss','list');
  }

  function save_item($id) {
$xml = @file_get_contents($_POST['url']);
$xml=iconv('windows-1251','utf-8',$xml);
$xml = ereg_replace('windows-1251', 'utf-8', $xml);

    if ($id!=null) {
      $res=$this->db->query('UPDATE rss SET id_section=?, url=?, name=?, xml=? WHERE id=?', array($_GET['section'], $_POST['url'], $_POST['name'], $xml, $id));
    } else {
      $res=$this->db->query('INSERT rss SET id_section=?, url=?, name=?, xml=?', array($_GET['section'], $_POST['url'], $_POST['name'], $xml));
    }
  }

  function delete_item($id) {
    $res=$this->db->query('DELETE FROM rss WHERE id=?',$id);
  }
}
