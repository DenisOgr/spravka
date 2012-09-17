<?
Class Admin_articles {
  private $db,$var,$verify=true,$options,$number,$photo;
  public $module_options=array('title'=>array('input','textarea','none'), 
'number'=>array('one','many'),
'anons'=>array('yes','no'),
'photo'=>array('yes','no')
);

  function __construct(){
    //$this->var['section']=$_GET['section'];
    $def_option=array('title'=>'none', 'number'=>'one','anons'=>'no','photo'=>'no');
        
    $this->db=new DB();
    $tmp = $this->db->get_all('SELECT options.key, value FROM options WHERE id_section = ?',array($_GET['section']));
    foreach ($tmp as $t) {
    	$this->options[$t['key']] = $t['value'];
    }
    $this->photo=$this->options['photo'];
    if(empty($this->options)){
    	$this->options=$def_option;
    }
    if (!isset($_GET['edit_item'])){
    	$this->options['photo']='no';
    }
    if (isset($_GET['delete_item'])) {
      $this->delete_item($_GET['delete_item']);
    }

    if (isset($_POST['cancel'])) {
      unset($_GET['edit_item'],$_GET['add']);
    }
    if (isset($_POST['save_item']) && $this->verify_fill()) {
      if (isset($_GET['edit_item'])) {
        $this->save_item(intval($_GET['edit_item']));
      } else {
        $this->save_item(null);
      }
      header('Location: '.HOST.'?section='.$_GET['section']);
      die();
    }
 /*   foreach ($this->options as $k => $e){
     echo $k.' => '.$e.'<br/>';
    }*/
  }

  function show() {
  	$this->number='0';
  	if ($this->options['number']=='one') {
  	  //echo "Да один!";
  		$this->number=$this->db->get_one('SELECT COUNT(*) FROM articles WHERE id_section = ?',array($_GET['section']));
  		if ($this->number > 0){
  			unset($_GET['add']);
  			if ($this->photo=='yes') {
			$this->options['photo']='yes';
			}
  		}
  	}
    if (isset($_GET['edit_item'])) {
      $xml=$this->get_item($_GET['edit_item']);
    } elseif (isset($_GET['add'])) {    	
      $xml=$this->get_item(null);
    } else {
      $xml=$this->get_list();
    }
    //XML::debug();
    Xml::add_node(false,'section',$_GET['section']);
    Xml::from_array($this->options,false,'options');
    return XML::transform('content', $this->xsl);
  }

  function verify_fill() {
    if (($this->options['anons']=='yes' && $_POST['anons']=='') 
    || (($this->options['title']=='input' || $this->options['title']=='textarea') && $_POST['title']=='')) {
      $this->verify = false;
      Message::error('Поля, отмеченные * обязательны для заполнения');
    } else {
      Message::success('Информация успешно сохранена');
    }
    return $this->verify;
  }

  function get_item($id) {
    $this->xsl=MODULES.'articles/item_articles';
    if (!$this->verify) {
      XML::from_array($_POST,'item_articles');
    } elseif (!is_null($id)) {
      XML::from_db('SELECT * FROM articles WHERE id=?',$id,'item_articles');
    }
    XML::add_node('item_articles');
  }

  function get_list() {
  	if ($this->options['number']=='one'){
  		$node='item_articles';
  		$limit='ORDER BY id DESC LIMIT 1';
  	} else {
  		$node='list_articles';
  		$limit='';
  	}
  	    //$this->xsl=MODULES.'options/admin_options';
 		$this->xsl=MODULES.'articles/'.$node;
 		//var_dump($this->xsl);
    XML::from_db('SELECT * FROM articles WHERE id_section=? '.$limit,$_GET['section'],$node);
  }

  function save_item($id) {
  $title='';
  $anons='';
  	if(isset($_POST['art'.$_GET['section'].'_'.$id])){
  	$art=$_POST['art'.$_GET['section'].'_'.$id];  	
  	} else {
  		$art='';
  	}
  	if ($this->options['anons']=='yes'){
    	$anons=$_POST['anons'];
  	} 
  	if ($_POST['title']!=''){
    	$title=$_POST['title'];
  	} 
    if ($id!=null) {
      if ($id!=0) {
        $res=$this->db->query('UPDATE articles SET id_section=?, title=?, anons=?, text=?, photo=?, meta_title=?, meta_description=?, meta_keywords=? WHERE id=?',array($_GET['section'],$title, $anons,$_POST['text'],$art,$_POST['meta_title'],$_POST['meta_description'], $_POST['meta_keywords'],$id));
      }
    } else {
      $res=$this->db->query('INSERT articles SET id_section=?, title=?, anons=?, text=?, photo=?, meta_title=?, meta_description=?, meta_keywords=? ',array($_GET['section'],$title, $anons,$_POST['text'],$art,$_POST['meta_title'],$_POST['meta_description'], $_POST['meta_keywords']));
    }
  }

  function delete_item($id) {
    $res=$this->db->query('DELETE FROM articles WHERE id=?',$id);
  }
  
  
}
