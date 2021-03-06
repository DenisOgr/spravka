<?
// code from php.spb.ru
 
class html_mime_mail {
  var $headers; 
  var $multipart; 
  var $mime; 
  var $html; 
  var $text; 
  var $parts = array(); 

function html_mime_mail($headers="") { 
    $this->headers=$headers; 
} 

function add_html($html="") { 
    $this->html.=$html; 
} 

function add_text($text="") { 
    $this->text.=$text; 
} 

function build_html($orig_boundary,$kod) { 
    $this->multipart.="--$orig_boundary\n"; 
    if ($kod=='w' || $kod=='win' || $kod=='windows-1251') $kod='windows-1251';
    else $kod='koi8-r';    
    (func_num_args()>2) ? $content_type='text/html' : $content_type='text/plain';    
    $this->multipart.="Content-Type: ".$content_type."; charset=$kod\n"; 
    $this->multipart.="Content-Transfer-Encoding: 8bit\n\n"; 
    (func_num_args()>2) ? $this->multipart.="$this->html\n\n" : $this->multipart.="$this->text\n\n";
} 


function add_attachment($path="", $name = "", $c_type="application/octet-stream") { 
    if (!file_exists($path.$name)) {
      //print "File $path.$name dosn't exist.";
      return;
    }
    $fp=fopen($path.$name,"r");
    if (!$fp) {
      print "File $path.$name coudn't be read.";
      return;
    } 
    $file=fread($fp, filesize($path.$name));
    fclose($fp);
    $this->parts[]=array("body"=>$file, "name"=>$name, "c_type"=>$c_type); 
} 


function build_part($i) { 
    $message_part=""; 
    $message_part.="Content-Type: ".$this->parts[$i]["c_type"]; 
    if ($this->parts[$i]["name"]!="") 
       $message_part.="; name = \"".$this->parts[$i]["name"]."\"\n"; 
    else 
       $message_part.="\n"; 
    $message_part.="Content-Transfer-Encoding: base64\n"; 
    $message_part.="Content-Disposition: attachment; filename = \"".
       $this->parts[$i]["name"]."\"\n\n"; 
    $message_part.=chunk_split(base64_encode($this->parts[$i]["body"]))."\n";
    return $message_part; 
} 


function build_message($kod) { 
    $boundary="=_".md5(uniqid(time())); 
    $this->headers.="MIME-Version: 1.0\n"; 
    $this->headers.="Content-Type: multipart/mixed; boundary=\"$boundary\"\n"; 
    $this->multipart=""; 
    $this->multipart.="This is a MIME encoded message.\n\n"; 
    if ($this->html!='') $this->build_html($boundary,$kod,'html'); 
    if ($this->text!='') $this->build_html($boundary,$kod); 
    for ($i=(count($this->parts)-1); $i>=0; $i--)
      $this->multipart.="--$boundary\n".$this->build_part($i); 
    $this->mime = "$this->multipart--$boundary--\n"; 
} 


function send($to, $from, $subject) { 
    $res=mail($to, $subject, $this->mime, 'From: '.$from."\n".$this->headers);
    return $res;
   /* $headers="To: $to\nFrom: $from\nSubject: $subject\nX-Mailer: The Mouse!\n$headers";
    $fp = fsockopen($server, 25, &$errno, &$errstr, 30);
    if (!$fp)
       die("Server $server. Connection failed: $errno, $errstr");
    fputs($fp,"HELO $server\n");
    fputs($fp,"MAIL FROM: $from\n");
    fputs($fp,"RCPT TO: $to\n");
    fputs($fp,"DATA\n");
    fputs($fp,$this->headers);
    if (strlen($headers))
      fputs($fp,"$headers\n");
    fputs($fp,$this->mime);
    fputs($fp,"\n.\nQUIT\n");
    while(!feof($fp))
      $resp.=fgets($fp,1024);
    fclose($fp);
  } */
}
}
?>
