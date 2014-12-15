<?php
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}

	foreach($_SESSION as $key => $value) {
		unset($_SESSION[$key]);
	}
session_destroy();
if(isset($_SERVER['HTTP_REFERER'])) {
	header('Location: '.$_SERVER['HTTP_REFERER']);
} else {
	header('location: index.php');
}
exit;
?>