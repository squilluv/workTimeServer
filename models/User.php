<?php

class User
{

	public static function checkUserData($login, $password)
	{
		$db = Db::getConnection();

		$sql = "SELECT *
				FROM users
				WHERE login = :login AND password = :password";

		$result = $db->prepare($sql);
		$result->bindParam(':login', $login, PDO::PARAM_INT);
		$result->bindParam(':password', $password, PDO::PARAM_STR);
		$result->execute();

		$user = $result->fetch();
		if($user) {
			return $user['id_user'];
		}
		return false;
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