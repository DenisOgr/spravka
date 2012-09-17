<?
Class Admin_gallery {
  private $db, $page, $images_count, $image_width, $image_height, $sections, $mas, $mites, $index, $add_mas;


  function __construct(){
    //var_dump($_POST,$_FILES);
    $this->db=new DB();
    $this->get_constants();

    if (isset ($_POST['save'])){
      if ($_POST['id'] != 0) {
        $this->save($_POST['id']);
        $this->save_visibles($_POST['id']);
      } else {
        $this->save();
      }

    } elseif (isset($_GET['delete'])) {
      $this->delete($_GET['delete']);
    }
  }

  function show() {
    if (isset($_GET['page'])) {
      $this->page=$_GET['page'];
    } else {
      $this->page=1;
    }
    if (isset($_GET['edit'])) {
      //if (isset($_POST['save']))
      $xml=$this->edit($_GET['edit']);
    } else {
      $xml=$this->get_list();
    }
    $this->get_sections();
    //XML::debug();
    return XML::transform('content',$this->xsl);
  }

  function verify() {
    if ($_POST['id'] == 0 && trim($_FILES['userfile']['name']=='')) {
      Message::error('Поля, отмеченные * обязательны для заполнения');
      return false;
    } else {
      return true;
    }
  }

  function get_list() {
    $this->xsl=MODULES.'gallery/admin_gallery';
    $start=($this->page-1)*$this->images_count;
    XML::from_db('SELECT * FROM gallery WHERE id_section=? ORDER BY id DESC LIMIT ?,?',array($_GET['section'],$start,$this->images_count),'gallery','picture');
    XML::add_node('gallery',null, array('section'=>$_GET['section']));
    XML::add_node('gallery','width',strval($this->image_width));
    XML::add_node('gallery','height',strval($this->image_height));
    XML::add_node('gallery','long_path',IMAGE_DIR.THUMB);
    XML::add_node('gallery','short_path',IMAGE_DIR);
    XML::add_node('gallery','page',strval($this->page));
    $this->links($this->page);
    $this->show_add_form();
  }

  function save($id=null) {
    if ($this->verify()) {
      if (substr($_POST['text'], 0,7)!='http://'){
        $_POST['text']='http://'.$_POST['text'];
      }
      $scroller=(isset($_POST['scroller'])) ? 1 : 0;

      if ($_FILES['userfile']['name']=='') {
        $mime='image/jpeg';
      } else {
        $mime=$_FILES['userfile']['type'];
      }
      if ($ext=Files::get_extention( $mime)) {
        if (is_null($id)){
          $res=$this->db->query('INSERT gallery SET id_section=?, text=?, extension=?, scroller=?', array($_GET['section'], $_POST['text'], $ext, $scroller));
          $id=$this->db->get_one('SELECT max(id) FROM gallery');
          $new_filename='fg'.$_GET['section'].'_'.$id.$ext;
          $this->save_visibles($id);

        } else {
          if (trim($_FILES['userfile']['name']!='')) {
            $this->delete($id, false);
            $res=$this->db->query('UPDATE gallery SET text=?, extension=?, scroller=? WHERE id=?', array( $_POST['text'], $ext, $scroller, $id));
          } else {
            $res=$this->db->query('UPDATE gallery SET text=?, scroller=? WHERE id=?', array($_POST['text'], $scroller, $id));
          }
          $new_filename='fg'.$_GET['section'].'_'.$id.$ext;
        }
        Files::mkdir(IMAGE_DIR_FOR_UPLOAD);
        if (trim($_FILES['userfile']['name']!='')) {
          if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
            if (move_uploaded_file($_FILES['userfile']['tmp_name'],IMAGE_DIR_FOR_UPLOAD.$new_filename)){
              Files::upload(IMAGE_DIR_FOR_UPLOAD.$new_filename,array('thumb'=>IMAGE_DIR_FOR_UPLOAD.THUMB,'width'=>$this->image_width,'height'=>$this->image_height),$mime);
            }
          }
        }
      }
      unset($_POST['text']);
    }
  }

  function delete($id,$from_base=true) {
    $ext=$this->db->get_one('SELECT extension FROM gallery WHERE id=?',array($id));
    if ($from_base) {
      $max=$this->db->get_one('SELECT min(id) FROM gallery WHERE id_section=?', array($_GET['section']));
      $res=$this->db->query('DELETE FROM gallery WHERE id=?',$id);
      $this->db->query('DELETE FROM gallery_vis WHERE id=?',$id);

      if ($id==$max){
        if (isset($_GET['page']) && $_GET['page']!=1){
          $_GET['page']--;
        } else {
          $_GET['page']=1;
        }
      }
    }
    $temp=IMAGE_DIR_FOR_UPLOAD.'fg'.$_GET['section'].'_'.$id.$ext;
    if (file_exists($temp)) {
      unlink($temp);
    }
    $temp2=IMAGE_DIR_FOR_UPLOAD.THUMB.'fg'.$_GET['section'].'_'.$id.$ext;
    if (file_exists($temp2)) {
      unlink($temp2);
    }
  }

  function get_constants(){
    $this->images_count=10;
    $this->image_width=250;
    $this->image_height=250;
  }

  function show_add_form(){
    if (isset($_POST['text'])) {
      XML::add_node('gallery', 'message',strval($_POST['text']));
    }
    XML::add_node('gallery', 'add_form');
  }

  function edit ($id){
    $this->xsl=MODULES.'gallery/admin_gallery';
    $text=$this->db->get_one('SELECT text FROM gallery WHERE id=?',$id);
    $ext=$this->db->get_one('SELECT extension FROM gallery WHERE id=?',$id);
    $scroller=$this->db->get_one('SELECT scroller FROM gallery WHERE id=?',$id);
    XML::add_node('gallery', 'add_form');
    /*if (isset($_POST['text'])) {
    XML::add_node('add_form', 'message',strval($_POST['text']));
    }*/
    XML::add_node('add_form', 'id',$id);
    XML::add_node('add_form', 'page',$this->page);
    XML::add_node('add_form', 'extension',$ext);
    XML::add_node('add_form', 'message',$text);
    XML::add_node('add_form', 'scroller',$scroller);
    XML::add_node('gallery','long_path',IMAGE_DIR.THUMB);
    XML::add_node('gallery',null, array('section'=>$_GET['section']));
    $this->get_visibles($id);
  }

  function links($page){
    $vsego_strok=$this->db->get_one('SELECT COUNT(*) from gallery where id_section=?', array($_GET['section']));
    $vsego_stranic=ceil($vsego_strok/$this->images_count);
    $current_page=1;
    $stroka='';
    if ($vsego_stranic>1){
      while ($current_page<=$vsego_stranic){
        if ($current_page!=$page){
          $stroka=$stroka.' '.'<a href="?section='.$_GET['section'].'&page='.$current_page.'">'.' '.$current_page.'</a>'.'  ';
        } else {
          $stroka=$stroka.' '.$current_page.'  ';
        }
        $current_page++;
      }
    }
    XML::add_node('gallery','links',$stroka);
  }

  function get_sections() {
    $this->sections=$this->db->get_all('SELECT id, id_parent, name FROM section ORDER BY id_parent, priority');
    foreach ($this->sections as $key => $val){
      $this->mas[$val['id_parent']][]=$val['id'];
      $this->add_mas[$val['id']]['id_parent']=$val['id_parent'];
      $this->add_mas[$val['id']]['name']=$val['name'];
    }
    //  	echo $mas[4][1].'<br/>';
    //  foreach ($mas as $key => $val){
    // 	echo $key.'<br/>';
    //}

    $this->pass(null,0,0);
    //		var_dump($this->mas);
    XML::from_array($this->index,'gallery','sec_vis');
  }


  function pass($i, $j, $k) {
    if (isset($this->mas[$i][$j]) || ($i==-1 && $j==-1)) {
      if (isset($this->mas[$i][$j])) {
        $id_sect=$this->mas[$i][$j];
        $this->mites[]=array($i,$j);
      } else $id_sect=0;

      $this->index[$k]['id']=$id_sect;
      $this->index[$k]['level']=count($this->mites);
      $this->index[$k]['id_parent']=$this->add_mas[$id_sect]['id_parent'];
      $this->index[$k]['name']=$this->add_mas[$id_sect]['name'];
      /*if (isset($_GET['section']) && $_GET['section']==$id_sect) {
      $this->select=count($this->index)-1;
      }*/
      $this->pass($id_sect,0,$k+1);
    } else {
      if ($i==0) {
        return 1;
      }
      // сделать чтобы стартовало с доступного id а не c 1
      list($i,$j)=@array_pop($this->mites);
      $this->pass($i,$j+1,$k+1);
    }
  }

  function bild_tree(){
    //if (isset($this->sections[''])){

    //}
  }

  function get_visibles($id) {
    XML::from_db('SELECT id_section AS sec FROM gallery_vis WHERE id=?',$id,'gallery','vis_item');
  }

  function save_visibles($id) {
    if (isset($_POST['visible'])) {
      $this->db->query('DELETE FROM gallery_vis WHERE id=?',$id);
      $query ='INSERT INTO `gallery_vis` (`id`, `id_section`) VALUES';
      $qval='';
      foreach ($_POST['visible'] as $key => $val) {
        if ($qval==''){
          $qval='('.$id.', '.$val.')';
        } else	$qval.=',('.$id.', '.$val.')';
      }
      $query.=$qval;
      $this->db->query($query);
    }
  }

}
