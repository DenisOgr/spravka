<?
Class Client_question {
  private $db, $page, $limit_count;

  function __construct(){
    $this->db=new DB();
  }

  function show(){
    XML::add_node('question',null, array('section'=>$_GET['section']));
    $this->limit_count=100;
    if (isset($_POST['save'])) {
      $this->add_message($_POST['name'], $_POST['question'], $_POST['email']);
    }
    if (isset($_GET['page'])) {
      $this->page=$_GET['page'];
    } else {
      $this->page=1;
    }
    $xml=$this->get_list($this->page);
    $temp=$this->message_form();
    $temp2=$this->links($this->page);
    $xml=$xml.$temp.$temp2;
    return XML::get_dom();
  }

  function get_list($page) {
    $limit_start=($page-1)*$this->limit_count;
    XML::from_db('SELECT id, id_section, name, question, answer, email, DATE_FORMAT(date,"%d-%m-%y") as date FROM question as n WHERE visible=? AND id_section=? ORDER BY n.date DESC LIMIT ?,?',array('1',$_GET['section'],$limit_start,$this->limit_count),'question','message');
    //XML::from_db('SELECT id, prof, user, text, email, DATE_FORMAT(date,"%d-%m-%y") as date FROM question WHERE visible=? ',array(1),'question','message_all');
  }

  function message_form() {
    XML::add_node('message_form');
  }

  function add_message($name,$text, $email){
    $can_add=1;
    $er=array();
    if (empty($name) || empty($text) || empty($email)) {
      array_push($er,'Поля отмеченные звездочкой обязательны для заполенния');
      $can_add=0;
    }
    if ($can_add==1) {
      $this->db->query('insert question SET `name`=?, `question`=?, `date`=now(), `email`=?, `phone`=?',array($name, $text, $email, $_POST['phone']));
      array_push($er,'Cпасибо за ваш вопрос, он появится на сайте, после проверки администратором');
      XML::add_node('question', 'error', $er);
    } else {
      XML::add_node('question', 'error', $er);
      XML::from_array($_POST);
    }
  }

  function links($page){
    $vsego_strok_res=mysql_query('SELECT COUNT(*) from question');
    while ($temp=mysql_fetch_array($vsego_strok_res)){
      $vsego_strok=$temp[0];
    }
    $limit_count=2;
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
    XML::add_node('question','links',$stroka);
  }

}