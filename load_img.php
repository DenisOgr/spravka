<?php
header('Content-type: text/html; charset=UTF-8');
session_start();
include('config.php');
include(ROOT.'engine/init.php');
$width  = (isset($_GET['width']) && $_GET['width']!='') ? $_GET['width'] : '*';
$height = (isset($_GET['height']) && $_GET['height']!='') ? $_GET['height']: '*';
$thumb  = (isset($_GET['thumb']) && $_GET['thumb']!='') ? $_GET['thumb'] : '';



$value          =$_GET['value'];
$prefix         =$_GET['prefix'];

$name           =$_GET['name'];
$basename       =$prefix.'v'.$value;
$new_basename   =$prefix.'v'.($value+1);
$filename       =null;
$new_filename   =null;


$uri="?name={$name}&thumb={$thumb}&prefix={$prefix}&width={$width}&height={$height}";

function delete($basename, $value) {
  global  $name, $thumb, $prefix, $width, $height, $uri;
  $extentions=Files::get_extention();
  foreach ($extentions as $ext) {
    foreach (array('',THUMB) as $path) {
      if (file_exists(ROOT.UPLOADS.$path.$basename.$ext)) {
        @unlink(ROOT.UPLOADS.$path.$basename.$ext);
      }
    }
  }
  echo 'window.location=\''.$uri.'&value='.$value.'\';';
}
?>

<html>
  <body>
    <form method="post" action="<?="?name={$name}&value={$value}&thumb={$thumb}&prefix={$prefix}&width={$width}&height={$height}";?>" enctype="multipart/form-data" onsubmit="progress_bar();">
      <div id="load_foto" align="center" style="display:none;"><img src="/img/load.gif"/></div>
      <div id="load_form" align="center">
        <input type="file" onchange="this.form.submit()" name="<?=$name?>"/>
      </div>
    </form>
    <script>
    var input=parent.$$("<?=$name?>");
    var foto=parent.$$("<?=$name?>_foto");
    function progress_bar(){
      var load_foto=document.getElementById('load_foto');
      var load_form=document.getElementById('load_form');
      load_foto.style.display="";
      load_form.style.display="none";
      foto.innerHTML='Загрузка фото ...';
    }
    <?

    // загрузка
    if (isset($_FILES[$name])) {
      //var_dump($_FILES);
      $mime=$_FILES[$name]['type'];
      $ext=Files::get_extention($mime);
      if ($ext) {
        $new_filename=$new_basename.$ext;
        FIles::mkdir(ROOT.UPLOADS);
        if (move_uploaded_file($_FILES[$name]['tmp_name'], ROOT.UPLOADS.$new_filename)) {
          chmod(ROOT.UPLOADS.$new_filename,0644) || Error::report('chmod');
          Files::upload(ROOT.UPLOADS.$new_filename,compact('thumb','width','height'),$mime);

          if (isset($_SESSION['save_info'])) {
            $obj=new $_SESSION['save_info']['class'];
            $obj->save_image($value+1);
          }

          delete($basename,++$value);
        }
      } else {
        echo 'alert("'.$mime.' формат не поддерживается");';
      }

    } else {

      // удаление
      if (isset($_GET['delete'])) {
        delete($basename,0);
        if (isset($_SESSION['save_info'])) {
          $obj=new $_SESSION['save_info']['class'];
          $obj->save_image(0);
        }
      }

      // вывод
      //die($basename);
      if ($ext=Files::get_exists(ROOT.UPLOADS.THUMB.$basename)) {
        echo 'input.value='.$value.'; foto.innerHTML=\''.Files::show($basename.$ext,$width,$height).'<br /><a href="javascript:void(0)" onclick="delete_'.$name.'()">Удалить</a>\'';
      } else {
        echo "input.value=0;\n";
        echo "foto.innerHTML='Нет фото';\n";
      }
    }

    echo '
    </script>
  </body>
</html>';
