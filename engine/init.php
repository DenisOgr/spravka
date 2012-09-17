<?

/*if (DEBUG==1) {
set_error_handler('error_handler', E_ALL);
}*/
function error_handler ($errno, $errstr, $errfile, $errline) {
  Error::report(array($errno , $errstr));
}

function __autoload ($classname) {
  $classname = strtolower($classname);
  $path = explode('_', $classname, 2);
  if (isset($path[1])) {
    (file_exists(CL . $classname . '.php')) ? $classname = CL . $classname : $classname = MODULES . $path[1] . '/' . $classname;
  } else {
    $classname = CL . $path[0];
  }
  include $classname . '.php';
}
DB::connect(DBLOGIN, DBPASSWORD, DBHOST, DBNAME);
$count = new Count();
$count->incSection();
//$count->isData() and 
//$count->resetStat();
?>
