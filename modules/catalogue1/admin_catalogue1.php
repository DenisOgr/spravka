<?
Class Admin_catalogue1 {
  private $db, $page, $images_count, $image_width, $image_height;
  public $module_options=array('title'=>array('input','textarea'), 
'number'=>array('one','many'),
'anons'=>array('yes','no'));

  function __construct(){
    $this->db=new DB();
    $this->get_constants();
    if (isset ($_GET['delete'])) {
      $this->delete($_GET['delete']);
    } elseif (isset($_POST['save_picture'])){
      $this->save_picture();
    }elseif (isset($_POST['cancel'])){
      unset($_GET['edit']);
      unset($_GET['img_del']);
      header('Location: '.HOST.'?section='.$_GET['section']);
      die();
    }elseif (isset($_POST['save'])){
      //      print "Ну сохраняем мы!1";
      if (isset($_GET['edit'])) {
        //        print "Ну сохраняем мы!2";
        $this->save($_GET['edit']);
      } else {
        //        print "Ну сохраняем мы!3";
        $this->save();
      }
      header('Location: '.HOST.'?section='.$_GET['section']);
      die();
    } elseif (isset($_GET['img_del'])){
      $this->img_del($_GET['img_del']);
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

    $this->xsl=MODULES.'catalogue1/admin_catalogue1';
    if (isset($_GET['edit'])) {
      $xml=$this->edit($_GET['edit']);
    } elseif (isset($_GET['add'])) {
      $xml=$this->edit();
    } else {
      $xml=$this->get_list();
      $xml=$this->links($this->page);
    }
    return XML::transform('content',$this->xsl);
  }

  function verify_load_image() {
    if ($_FILES['userfile']['name']!=''){
      return true;
    }else {
      Message::error('Не указана картинка для загрузки');
      return false;
    }
  }

  function verify_text() {
    if (trim($_POST['name']) == '' && trim($_POST['anons'])=='') {
    //if (trim($_POST['anons'])=='') {
      Message::error('Поля, отмеченные * обязательны для заполнения');
      return false;
    } else { return true;
    }
  }

  function get_list() {
    $start=($this->page-1)*$this->images_count;
    XML::from_db('SELECT catalogue1.id, catalogue1.name, catalogue1.anons, catalogue1.price, cat_images.id AS picture_id, cat_images.version AS picture_ver, cat_images.extension AS picture_ext
FROM catalogue1
LEFT JOIN (SELECT * FROM cat_images ORDER BY cat_images.id DESC) AS cat_images ON catalogue1.id = cat_images.id_goods
WHERE catalogue1.id_section =?
GROUP BY catalogue1.id
ORDER BY catalogue1.id DESC
LIMIT ? , ?',array($_GET['section'],$start,$this->images_count),'catalogue1','item');
    XML::add_node('catalogue1',null, array('section'=>$_GET['section']));
    XML::add_node('catalogue1','add_link');
    //$this->links($this->page);
    //$this->show_form();
    //XML::from_db('SELECT * FROM catalogue1_anons WHERE id_section=?',array($_GET['section']), 'catalogue1', 'anons');
  }

  function save($id=null) {
    if ($this->verify_text()) {
      if (is_null($id)){
        $res=$this->db->query('INSERT catalogue1 SET id_section=?, name=?, anons=?, text=?, meta_title=?, meta_description=?, meta_keywords=?', array($_GET['section'], $_POST['name'], $_POST['anons'], $_POST['text'],$_POST['meta_title'],$_POST['meta_description'], $_POST['meta_keywords']));
        
      } else {
        $res=$this->db->query('UPDATE catalogue1 SET id_section=?, name=?, anons=?, text=?, meta_title=?, meta_description=?, meta_keywords=? WHERE id=?', array($_GET['section'], $_POST['name'], $_POST['anons'], $_POST['text'],$_POST['meta_title'],$_POST['meta_description'], $_POST['meta_keywords'],$id));
        
      }
    }

  }

  function delete($id,$from_base=true) {
    //$ext=$this->db->get_one('SELECT extension FROM cat_images WHERE id=?',array($id));
    if ($from_base) {
      $res=$this->db->query('DELETE FROM catalogue1 WHERE id=?',$id);

      $img_array=$this->db->get_all('SELECT * FROM cat_images WHERE id_goods=?',array($id));
      foreach ($img_array as $pic){
        $temp=IMAGE_DIR_FOR_UPLOAD.'ct'.$pic['id_goods'].'_'.$pic['id'].'_'.$pic['version'].$pic['extension'];
        if (file_exists($temp)) {
          unlink($temp);
        }
        $temp2=IMAGE_DIR_FOR_UPLOAD.THUMB.'ct'.$pic['id_goods'].'_'.$pic['id'].'_'.$pic['version'].$pic['extension'];
        if (file_exists($temp2)) {
          unlink($temp2);
        }
      }
      $res=$this->db->query('DELETE FROM cat_images WHERE id_goods=?',$id);
    }
  }

  function get_constants(){
    $this->images_count=10;
    $this->image_width=150;
    $this->image_height=150;
  }

  function show_form(){
    XML::add_node('catalogue1', 'catalogue1_form');
  }

  function edit ($id=null){
    if (!is_null($id)){
      Xml::from_db('SELECT * FROM catalogue1 WHERE id=?',$id, 'catalogue1', 'edit');
      //Загружаем все картинки, которые соответствуют текущему объекту...
      $this->small_images($id);
    } else {
      $res=$this->db->query('INSERT catalogue1 SET id_section=?', array($_GET['section']));
      $temp=$this->db->get_one('SELECT max(id) FROM catalogue1');
      header('Location: '.HOST.'?section='.$_GET['section'].'&edit='.$temp);
      die();

    }
  }

  function links($page){
    $vsego_strok=$this->db->get_one('SELECT COUNT(*) from catalogue1 where id_section=?', array($_GET['section']));
    $vsego_stranic=ceil($vsego_strok/$this->images_count);
    $current_page=1;
    $stroka='';
    if ($vsego_stranic>1){
      while ($current_page<=$vsego_stranic){
        if ($current_page!=$page){
          $stroka=$stroka.' '.'<a href="?section='.$_GET['section'].'&page='.$current_page.'">'.' '.$current_page.'</a>'.'  ';
        } else {
          $stroka=$stroka.' <b>'.$current_page.'</b> ';
        }
        $current_page++;
      }
    }
    XML::add_node('catalogue1','links',$stroka);
  }

  function small_images($id){
    XML::from_db('SELECT * FROM cat_images WHERE id_goods=? ORDER BY id DESC',$id,'edit','picture');
  }

  function save_picture (){
    //Если открыли новую картинку
    if ($this->verify_load_image()){
      $mime=$_FILES['userfile']['type'];
      $ext=Files::get_extention($mime);
      if (isset($_GET['add'])) {
        $this->save();
        $id=$this->db->get_one('SELECT max(id) FROM catalogue1');
        $ver=0;
        //Если добавляем в старую
      } else {
        $this->save($_GET['edit']);
        $id=$_GET['edit'];
        $ver=0;
      }
      //Сохраняем именно картинку

      $res=$this->db->query('INSERT INTO cat_images (`id_goods`,`version`,`extension`) values (?,?,?)', array($id, $ver, $ext));
      $last=$this->db->get_one('SELECT max(id) FROM cat_images');
      $new_filename='ct'.$id.'_'.$last.'_'.$ver.$ext;
      //print $new_filename;
      if ($_FILES['userfile']['name']!='') {
        if (is_uploaded_file($_FILES['userfile']['tmp_name'])){
          move_uploaded_file($_FILES['userfile']['tmp_name'],IMAGE_DIR_FOR_UPLOAD.$new_filename);
          Files::upload(IMAGE_DIR_FOR_UPLOAD.$new_filename,array('thumb'=>IMAGE_DIR_FOR_UPLOAD.THUMB,'width'=>$this->image_width,'height'=>$this->image_height),$mime);

        }
      }
      //Закончили сохранять именно картинку
      //$this->edit($id);
    }
  }

  function img_del($id){
    $pic=$this->db->get_row('select * from cat_images where id=?', array($id));
    $small_pic=IMAGE_DIR_FOR_UPLOAD.THUMB.'ct'.$_GET['edit'].'_'.$id.'_'.$pic['version'].$pic['extension'];
    //print $small_pic;
    if (file_exists($small_pic)) {
      unlink($small_pic);
    }

    $big_pic=IMAGE_DIR_FOR_UPLOAD.'ct'.$_GET['edit'].'_'.$id.'_'.$pic['version'].$pic['extension'];
    //print $big_pic;
    if (file_exists($big_pic)) {
      unlink($big_pic);
    }

    $res=$this->db->query('delete from cat_images where id=?', array($id));
  }

  function save_anons(){
    if (trim($_POST['anons_title']) == '' || trim($_POST['anons_text'])=='') {
      Message::error('Поля, отмеченные * обязательны для заполнения');
    } else {
      $records_count=$this->db->get_one('SELECT count(*) FROM catalogue1_anons WHERE id_section=?',array($_GET['section']));
      if ($records_count>0){
        $res=$this->db->query('UPDATE catalogue1_anons SET title=?, text=? WHERE id_section=?', array($_POST['anons_title'], $_POST['anons_text'], $_GET['section']));
      } else {
        $res=$this->db->query('INSERT catalogue1_anons SET id_section=?, title=?, text=?', array($_GET['section'], $_POST['anons_title'], $_POST['anons_text']));
      }
    }
  }
}

