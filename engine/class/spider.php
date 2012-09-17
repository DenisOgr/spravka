<?

function getmicrotime(){
  list($usec, $sec) = explode(" ",microtime());
  return ((float)$usec + (float)$sec);
}


/**
 * Класс индексирования сайта
 *
 */
class Spider {

  private $current_page;
  private $current_id;
  private $db;
  private $time_start,$time_end;
  private $encoding;



  /**
	 * Конструктор
	 *
	 */
  function __construct($encoding='utf-8') {
    $this->encoding = $encoding;
    $this->time_start = getmicrotime();
    $this->db = new Db();
    // $this->db->connect('root','','localhost','search');
    $this->current_page='';
    $this->current_id=1;
  }

  function real_path($path) {
    $parts_path=explode('/', $path);
    $output=array();
    for ($i=0; $i<sizeof($parts_path); $i++) {
      if (''==$parts_path[$i] || '.'==$parts_path[$i]) continue;
      if ('..'==$parts_path[$i] && $i>0 && '..'!=@$output[sizeof($output)-1]) {
        array_pop($output);
        continue;
      }
      array_push($output, $parts_path[$i]);
    }
    return implode('/', $output);
  }

  function correct_url($current_url,$in_url) {
    $current_url=@parse_url($current_url);
    $in_url=@parse_url($in_url);

    // если абсолютная ссылка
    if (isset($in_url['scheme']) || isset($in_url['host'])) {
      if ((isset($in_url['scheme']) && $in_url['scheme']!='http') || (isset($in_url['host']) && !eregi(DOMAIN.'$', $in_url['host']))) {
        $in_url=false;
      }
      // если относительная ссылка
    } else {

      $in_url['scheme']=$current_url['scheme'];
      $in_url['host']=$current_url['host'];


      if (isset($in_url['path'])) {
        if (substr($in_url['path'],0,1)!='/' && isset($current_url['path'])) {
          if (substr($current_url['path'],0,-1)!='/') {
            $pathinfo=pathinfo($current_url['path']);
            if (isset($pathinfo['extension'])) {
            ($pathinfo['dirname']=='/' || $pathinfo['dirname']=='\\') ? $current_url['path']='' : $current_url['path']=$pathinfo['dirname'];
            }
          }
        } else {
          $current_url['path']='';
        }

        $in_url['path']='/'.$this->real_path($current_url['path'].'/'.$in_url['path']);

        if ($in_url['path']!='/' && substr($in_url['path'],0,-1)!='/') {
          $pathinfo=pathinfo($in_url['path']);
          if (!isset($pathinfo['extension'])) {
            $in_url['path'].='/';
          }
        }
      } elseif (isset($in_url['query'])) {
        $in_url['path']=$current_url['path'];
      } else {
        $in_url=false;
      }
    }

    if ($in_url) {
      $str=$in_url['scheme'].'://'.$in_url['host'];
      if (isset($in_url['path'])) {
        $str.=$in_url['path'];
      } else {
        $str.='/';
      }
      if (isset($in_url['query'])) {
        $str.='?'.$in_url['query'];
      }
      return $str;
    } else return false;
  }



  /**
	 * Добавление новой линки в базу данных
	 *
	 * @param string $str Содержание страницы
	 * @param boolean $full_url Полная ли ссылка
	 * @return string Содержание страницы без дополнительных тегов
	 */
  function link_add($links) {
    //$speed = new Speed;
   // $start_speed = $speed->get();
    foreach ($links as $link) {
      $original=$link;
     // $speed->get();
      if (!preg_match('/\.(jpg|pdf|doc|gif|png|rar|zip|djvu|bmp|avi|mov|ppt|xcl)\b/si', $link)) {
        $link = str_replace('://www.', '://', $link);
        if ($link=$this->correct_url($this->current_page,$link)) {
          $link = html_entity_decode($link);
          if ($this->db->get_one('select count(id) from links where link=?',$link) == 0) {
            if (DEBUG) echo '[=] '.$this->current_page.' [-] '.$link.' [=]<hr/>';
            logging($this->current_page.'+'.$original."= \t\t".$link."\t\t".var_export(parse_url($original),true));
            $this->db->query('insert into links set link=?, indexed=0;',$link);
          }
        }
      }
    }
    //logging("\n".'cheked - '.count($links)." links\nbehind ".($speed->get()-$start_speed).' s.');
    $links = null;
  }

  /**
	 * Обрамляет найденную ссылку в специальные теги <_link_> ... </_link_>
	 *
	 * @param string $str Содержание страницы
	 */
  function url_hilight($str) {
    preg_match_all('/<a.+?href(\\s{0,})=(\\s{0,})["|\\\'](.*?)["|\\\'].*?>/si', $str, $result, PREG_PATTERN_ORDER);
    $result = $result[3];
    $this->link_add($result);

    preg_match_all('/<(frame|iframe).+?src(\\s{0,})=(\\s{0,})["|\\\'](.*?)["|\\\'].*?>/si', $str, $result, PREG_PATTERN_ORDER);
    $result = $result[4];
    $this->link_add($result);

    return $str;
  }


  function valid_page($url) {
    if ($url){
      $handle = fopen($url, "r");
      //var_dump($url,$handle);
      $ar=stream_get_meta_data($handle);
      return ($ar['wrapper_data'][0]=='HTTP/1.1 200 OK' && in_array('Content-Type: text/html; charset=UTF-8',$ar['wrapper_data']));
    } else return false;
  }

  /**
	 * Enter description here...
	 *
	 * @param unknown_type $url
	 */
  function start_index($url,$start=true,$debug=DEBUG) {
    if ($start) {
      //$this->db->query('SET FOREIGN_KEY_CHECKS=0;');
      $this->db->query("CREATE TABLE IF NOT EXISTS `links` (
  		`id` int(10) NOT NULL auto_increment,
  		`link` text NOT NULL,
  		`indexed` int(1) NOT NULL default '0',
  		PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
      $this->db->query("CREATE TABLE IF NOT EXISTS `pages` (
  		`id` int(10) NOT NULL auto_increment,
  		`id_link` int(10) NOT NULL default '0',
  		`title` varchar(250) NOT NULL default '',
		  `pagetext` text NOT NULL,
  		`link` text,
  		PRIMARY KEY  (`id`),
  		FULLTEXT KEY `text` (`pagetext`)
		) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
      $this->db->query('TRUNCATE `links`;');
      $this->db->query('TRUNCATE `pages`;');
      $this->db->query('insert into links set link=?, indexed=1',$url);
    }
      //$this->db->query('UPDATE `eventum4`.`links` SET `indexed` = "0" WHERE `links`.`id` =347');
    do {
      if (!$start) {
        $row = $this->db->get_row('select * from links as l where indexed=\'0\' order by l.id limit 1');
        $url = $row['link'];
        $this->current_id = $row['id'];
      } else {
        $this->current_id = 1;
        $start = false;
      }

      if ($this->valid_page($url)) {
        $page_str = @file_get_contents($url);
        
       
        //
        $this->current_page=$url;
        
        $page_str = $this->url_hilight($page_str); // Захват ссылок  
        
        $page_str=str_replace("\n"," ",$page_str);
        $page_str=explode(" ",$page_str);
   
        $add=true;
         $new_str=array();
        foreach ($page_str as $str) {
          if ($str=='<!--END-->') {
            $add=true;
          }
          if ($str=='<!--START-->') {
            $add=false;
          }
          if ($add) {
            $new_str[]=$str;
          }
        }
        $page_str=implode(" ",$new_str);
       /* var_dump($this->current_page,$page_str);
       die('<hr>'); */ 

        
$search=array(

        "'<script[^>]*>.*?</script>'si", 
        "'<style[^>]*>.*?</style>'si",
        //"'<!--START-->.*?<!--END-->'si",

        "'&(quot|#34);'i", // Заменяет HTML-сущности
        "'&(amp|#38);'i", "'&(lt|#60);'i", "'&(gt|#62);'i", "'&(nbsp|#160);'i", "'&(iexcl|#161);'i", "'&(cent|#162);'i", "'&(pound|#163);'i", "'&(copy|#169);'i", "'&hellip;'i", "'&ndash;'i",

        "'&laquo;'i", "'&raquo;'i" );

        $replace=array(

        "", 
        "",
        //"bla",

        "\"", "&", "<", ">", " ", chr( 161 ), chr( 162 ), chr( 163 ), chr( 169 ), "...", "-",

        "\"", "\"" );               
        

        if (strtolower($this->encoding) != 'utf-8') {
          if (is_string($page_str)) $page_str = iconv($this->encoding, "utf-8", $page_str);
        }     

        $title = '';
        preg_match('/<title>.*<\/title>/si',$page_str,$title); // �?мя страницы
        if (!empty($title[0])) $title = strip_tags($title[0]);


        if (is_array($title)) {
          $title = '';
        }

        $page_str = str_replace('<',' <',$page_str);
        $page_str = preg_replace($search,$replace,$page_str); // Удаление ненужных тегов !!!!!!!!!!!
  
        $page_str = strip_tags($page_str); 

       
        //$page_str = htmlspecialchars_decode($page_str);
        
        $page_str = preg_replace('/(\,|\.|\?|\r|\n|\t| )+/',' ',$page_str);

        $this->time_end = getmicrotime();
        $time = $this->time_end - $this->time_start;

        if  ($time < 25 || $debug) {
          $this->db->query('update  links set indexed = 1 where id = ?;',$this->current_id);

          $this->db->query('insert into pages set id_link=!, title=?, pagetext=?, link=?', array($this->current_id,$title,$page_str,$this->current_page));
        } else {
          exit();
        }

      } else {
        if (!empty($this->current_id)) {
          $this->db->query('delete from links where id=?;',$this->current_id);
        }
      }
    } while (($this->db->get_one('select count(*) from links where indexed=0;') != 0) && ($time < 25));
  }
}




function logging($text) {
  /*$f=fopen(ROOT.'logging.txt', "a");
  fwrite($f,"\n=======================================================\n");
  fwrite($f,$text);
  fclose($f);*/
}


?>