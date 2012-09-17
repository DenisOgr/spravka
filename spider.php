<?
define('DOMAIN', 'http://spravka-melitopol.info/');
header('Content-type: text/html; charset=UTF-8');
session_start();
include 'config.php';
include ENGINE . 'init.php';
//echo '<META HTTP-EQUIV="Refresh" CONTENT="20;">';
$db = new Db();
$day = $db->get_one('select * from index_date limit 1');
$day_now = date('d');
$spider = new Spider('UTF-8');
if ($day != $day_now) {
  $index_new = true;
  $db->query('TRUNCATE `index_date`;');
  $db->query('INSERT INTO `index_date` (`index_date`) VALUES (?)', array($day_now));
} else {
  $index_new = false;
  $count_links = $db->get_one('SELECT COUNT(*) FROM links');
  $count_pages = $db->get_one('SELECT COUNT(*) FROM pages');
/*if ($count_links!=$count_pages) {
  $f=mail(EMAIL_ADMIN, DOMAIN, $count_links . ' - ' . $count_pages);
}*/
}

$spider->start_index(DOMAIN, $index_new);
?>