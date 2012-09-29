<?
session_start();
if (isset($_GET['token'])) {
	include 'config.php';
	include ENGINE.'init.php';
	$s = file_get_contents('http://ulogin.ru/token.php?token=' . $_GET['token'] . '&host=' . $_SERVER['HTTP_HOST']);
	$user = json_decode($s, true);
	if (isset($user) && !isset($user['error'])) {
		$_SESSION['uid']=$user['uid'];
		$_SESSION['network']=$user['network'];
		$db=new DB();
		$id_user=$db->get_one('SELECT id FROM users WHERE uid=? AND network=?',array($user['uid'],$user['network']));
		if (is_null($id_user)) {
			$db->query('INSERT INTO users SET first_name=?,last_name=?,photo=?,identity=?, profile=?, network=?, uid=?', array($user['first_name'], $user['last_name'], $user['photo'], $user['identity'], $user['profile'], $user['network'], $user['uid']));
			$id_user=$db->last_id();
		}
		echo '<b>'.$user['first_name'].' '.$user['last_name'].'</b><br/>
		<form method="post">
		<input type="hidden" name="id_user" value="'.$id_user.'">
		<img src="'.$user['photo'].'"/>
		<textarea id="comment_text" name="text"></textarea><br/>
		<input type="submit" name="save_message" value="Отправить"/>
		</form>';
	}
}
