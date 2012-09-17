<?

class Admin_main {

  private $db, $verify = true;

  function __construct () {
    $this->db = new DB();
    if (isset($_GET['delete_music'])) {
      @unlink(ROOT . UPLOADS . 'music.mp3');
    }
    if (isset($_POST['save_item']) && $this->verify_fill()) {
      $this->save_item();
    }
  }

  function show () {
    $this->get_item();
    //XML::debug();
    return XML::transform('content', $this->xsl);
  }

  function verify_fill () {
    if (trim($_POST['copyright']) == '' || trim($_POST['title']) == '') {
      $this->verify = false;
      Message::error('Поля, отмеченные * обязательны для заполнения');
    } else {
      Message::success('Информация успешно сохранена');
    }
    return $this->verify;
  }

  function get_item () {
    $this->xsl = MODULES . 'main/item_main';
    if (! $this->verify) {
      XML::from_array($_POST, 'item_main');
    } else {
      XML::from_db('SELECT * FROM main', array(), 'item_main'); // решить с параметрами
    }
    XML::add_node('root', 'domain', HOST);
    XML::add_node('root', 'server_root', ROOT);
  }

  function save_item () {
    $uploadfile = ROOT . UPLOADS . 'music.mp3';
    if ($_FILES['music']['type']!="") {
      if ($_FILES['music']['type'] != 'audio/mpeg') {
        Message::error('Не поддерживаемый формат аудио файла');
      } elseif (! move_uploaded_file($_FILES['music']['tmp_name'], $uploadfile)) {
        Message::error('Не удалось загрузить файл');
      }
    }
    $count = $this->db->get_one('SELECT COUNT(*) FROM main');
    ($count == 0) 
    ? $query = 'INSERT' 
    : $query = 'UPDATE';
    $this->db->query($query.' main SET copyright=?, title=?, photo1=?, link1=?, text=?', array($_POST['copyright'] , $_POST['title'] , $_POST['photo1'] , $_POST['link1'],$_POST['text']));
  }
}
