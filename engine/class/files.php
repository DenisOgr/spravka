<?php 
// класс для работы с файлами
class Files {

  /**
   * Возвращает первый найденный файл с заданным именем(без расширения) и одним из разрешенных расширений
   * @param имя искомого файла(без расширения) $filename
   * @return имя файла
   *         <pre>
   *          string - полное имя файла с расширением
   *          false  - если ни с одним расширением файл не обнаружен
   *         </pre>
   */
  static function get_exists($pathname) {
    $extentions=self::get_extention();
    foreach ($extentions as $ext) {
      if (file_exists($pathname.$ext)) {
        return $ext;
      }
    }
    return false;
  }

  /**
   * Определение расширений файлов по mime-типу
   *  @param string $in_mime исходный mime-тип 
   *  @return mixed возможные значения: 
   *          <pre>
   *           array      - все расширения, если mime-тип не задан 
   *           string     - если найдено расширение, соответсвующее исходному mime-типу
   *           bool false - если mime-тип задан, но расширение к нему не найдено
   *          </pre>     
  */
  static function get_extention($in_mime=null) {
    $extentions =array('.jpg'=>array('image/jpeg', 'image/pjpeg'),'.gif'=>'image/gif','.png'=>'image/png','.swf'=>'application/x-shockwave-flash');
    if (is_null($in_mime)) {
      return array_keys($extentions);
    }
    foreach ($extentions as $ext=>$mime) {
      if ((is_string($mime) && $in_mime==$mime) || is_array($mime) && (in_array($in_mime, $mime))) {
        return $ext;
      }
    }
    return false;
  }

  /**
   * корректировка ширины и высоты и получение mime-типа файла
   *
   * @param string $filename
   * @param int $width  максимальная ширина  
   * @param int $height максимальная высота 
   * @return array  скорректированные ширина и высота, mime-тип
   */

  static function smart_size($filename,$width,$height) {
    //$mime=mime_content_type($filename);
    $mime='';
    if (!$mime || self::get_extention($mime)) {
      $info = getimagesize($filename);
      if (!$info) {
        return false;
      }

      $width_orig=$info[0];
      $height_orig=$info[1];

      if ($width=='*') {
        $width=$width_orig;
      }

      if ($height=='*') {
        $height=$height_orig;
      }

      if ($width<$width_orig || $height<$height_orig) {

        $ratio_orig = $width_orig/$height_orig;

        if ($width/$height > $ratio_orig) {
          $width = $height*$ratio_orig;
        } else {
          $height = $width/$ratio_orig;
        }
      } else {
        $width=$width_orig;
        $height=$height_orig;
      }

      if ($width<1) {
        $width=1;
      }
      if ($height<1) {
        $height=1;
      }

      return array(array(intval($width),intval($height)), array($width_orig,$height_orig), $info['mime']);
    } else {
      return false;
    }
  }

  static function mkdir($dir) {
    if (!file_exists($dir)) {
      if (!mkdir($dir))  {
        Error::report('Невозможно создать '.$dir);
      } else {
        chmod($dir,0777);
      }
    }
  }

  private function upload_image($filename, $param) {
    $pathinfo=pathinfo($filename);
    $pathinfo['dirname']=preg_replace('/\/big$/','',$pathinfo['dirname']);
    $new_filename=$pathinfo['dirname'].'/'.THUMB.$pathinfo['basename'];// basename берется с расширением !? проверить на сервере

    // создание папки для эскизов если нужно

    self::mkdir($pathinfo['dirname'].'/'.THUMB); // добавить проверку если папка существует, но права не достаточные, fileperms()

    list($size_smart,$size_orig, $mime)=self::smart_size($filename, $param['width'],$param['height']);
    //var_dump($size_smart,$size_orig, $mime);
    if (is_null($mime)) {
      return false;
    }

    list($width,$height)=$size_smart;
    list($width_orig,$height_orig)=$size_orig;
    //var_dump($mime, $param, $size_smart, $size_orig);
    //просто копирование из искодной папки в папку с эскизами, если не было задано пережимать или если изображение и без того меньшего размера
    if ($mime=='application/x-shockwave-flash' || $param['thumb']=='' || ($width==$width_orig && $height==$height_orig))  {
      copy($filename,$new_filename);
    }
    // пережимание в меньший размер
    else {

      switch ($mime) {
        case 'image/png' :
          $image = imagecreatefrompng($filename);
          $image_p = imagecreatetruecolor($width, $height);
          imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
          imagepng($image_p, $new_filename);
          break;
        case 'image/gif' :
          $image = imagecreatefromgif($filename);
          $image_p = imagecreatetruecolor($width, $height);
          $trnprt_indx = imagecolortransparent($image); 
         if ($trnprt_indx >= 0) {
            $trnprt_color = imagecolorsforindex($image, $trnprt_indx);
            $trnprt_indx = imagecolorallocate($image_p, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
            imagefill($image_p, 0, 0, $trnprt_indx);
            imagecolortransparent($image_p, $trnprt_indx);     
          } else {
            $trans = imagecolorallocate($image, 0, 0, 0);
            imagecolortransparent($image, $trans);         
          }          
          /*$trans = imagecolorallocate($image,0,0,0);
          imagecolortransparent($image,$trans);*/
          imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
          imagegif($image_p, $new_filename);
          break;
        case 'image/jpeg' :
        case 'image/pjpeg' :
          $image = imagecreatefromjpeg($filename);
          $image_p = imagecreatetruecolor($width, $height);
          imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
          imagejpeg($image_p, $new_filename,85);
          break;
      }
      chmod($new_filename,0755);
    }
    return true;
  }

  /**
   * Аплоад файлов на сервер
   * @todo сделать поддержку загрузки файлов отличных от (jpg, gif, png и swf)
   * @param string $filename
   * @param string $mime
   * @param array $param дополнительные параметры для загрузки (не обязательно)
   * @return bool false в случае если не удалось обработать файл или формат файла не поддерживается
   */

  static function upload($filename, $param=null, $mime=null) {
    $res=false;
    if (self::get_extention($mime)) {
      if (self::upload_image($filename,$param)) {
        $res=true;
      }
    }
    return $res;
  }

  /**
   * Для вызова из XSLT
   * 
   */  
  static function show_image($prefix,$id,$version, $attribute=''){   
    //var_dump($prefix,$id,$version);echo '<br>';
    (is_numeric($id)) 
    ? $basename=$prefix.'_'.$id.'v'.$version
    : $basename=$prefix.'v'.$version;    
    //var_dump($basename); echo '<hr>';
    
    $ext=self::get_exists(ROOT.UPLOADS.THUMB.$basename);
    if ($ext) {
      $doc = new DOMDocument('1.0');
      $str=Files::show($basename.$ext,'*','*', $attribute);
      //var_dump($str);
      $doc->loadXML($str);
      //var_dump($doc);
      return $doc;
      //return $str;
    } else {
      return '';
    }
  }

  static function show_url($prefix,$id,$version){
    if ($version>0) {
      $basename=$prefix.'_'.$id.'v'.$version;
      $ext=self::get_exists(ROOT.UPLOADS.THUMB.$basename);
      if ($ext) {
        return '/'.UPLOADS.THUMB.$basename.$ext;
      } else {
        return false;
      }
    } else {
      return false;
    }    
  }

  /**
   * Восстановление оригинальных расширений файлов
   *
   * @param string $dir
   * @param string $filename
   * @return int количество файлов подвергшихся восстановлению
   */


  static function recovery_extentions($dir,$filename) {

    $tmp_dir=$dir.'tmp/';
    Files::mkdir($tmp_dir);
    $info = getimagesize($dir.$filename);
    $ext=Files::get_extention($info['mime']);
    $basename=explode('.',$filename);
    if ($ext && '.'.$basename[1]!=$ext) {
      $new_filename=$basename[0].$ext;

      copy($dir.$filename,$tmp_dir.$new_filename);
      unlink($dir.$filename);

      copy($tmp_dir.$new_filename,$dir.$new_filename);
      unlink($tmp_dir.$new_filename);
      return true;
    }
    return false;
  }

  function show($basename,$width,$height,$attribute='') {
    list(list($width, $height),list($width_orig, $height_orig), $mime)=self::smart_size(ROOT.UPLOADS.THUMB.$basename, $width, $height);
    switch ($mime) {
      case 'application/x-shockwave-flash':
        return '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="'.$width.'" height="'.$height.'"><param name="movie" value="/'.UPLOADS.THUMB.$basename.'"></param><param name="quality" value="high"></param><embed src="/'.UPLOADS.THUMB.$basename.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'"></embed></object>';
        break;
      case 'image/png':
      case 'image/gif':
      case 'image/jpeg':
      case 'image/pjpeg':        
        return '<img src="/'.UPLOADS.THUMB.$basename/*.'?'.time()*/.'" width="'.$width.'" height="'.$height.'" '.$attribute.'/>';
        break;

      default:
        return '<a href="/'.UPLOADS.$basename.'">'.$basename.'</a>';
        break;
    }

  }

}


?>
