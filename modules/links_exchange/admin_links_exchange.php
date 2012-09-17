<?php
class Admin_links_exchange {
  private $db, $ar, $index, $mites, $cursor, $add_ar, $sections_array, $path_array;

  function __construct() {
    $this->db=new Db;
    if (isset ($_POST['links_section_save'])) {
      $this->links_section_save();
      header('Location: '.HOST.'?section='.$_GET['section']);
    }
    if (isset($_GET['links_section_add'])) {
      $this->links_section_add($_GET['links_section_add']);
    }
    if (isset($_GET['links_section_del'])) {
      $this->links_section_del($_GET['links_section_del']);
    }
    if (isset ($_POST['links_section_update'])) {
      $this->links_section_update($_GET['links_section_edit']);
      header('Location: '.HOST.'?section='.$_GET['section']);
    } elseif (isset($_GET['links_section_edit'])) {
      $this->links_section_edit($_GET['links_section_edit']);
    }
    if (isset($_POST['get_info'])){
      $this->get_url_info($_POST['url']);
    }
    if (isset($_GET['del_link'])){
      $this->del_link($_GET['del_link']);
    }
  }

  function show(){
    $this->xsl=MODULES.'links_exchange/admin_links_exchange';
    if (isset ($_POST['save_section'])) {
      $this->section_add($_GET['links_section_add']);
    } elseif (isset($_GET['links_section'])){
      $this->links_section($_GET['links_section']);
    } elseif (isset($_POST['save_link'])) {
      if (!isset($_GET['links_edit'])) {
      $this->save_link($_GET['links_add']);
      $this->links_section($_GET['links_add']);
      } else {
        //$this->links_edit();
        $this->save_link($_GET['links_edit']);
      }
    } elseif (isset($_GET['links_add'])){
      $this->links_edit();
    } elseif (isset($_GET['links_edit'])) {
      $this->links_edit($_GET['links_edit']);
    } else {
      $xml=$this->section_list();
    }
    Xml::add_node('links','section', $_GET['section']);
    return XML::transform('content',$this->xsl);
  }

  function section_list(){
    $this->sections_array=array();
    $this->buildTree();
    XML::from_array($this->sections_array,'links','links_section');
  }
  function links_section_add($id_parent = NULL){
    XML::add_node('links','links_section_add', $id_parent);
  }
  function links_section_edit($id){
    XML::add_node('links','links_section_edit', $id);
  }
  function links_section_save(){
    if (isset ($_POST['id_parent'])) {$id=$_POST['id_parent'];} else {$id=NULL;}
    $this->db->query('INSERT links_exchange_sections SET `id_parent`=?, `name`=?, `level`=?', array ($id,$_POST['links_section_name'],$_POST['level']));
  }
  function links_section_update($id){
    $this->db->query('UPDATE links_exchange_sections SET `name`=? where id=?', array ($_POST['links_section_name'],$id));
  }
  function links_section_del($id){
    $this->db->query('DELETE from links_exchange_sections  where id=?', array ($id));
  }
  function links_section($section){
    XML::from_db('SELECT * FROM links_exchange_partners where id_section=?', array($section), 'links','detail_links_section');
    $parent_section=$this->db->get_one('SELECT id_parent FROM links_exchange_sections where id=?', array($section));
    $this->path_array = array();
    $this->get_path($section);
    $this->path_array =array_reverse ($this->path_array );
    XML::from_array($this->path_array,'detail_links_section','links_section_path','item');
    XML::from_db('SELECT name, id FROM links_exchange_sections WHERE id=?',array($section),'links', 'links_section_name' );
  }

  function links_edit($id=null){
    if (is_null($id)) {
    Xml::add_node('links','show_add_links_form');      
    } else {
      
      
    }
    

  }

  function get_url_info($url){
    $url = 'http://'.str_replace('http://', '', $url);
    $fcontents =file_get_contents($url);
    if (preg_match('/charset=(.*?)[\\"| ]/im', $fcontents, $regs)){
      $char_set = $regs[1];
    } else $char_set = 'windows-1251';
    //echo "Коридровка у нас такая $char_set";
    $convert_content=iconv($char_set,'UTF-8',$fcontents);
    $convert_content = preg_replace('/\\r*\\n/i', ' ', $convert_content);
    //var_dump($convert_content);
    preg_match('|<title>(.*)</title>|Uis', $convert_content, $title);
    if (preg_match('/name\\s*=\\s*\\"description"\\s*content\\s*="([^"]*)"/i', $convert_content, $description)) {
      $descript=$description[1];
    } else {
      $descript='';
    }
    //var_dump($descript);
    Xml::add_node('links','my_url', $url);
    Xml::add_node('links','my_title', $title[1]);
    Xml::add_node('links','my_description', $descript);
    Xml::add_node('links','current_links_section', $_GET['links_add']);
  }

  function save_link($id_parent){
    //var_dump($_POST);
    $img='link_'.$_GET['links_add'];
    /*if ($_POST['image']=='img') {
    $_POST['img']='0';
    }*/
    $this->db->query('INSERT links_exchange_partners SET `id_section`=?, `url`=?, `title`=?, `description`=?, `image`=?', array ($id_parent, $_POST['url'],$_POST['title'],$_POST['description'],$_POST[$img]));
  }

  function buildTree($nodeRef = false)
  {
    if (!$nodeRef)
    $nodeRef = $this->db->get_all("SELECT * FROM `links_exchange_sections` WHERE `id_parent` IS NULL ");
    else
    $nodeRef = $this->db->get_all("SELECT * FROM `links_exchange_sections` WHERE `id_parent`=?",array($nodeRef));

    foreach($nodeRef as $k => $v){
      array_push($this->sections_array,$v);
      $this->buildTree($v['id']);
    }
  }

  function get_path($parent){
    if (! is_null($parent)){
      $temp=$this->db->get_row ('SELECT * FROM links_exchange_sections WHERE id=?', array ($parent));
      array_push($this->path_array, $temp);
      $this->get_path($temp['id_parent']);
    }
  }

  function del_link($id){
    $this->db->query('DELETE from links_exchange_partners where id=?', array ($id));
  }
}
?>