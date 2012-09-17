<?
Class Admin_catalogue {
  private $db, $page, $images_count, $image_width, $image_height;
  public $module_options=array('title'=>array('input','textarea'), 
'number'=>array('one','many'),
'anons'=>array('yes','no'));

  function __construct(){
    $this->db=new DB();
	if (isset ($_GET['delete'])) {
      $this->delete($_GET['delete']);
    }elseif (isset($_POST['cancel'])){
      unset($_GET['edit']);
      header('Location: '.HOST.'?section='.$_GET['section']);
      die();
    }elseif (isset($_POST['save'])){
      if (isset($_GET['edit'])) {
        $this->save($_GET['edit']);
      } else {
        $this->save();
      }
      header('Location: '.HOST.'?section='.$_GET['section']);
      die();
    } elseif (isset($_POST['save_preview'])){
      $this->save_anons();
    }
  }

  function show() {
    if (isset($_GET['page'])) {
      $this->page=$_GET['page'];
    } else {
      $this->page=1;
    }

    $this->xsl=MODULES.'catalogue/admin_catalogue';
    if (isset($_GET['edit'])) {
      $xml=$this->edit($_GET['edit']);
    } elseif (isset($_GET['add'])) {
      $xml=$this->show_form();
    } else {
      $xml=$this->get_list();
      $xml=$this->links($this->page);
    }
    return XML::transform('content',$this->xsl);
  }

  function verify_text() {
    //if (trim($_POST['name']) == '' && trim($_POST['anons'])=='' && trim($_POST['price'])=='') {
    if (trim($_POST['name'])=='') {
      Message::error('Поля, отмеченные * обязательны для заполнения');
      return false;
    } else {
    	return true;
    }
  }

  function get_list() {
  //$q=$this->db->query('DELETE FROM `catalogue` WHERE `name`=? and anons=?', array('', ''));
    $start=($this->page-1)*$this->images_count;
    XML::from_db('SELECT id, name FROM catalogue WHERE id_section =? ORDER BY name',array($_GET['section']),'catalogue','item');
    XML::add_node('catalogue',null, array('section'=>$_GET['section']));
    XML::add_node('catalogue','add_link');
    //$this->links($this->page);
    //$this->show_form();
//    XML::from_db('SELECT * FROM catalogue_names WHERE id_section=?',array($_GET['section']), 'catalogue', 'item');
    XML::from_db('SELECT * FROM catalogue_anons WHERE id_section=?',array($_GET['section']), 'catalogue', 'anons');
  }

  function save($id=null) {
    if ($this->verify_text()) {
      if (is_null($id)){
        $res=$this->db->query('INSERT catalogue SET id_section=?, name=?, text=?, adres=?, tel=?, tel_mob=?, email=?, url=?, more=?, meta_title=?, meta_description=?, meta_keywords=?', array($_GET['section'], $_POST['name'], $_POST['text'], $_POST['adres'], $_POST['tel'], $_POST['tel_mob'], $_POST['email'], $_POST['url'], $_POST['more'],$_POST['meta_title'],$_POST['meta_description'], $_POST['meta_keywords']));
      } else {
        $res=$this->db->query('UPDATE catalogue SET id_section=?, name=?, text=?, adres=?, tel=?, tel_mob=?, email=?, url=?, more=?, meta_title=?, meta_description=?, meta_keywords=? WHERE id=?', array($_GET['section'], $_POST['name'], $_POST['text'], $_POST['adres'], $_POST['tel'], $_POST['tel_mob'], $_POST['email'], $_POST['url'], $_POST['more'], $_POST['meta_title'],$_POST['meta_description'], $_POST['meta_keywords'],$id));
      }
    }
   }
    
  function delete($id) {
      $res=$this->db->query('DELETE FROM catalogue WHERE id=?',$id);
  }

  function show_form(){
    XML::add_node('catalogue', 'edit');
  }

  function edit ($id=null){
      Xml::from_db('SELECT * FROM catalogue WHERE id=?',$id, 'catalogue', 'edit');
  }

  function links($page){
    XML::add_node('catalogue','links','');
  }

  function save_anons(){
      $records_count=$this->db->get_one('SELECT count(*) FROM catalogue_anons WHERE id_section=?',array($_GET['section']));
      if ($records_count>0){
        $res=$this->db->query('UPDATE catalogue_anons SET text=? WHERE id_section=?', array($_POST['anons_text'], $_GET['section']));
      } else {
        $res=$this->db->query('INSERT catalogue_anons SET id_section=?, text=?', array($_GET['section'], $_POST['anons_text']));
      }
    
  }
}

