<?
//include('../lib/class/db.php');

//var_dump($_POST);
/*if (isset($_POST['search'])) {
if (isset($_POST['find_text']) && ($_POST['find_text']!='')) {
$search = new Search();
(isset($_POST['precisely'])) ? ($precisely = true) : ($precisely = false);
$search->find($_POST['find_text'],$precisely);
}
}*/
class Client_search {

  private $db;
  private $xml;

  /**
   * Конструктор
   *
   */
  function __construct() {
    $this->db = new Db();
  }

  /**
   * Отобрать поиск и результаты поиска
   *
   * @return dom
   */
  function show() {
    $find_text = '';
    if (isset($_POST['search']) && isset($_POST['find_text']) && $_POST['find_text']!='' ) {
      $find_text = $_POST['find_text'];
      XML::add_node('find','post',$_POST['find_text']);

      if (isset($_POST['precisely']))
      $find_mass = $this->db->get_all('select title,pagetext,link from pages where match (pagetext) against ( ? in boolean mode)',array($find_text));
      else
      $find_mass = $this->db->get_all('select title,pagetext,link from pages where match (pagetext) against ( ? )',array($find_text));
      if (!empty($find_mass)) {
        for ($i=0; $i < count($find_mass); $i++) {
          $text = $find_mass[$i]['pagetext'];
          if (preg_match('/(\\s.{0,200})('.$find_text.')(.{0,200}\\s)/si', $text, $regs)) {
            $regs = $regs[0];
            $regs = preg_replace('/(\\s.{0,200})('.$find_text.')(.{0,200}\\s)/si', '... $1<b>$2</b>$3 ...', $regs);
          } else {
            preg_match('/(\\s.{0,400}\\s)/si', $text, $regs);
            $regs = '... '.$regs[0].' ...';
          }
          $find_mass[$i]['pagetext']=$regs;
          $regs = null;
        }
        XML::from_array($find_mass,'find');
        return XML::get_dom();
      } else {
        $sql = '';
        $m_find = explode(' ',$find_text);
        foreach ($m_find as $value) {
          $sql.='%'.$value;
        }
        $sql.='%';

        $find_mass2= $this->db->get_all('SELECT title,pagetext,link FROM pages WHERE pagetext LIKE ?',array($sql));
        $find_mass = array_merge($find_mass,$find_mass2);

        for ($i=0; $i < count($find_mass); $i++) {
          $text = $find_mass[$i]['pagetext'];
          preg_match('/(\\s.{0,400}\\s)/si', $text, $regs);
          $regs = '... '.$regs[0].' ...';
          $find_mass[$i]['pagetext']=$regs;
          $regs = null;
        }
      }
      if (empty($find_mass)) {
        XML::from_array(array('0'=>array('pagetext' => 'Результатов нет.')),'find');
      } else {
        XML::from_array($find_mass,'find');
      }
    } else {
      XML::add_node('find');
    }

    return XML::get_dom();
  }

}


?>
