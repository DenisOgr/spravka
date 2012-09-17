<?
Class Admin_news {
  private $db,$var,$verify=true, $index, $cursor;

  function __construct(){
    //$this->var['section']=$_GET['section'];
    //$this->var['today']=date('d.m.Y');
    $this->db=new DB();
    if (isset($_GET['delete_item'])) {
      $this->delete_item($_GET['delete_item']);
    }

    if (isset($_POST['cancel'])) {
      unset($_GET['edit_item'],$_GET['add']);
    }
 		if (isset($_GET['image_item'])) {
			$this->image($_GET['image_item']);
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
  }

  function show() {
    if (isset($_GET['edit_item'])) {
      $xml=$this->get_item($_GET['edit_item']);
    } elseif (isset($_GET['add'])) {
      $xml=$this->get_item(null);
    } else {
      $xml=$this->get_list();
    }
 		if (isset($this->cursor)) {
		(is_null($this->index)) ? $this->index=$this->cursor : $this->index=array_merge($this->index,$this->cursor);
		}

    //XML::debug();
    return XML::transform('content',$this->xsl);
  }

  function verify_fill() {
    if (trim($_POST['anons'])=='' || trim($_POST['title'])=='' || trim($_POST['date'])=='' /*|| trim($_POST['date'])=='00.00.0000'*/) {
      $this->verify = false;
      Message::error('Поля, отмеченные * обязательны для заполнения');
    }
    return $this->verify;
  }

  function get_item($id) {
    $this->xsl=MODULES.'news/item_news';
    if (!$this->verify) {
      XML::from_array($_POST,'item_news');
    } elseif (!is_null($id)) {
      XML::from_db('SELECT *, DATE_FORMAT(date,"%d.%m.%Y") as date FROM news WHERE id=?',$id,'item_news');
    }
    XML::add_node('item_news',null, array('today'=>date('d.m.Y')));
  }

  function get_list() {
    $this->xsl=MODULES.'news/list_news';
    XML::from_db('SELECT *, DATE_FORMAT(date,"%d.%m.%Y") as date FROM news as n WHERE id_section=? ORDER BY n.date DESC',$_GET['section'],'list_news');  
    XML::add_node('list_news',null, array('section'=>$_GET['section']));
  }

  function save_item($id) {    
    if ($id!=null) {
      if ($id!=0) {
        $res=$this->db->query('UPDATE news SET id_section=?, title=?, date=?, anons=?, text=? WHERE id=?', array($_GET['section'], $_POST['title'], general::date2db($_POST['date']), $_POST['anons'], $_POST['text'], $id));
      }
    } else {
      $res=$this->db->query('INSERT news SET id_section=?, title=?, date=?, anons=?, text=?', array($_GET['section'], $_POST['title'], general::date2db($_POST['date']), $_POST['anons'], $_POST['text']));
    }
  }

  function delete_item($id) {
    $res=$this->db->query('DELETE FROM news WHERE id=?',$id);
  }
  
  function image($id) {
		$_SESSION['save_info']['class']='Admin_news';
		$_SESSION['save_info']['id']=$id;

		XML::add_node('list_news',null,array('image_item'=>$id));
	}

	function save_image($value) {
		$this->db->query('UPDATE news SET image=! WHERE id=!', array($value,$_SESSION['save_info']['id']));
	}
}
