<?
Class Admin_question {

  private $limit_count, $page;
  function __construct(){
    $this->db=new DB();
  }

  function show() {
    if (isset($_GET['page'])) {
      $this->page=$_GET['page'];
    } else {
      $this->page=1;
    }
    $this->limit_count=100;
    if (isset($_GET['delete'])) {
      $this->delete($_GET['delete']);
      $messages=$this->question_list($this->page);
      //XML::debug();
      $links=$this->links($this->page);
    } elseif (isset($_GET['edit'])){
      if (isset($_POST['save'])){
        $this->save($_GET['edit']);
        $this->question_list($this->page);
      } else {
        $this->edit($_GET['edit']);
      }
    } else {
      $this->question_list($this->page);
    }
    $this->xsl=MODULES.'question/admin_question';
         // XML::debug();
    XML::add_node('question',null, array('section'=>$_GET['section']));         
    return XML::transform('content',$this->xsl);
  }

  function question_list($page) {
    $limit_start=($page-1)*$this->limit_count;
    XML::from_db('SELECT id, question, answer, visible, DATE_FORMAT(date,"%d.%m.%Y %k:%i") as date, name, email, phone  FROM question ORDER BY `date` ASC limit ?,?',array($limit_start,$this->limit_count),'question','list');
    
  }

  function delete($id) {
    $res=$this->db->query('DELETE FROM question WHERE id=?',$id);
  }

  function links ($page){
    $vsego_strok_res=$this->db->query('SELECT COUNT(*) from question');
    while ($temp=mysql_fetch_array($vsego_strok_res)){
      $vsego_strok=$temp[0];
    }
    $vsego_stranic=ceil($vsego_strok/$this->limit_count);
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

    XML::add_node('guest','links',$stroka);
    $ostalos_zapisej=$this->db->get_one('SELECT COUNT(*) from question');
    if ((($this->page-1)*$this->limit_count+1)==$ostalos_zapisej) {
      $this->page--;
    }
    XML::add_node('guest','page', strval($this->page));
  }

  function edit($id){
    XML::from_db('SELECT id, question, answer, visible, DATE_FORMAT(date,"%d.%m.%Y %k:%i") as date,  name, email, phone  FROM question WHERE id=?',array($id),'question','edit');
  }
  
  function save ($id) {
    if (isset($_POST['visible'])){
      $visible=1;
    } else {
      $visible=0;
    }
    $res=$this->db->query('UPDATE question SET name=?, `email`=?, `phone`=?, `date`=?, `question`=?, answer=?, visible=?
    WHERE id=?',array($_POST['name'],$_POST['email'],$_POST['phone'], general::date2db($_POST['date']),$_POST['question']
    ,$_POST['answer'],$visible, $id));    
  }

}