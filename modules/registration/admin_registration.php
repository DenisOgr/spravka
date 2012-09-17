<?
Class Admin_registration {
  private $db;
  function __construct(){
    $this->db=new DB();
    if (isset($_GET['delete_item'])) {
      $this->delete_item($_GET['delete_item']);
    }
  }

  function show() {
    $this->get_list();
    return XML::transform('content',$this->xsl);
  }
  
  
  function get_list() {
    $this->xsl=MODULES.'registration/list_registration';
    XML::from_db('SELECT *, DATE_FORMAT(date,"%d.%m.%Y %k:%i") as date_format FROM registration ORDER BY date DESC',array(),'list_registration');
    XML::add_node('list_registration',null, array('section'=>$_GET['section']));
  }

  
  function delete_item($id) {
    $res=$this->db->query('DELETE FROM registration WHERE id=?',$id);
  }
}
