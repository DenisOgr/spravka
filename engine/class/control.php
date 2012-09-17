<?
Class Control {
  function show() {

    $sec= new Section;
    $xml_section=$sec->show();
    $main_contact=$main_special=$main_news=null;
    $obj=new Articles2();
    $main_contact=$obj->show(7);
    $main_special=$obj->show(8);
    
    $obj=new News;
    $main_news=$obj->show(3);
    
    $obj=new Main;
    $main=$obj->show('copyright');

    if (empty($_GET)) {
      $_GET['section']=1;
    }

    if (isset($_GET['section'])) {
      Switch ($this->get_module_name($_GET['section'])) {
        case 'main':
          $module=new Main;
          break;
        case 'news':
          $module=new News;
          break;
        case 'registration':
          $module=new Registration;
          break;
        case 'articles2':
          $module=new Articles2;
          break;
        default:
          $module=new Articles;
          break;
      }
    }

    (isset($module))
    ?  $xml_content=$module->show()
    :  $xml_content='';

    XML::add_node('root', false, $main_news, $main_special, $main_contact, $main, $xml_section, $xml_content, array('section'=>$_GET['section']));
  }

  function get_module_name($id) {
    $config=array(1=>'main',3=>'news'/*,5=>'registration'*/,7=>'articles2',8=>'articles2');      // @todo брать из БД
    return (isset($config[$id])) ? $config[$id] : false;
  }
}
?>