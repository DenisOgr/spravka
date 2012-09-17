<?
Class Admin_meta_tags {
  private $db;

  function __construct(){
    $this->db=new DB();
    if (isset($_POST['save'])) {
      $this->save();
      header('Location: '.HOST.'?section='.$_GET['section']);
      die();
    }
  }

  function show() {
    $this->xsl=MODULES.'meta_tags/admin_meta_tags';
    XML::from_db('SELECT * FROM meta_tags where id_section=?',array($_GET['section']),'meta_tags');
    XML::add_node('meta_tags','show_form');
    return XML::transform('content', $this->xsl);
  }

  function save() {
    $_POST['description']=strip_tags (substr($_POST['description'],0,200));
    $_POST['keywords']=strip_tags (substr($_POST['keywords'],0,200));
    $temp=$this->db->query('SELECT * FROM meta_tags where id_section=?',array($_GET['section']));
    $result=mysql_num_rows($temp);
    if ($result>0){
      $res=$this->db->query('UPDATE meta_tags SET title=?, description=?, keywords=? WHERE id_section=?',array(strval($_POST['title']),strval($_POST['description']),strval($_POST['keywords']),$_GET['section']));
    } else {
      $res=$this->db->query('INSERT meta_tags SET title=?, description=?, keywords=?, id_section=?',array(strval($_POST['title']),strval($_POST['description']),strval($_POST['keywords']),$_GET['section']));
    }
  }

}
