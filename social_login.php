<?
session_start();
if (isset($_GET['logout'])) {
	unset($_SESSION['uid']);
	unset($_SESSION['network']);
	echo '<div id="t_message">Чтобы оставить отзыв, необходимо войти</div>
	<div id="uLogin"	x-ulogin-params="display=small;fields=first_name,last_name,photo;providers=vkontakte,odnoklassniki,mailru,facebook,google,twitter,livejournal,yandex;hidden=;redirect_uri=http%3A%2F%2Fspravka-melitopol.info/ulogin_xd.html;callback=social_login"></div>';
} elseif (isset($_GET['token'])) {
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
		echo '
		<b>'.$user['first_name'].' '.$user['last_name'].'</b>		
		<a href="#" id="logout">Выйти</a>
		<form method="post">
		<input type="hidden" name="id_user" value="'.$id_user.'" />
		<input name="id_item" type="hidden" value="'.$_GET['item'].'" />
		<img src="'.$user['photo'].'" class="photo" />
		<textarea id="comment_text" name="text"></textarea>
		<br />
		<input type="submit" name="save_message" value="Отправить" />
		</form>';
	}
}
