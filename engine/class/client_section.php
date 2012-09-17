<?php
class Client_section {
  private $db, $ar, $index, $mites, $cursor, $add_ar;

  function __construct() {
    $this->db=new Db;
    if (isset($_GET['alias'])) {
    	$_GET['alias']=trim($_GET['alias'],'/');
      $_GET['section']=$this->db->get_one('SELECT id FROM section WHERE alias=?', $_GET['alias']);
    } 
    $this->cursor=$this->db->get_row('SELECT a.name AS current_name,b.name AS parent_name,a.id_parent AS parent_id, a.module AS current_module FROM section AS a LEFT JOIN section AS b ON a.id_parent=b.id WHERE a.id='.$_GET['section']);
    // $this->cursor['childrens']=$this->db->get_one('SELECT COUNT(*) FROM `section` WHERE id_parent='.$_GET['section']);
    if (isset($_GET['search'])) $this->cursor['current_module']='search';
    $this->cursor['current_id']=$_GET['section'];
  }

  function add_ar() {
    $count=count($this->index);
    for ($i=0; $i<$count; $i++) {
      $this->index[$i]['add']=$this->add_ar[$this->index[$i][0]];
    }
  }

  function get_section() {
    $ar=array();
    $res=$this->db->query('SELECT * FROM section ORDER BY priority');
    while ($row=$this->db->fetch($res)) {
      $ar[$row['id_parent']][]=$row['id'];
      $this->add_ar[$row['id']]['name']=$row['name'];
      $this->add_ar[$row['id']]['alias']=$row['alias'];
      $this->add_ar[$row['id']]['visible']=$row['visible'];
      $this->add_ar[$row['id']]['static']=$row['static'];
      $this->add_ar[$row['id']]['id_parent']=$row['id_parent'];     
      $this->add_ar[$row['id']]['sys']=$row['sys'];     
      $this->add_ar[$row['id']]['image']=$row['image'];     
    }
    return $ar;
  }

  function pass($i, $j) {
    if (isset($this->ar[$i][$j]) || ($i==-1 && $j==-1)) {
      if (isset($this->ar[$i][$j])) {
        $id_sect=$this->ar[$i][$j];
        $this->mites[]=array($i,$j);
      } else $id_sect=0;

      $this->index[]=array($id_sect, count($this->mites));
      $this->pass($id_sect,0);
    } else {
      if ($i==0) {
        return 1;
      }
      // сделать чтобы стартовало с доступного id а не c 1
      list($i,$j)=@array_pop($this->mites);
      $this->pass($i,$j+1);
    }
  }

  function show() {
    $this->ar=$this->get_section();
    $this->pass(null,0);
    $this->add_ar();
    if (isset($this->cursor)) {
      $this->index=array_merge($this->index,$this->cursor);
    }
    XML::from_array($this->index,'section');
    return XML::get_dom();
    //XML::transform('section','client/section');
  }

  function get_module_name($id) {
    return $this->db->get_one('SELECT module FROM section WHERE id=!',$id);
  }

  function get_present($id){
  if (is_numeric($id)) {
    return ($id==1) 
    ? $this->db->get_all('SELECT id, present, module FROM section WHERE present IS NOT NULL OR id='.$id) 
    : $this->db->get_all('SELECT id, present, module FROM section WHERE present="anywhere" OR id='.$id);   
  }  else {
  	return array();
  }
  }
}
?>