<?
Class Admin_baners {
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
    $this->xsl=MODULES.'baners/admin_baners';
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
      XML::from_db('SELECT * FROM baners WHERE id=?',$id,'baners','item');
    } else {
      XML::from_array($_POST,'baners','item');
    }
    //XML::debug();
  }

  function get_list() {
    XML::from_db('SELECT * FROM baners WHERE id_section=? ORDER BY id DESC',$_GET['section'],'baners','list');
    XML::add_node('baners','list');
  }

  function save_item($id) {
    if ($id!=null) {
      $res=$this->db->query('UPDATE baners SET id_section=?, url=? WHERE id=?', array($_GET['section'], $_POST['url'], $id));
    } else {
      $res=$this->db->query('INSERT baners SET id_section=?, url=?', array($_GET['section'], $_POST['url']));
    }
  }

  function delete_item($id) {
    $res=$this->db->query('DELETE FROM baners WHERE id=?',$id);
  }
}
