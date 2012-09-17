<?
header('Content-type: text/html; charset=UTF-8');
session_start();
include 'config.php';
include LIB.'init.php';

var_dump($_POST);
echo '<form method="post" >
<input type="text" name="find_text"></input>
<br/>
<input type="checkbox" name="precisely">Точная фраза (чуствительна к регистру)</input>
<br/>
<input type="submit" name="search"/ value="Искать">
</form>';


if (isset($_POST['search'])) {
  if (isset($_POST['find_text']) && ($_POST['find_text']!='')) {
    $search = new Search();
    (isset($_POST['precisely'])) ? ($precisely = true) : ($precisely = false);
    $search->show($_POST['find_text'],$precisely);
  }
}
?>