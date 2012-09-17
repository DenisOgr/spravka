<?
Class Admin_options {
  private $db;

  function __construct(){
    $this->db=new DB();
    if (isset($_POST['save_module'])) {
      $this->save_module();
      header('Location: '.HOST.'?section='.$_GET['section']);
      die();
    }
    if (isset($_POST['save_section'])) {
      $this->save_section();
      header('Location: '.HOST.'?section='.$_GET['section']);
      die();
    }
  }

  function show() {
    $this->xsl=MODULES.'options/admin_options';
    if ($_GET['options']=='section') {
      $this->show_section($_GET['section']);
    } else {
      $this->show_module($_GET['section']);
    }
    return XML::transform('content', $this->xsl);
  }

  function show_module ($id){
    $current_module=$this->db->get_one('SELECT module FROM section WHERE id=?',array($_GET['section']));
    (is_null($current_module)) ? $current_module='Admin_articles' : $current_module='Admin_'.$current_module;
    $module = new $current_module;
    if (isset($module->module_options)){
      XML::from_array($module->module_options,'options','module');
      $rows=$this->db->query('SELECT * FROM options WHERE id_section=?',array($id));
      $count_of_rows=mysql_num_rows($rows);
    }
    XML::from_db('SELECT * FROM options WHERE id_section=?',array($id),'options','active');
    XML::add_node('options','show_module');
  }

  function show_section($id){
    XML::add_node('options','show_section');
    XML::from_db('SELECT * FROM `section` WHERE id=?', array($id),'options','active');
    XML::from_db('SELECT * FROM `modules`', array(),'options','modules');
    //XML::from_db('SELECT * FROM `options` WHERE `id_section`=0', array(),'options','global');
  }

  function save_module() {
    //var_dump($_POST);
    foreach ($_POST as $key=>$value){
      if ($key!='save_module' && $key!='save_section'){
        $temp=$this->db->query('SELECT * FROM `options` WHERE `id_section`=? and `key`=?',array($_GET['section'],$key));
        $result=mysql_num_rows($temp);
        if ($result>0){
          $res=$this->db->query('UPDATE `options` SET `value`=? WHERE `id_section`=? and `key`=?',array($value,$_GET['section'],$key));
        } else {
          $res=$this->db->query('INSERT `options` SET `id_section`=?, `key`=?, `value`=? ',array($_GET['section'],$key,$value));
        }
      }
    }
  }

  function save_section (){
    //var_dump($_POST);
    (isset($_POST['static']))?$_POST['static']=1:$_POST['static']=0;
    (isset($_POST['visible']))?$_POST['visible']=1:$_POST['visible']=0;
    (isset($_POST['images']))?$_POST['images']=1:$_POST['images']=0;
    $res=$this->db->query('UPDATE `section` SET `module`=?,`present`=?,`static`=?,`sub_module`=?, `show_img`=?, `show_visibility`=? WHERE `id`=?',array($_POST['modul'],$_POST['present'],strval($_POST['static']),$_POST['submodul'],strval($_POST['images']),strval($_POST['visible']),$_GET['section']));
  }

}