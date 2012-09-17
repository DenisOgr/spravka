<?php
define('DBHOST', 'localhost');
define('DBLOGIN', 'root');
define('DBPASSWORD', 'zaq1');
define('DBNAME', 'spravka');


define('ROOT', dirname(__FILE__).'/');
if(isset($_SERVER['SERVER_NAME'])){
	define('HOSTNAME','http://'.$_SERVER['SERVER_NAME']);
	define('HOST','http://'.trim($_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']),'/'));
}
define('ENGINE', ROOT.'engine/');
define('MODULES', ROOT.'modules/');
define('CL', ENGINE.'class/');
define('XML', ENGINE.'xml/');
define('UPLOADS', 'uploads/');
define('THUMB', 'thumb/');

define('IMAGE_DIR',HOSTNAME.'/uploads/');
define('IMAGE_DIR_FOR_UPLOAD',ROOT.'uploads/');
define('GIMAGE_DIR',HOSTNAME.'/uploads/');


define('EMAIL_ADMIN', 'info@programmer.net.ua');
define('EMAIL_CC', 'info@programmer.net.ua');
define('EMAIL_REPORT', 'info@programmer.net.ua');
define('EMAIL_FROM', 'robot@spravka-melitopol.info');

define('COUNT_DELIVERY', 25);

define('DEBUG',1);
?>