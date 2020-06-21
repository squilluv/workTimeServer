<?php

class User
{

	public static function checkUserData($login, $password)
	{
		$file = new SplFileObject(ROOT . '/components/logpass.txt');
		$file->seek(0);
		$logpass = explode("-", $file);
		if ($logpass[0] == $login && $logpass[1] == $password) {
			return true;
		} else {
			return false;
		}
	}

	public static function auth($userId)
	{
		$_SESSION['user'] = $userId;
	}

	public static function checkLogged()
	{

		if (isset($_SESSION['user'])) {
			return $_SESSION['user'];
		}

		header("Location: /user/login");
	}

	public static function isGuest()
	{

		if (isset($_SESSION['user'])) {
			return false;
		}
		return true;
	}
}
