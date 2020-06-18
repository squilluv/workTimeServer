<?php

class Main
{
	public static function getProcces()
	{
		$db = Db::getConnection();

		$procces = array();

		$result = $db->query("SELECT id, date_time, name_process, window_title
								FROM processandscreen
								WHERE type='process'
								ORDER BY id DESC");

		$i = 0;
		while ($row = $result->fetch()) {
			$procces[$i]['id'] = $row['id'];
			$procces[$i]['date_time'] = $row['date_time'];
			$procces[$i]['name_process'] = $row['name_process'];
			$procces[$i]['window_title'] = $row['window_title'];
			$i++;
		}
		return $procces;
	}

	public static function getUrls()
	{
		$db = Db::getConnection();

		$url = array();

		$result = $db->query("SELECT id, date_time, url, window_title
								FROM processandscreen
								WHERE type='url'
								ORDER BY id DESC");

		$i = 0;
		while ($row = $result->fetch()) {
			$url[$i]['id'] = $row['id'];
			$url[$i]['date_time'] = $row['date_time'];
			$url[$i]['url'] = $row['url'];
			$url[$i]['window_title'] = $row['window_title'];
			$i++;
		}
		return $url;
	}

	public static function getComps()
	{
		$db = Db::getConnection();

		$comps = array();

		$result = $db->query("SELECT id_computer, name_computer, owner
								FROM computers");

		$i = 0;
		while ($row = $result->fetch()) {
			$comps[$i]['id_computer'] = $row['id_computer'];
			$comps[$i]['owner'] = $row['owner'];
			$comps[$i]['name_computer'] = $row['name_computer'];
			$i++;
		}
		return $comps;
	}

	public static function getUsers()
	{
		$db = Db::getConnection();

		$comps = array();

		$result = $db->query("SELECT id_user, login, name_user
								FROM users");

		$i = 0;
		while ($row = $result->fetch()) {
			$comps[$i]['id_user'] = $row['id_user'];
			$comps[$i]['login'] = $row['login'];
			$comps[$i]['name_user'] = $row['name_user'];
			$i++;
		}
		return $comps;
	}

	public static function getScreens()
	{
		$db = Db::getConnection();

		$screens = array();

		$result = $db->query("SELECT id, date_time
								FROM processandscreen
								WHERE type='screenshot'
								ORDER BY id DESC");

		$i = 0;
		while ($row = $result->fetch()) {
			$screens[$i]['id'] = $row['id'];
			$screens[$i]['date_time'] = $row['date_time'];
			$i++;
		}
		return $screens;
	}

	public static function getProccesByUser($id)
	{
		$db = Db::getConnection();

		$procces = array();

		$result = $db->query("SELECT id, date_time, name_process, window_title
								FROM processandscreen
								WHERE type='process' AND id_user=" . $id . "
								ORDER BY id DESC");

		$i = 0;
		while ($row = $result->fetch()) {
			$procces[$i]['id'] = $row['id'];
			$procces[$i]['date_time'] = $row['date_time'];
			$procces[$i]['name_process'] = $row['name_process'];
			$procces[$i]['window_title'] = $row['window_title'];
			$i++;
		}
		return $procces;
	}

	public static function getUrlsByUser($id)
	{
		$db = Db::getConnection();

		$url = array();

		$result = $db->query("SELECT id, date_time, url, window_title
								FROM processandscreen
								WHERE type='url' AND id_user=" . $id . "
								ORDER BY id DESC");

		$i = 0;
		while ($row = $result->fetch()) {
			$url[$i]['id'] = $row['id'];
			$url[$i]['date_time'] = $row['date_time'];
			$url[$i]['url'] = $row['url'];
			$url[$i]['window_title'] = $row['window_title'];
			$i++;
		}
		return $url;
	}

	public static function getScreensByUser($id)
	{
		$db = Db::getConnection();

		$screens = array();

		$result = $db->query("SELECT id, date_time
								FROM processandscreen
								WHERE type='screenshot' AND id_user=" . $id . "
								ORDER BY id DESC");

		$i = 0;
		while ($row = $result->fetch()) {
			$screens[$i]['id'] = $row['id'];
			$screens[$i]['date_time'] = $row['date_time'];
			$i++;
		}
		return $screens;
	}

	public static function postProccess($data)
	{
		$type = $data['type'];
		$name_process = $data['name_process'];
		$url = $data['url'];
		$window_title = $data['window_title'];
		$screenshot = $data['screenshot'];
		$id_user = $data['id_user'];
		$id_computer = $data['id_computer'];

		$db = Db::getConnection();

		$sql = "INSERT INTO processandscreen
        (date_time, type, name_process, url, window_title, screenshot, id_user, id_computer) 
        VALUES 
        (NOW(), :type, :name_process, :url, :window_title, :screenshot, :id_user, :id_computer)";

		$result = $db->prepare($sql);
		$result->bindParam(':type', $type, PDO::PARAM_STR);
		$result->bindParam(':name_process', $name_process, PDO::PARAM_STR);
		$result->bindParam(':url', $url, PDO::PARAM_STR);
		$result->bindParam(':window_title', $window_title, PDO::PARAM_STR);
		$result->bindParam(':screenshot', $screenshot, PDO::PARAM_STR);
		$result->bindParam(':id_user', $id_user, PDO::PARAM_STR);
		$result->bindParam(':id_computer', $id_computer, PDO::PARAM_STR);
		$result->execute();

		if ($screenshot == "") {
		} else {
			file_put_contents(ROOT . '/upload/' . $db->lastInsertId() . '.jpg', base64_decode($screenshot));
		}

		return $db->lastInsertId();
	}

	public static function getMachine($data)
	{
		$comp = $data['comp'];
		$sid = $data['sid'];

		$db = Db::getConnection();

		$sql = "SELECT id_computer
				FROM computers
				WHERE name_computer = :comp AND sid = :sid";

		$result = $db->prepare($sql);
		$result->bindParam(':comp', $comp, PDO::PARAM_STR);
		$result->bindParam(':sid', $sid, PDO::PARAM_STR);
		$result->execute();

		$user = $result->fetch();
		if ($user) {
			return $user['id_computer'];
		}
		return "Компьютер не найден";
	}

	public static function getUser($data)
	{
		$user = $data['user'];

		$db = Db::getConnection();

		$sql = "SELECT id_user
				FROM users
				WHERE login = :user";

		$result = $db->prepare($sql);
		$result->bindParam(':user', $user, PDO::PARAM_STR);
		$result->execute();

		$user = $result->fetch();
		if ($user) {
			return $user['id_user'];
		}
		return "Пользователь не найден";
	}

	public static function getScreenPath($id)
	{
		$path = '/upload/';
		$screen = $path . $id . '.jpg';
		return $screen;
	}

	public static function getProccesByDate($date1, $date2)
	{
		$db = Db::getConnection();

		$procces = array();

		$result = $db->query("SELECT id, date_time, name_process, window_title
								FROM processandscreen
								WHERE type='process' AND date_time >= '" . $date1 . "' AND date_time <= '" . $date2 . "'
								ORDER BY id DESC");

		$i = 0;
		while ($row = $result->fetch()) {
			$procces[$i]['id'] = $row['id'];
			$procces[$i]['date_time'] = $row['date_time'];
			$procces[$i]['name_process'] = $row['name_process'];
			$procces[$i]['window_title'] = $row['window_title'];
			$i++;
		}
		return $procces;
	}

	public static function getUrlsByDate($date1, $date2)
	{
		$db = Db::getConnection();

		$url = array();

		$result = $db->query("SELECT id, date_time, url, window_title
								FROM processandscreen
								WHERE type='url' AND date_time >= '" . $date1 . "' AND date_time <= '" . $date2 . "'
								ORDER BY id DESC");

		$i = 0;
		while ($row = $result->fetch()) {
			$url[$i]['id'] = $row['id'];
			$url[$i]['date_time'] = $row['date_time'];
			$url[$i]['url'] = $row['url'];
			$url[$i]['window_title'] = $row['window_title'];
			$i++;
		}
		return $url;
	}

	public static function getScreensByDate($date1, $date2)
	{
		$db = Db::getConnection();

		$screens = array();

		$result = $db->query("SELECT id, date_time
								FROM processandscreen
								WHERE type='screenshot' AND date_time >= '" . $date1 . "' AND date_time <= '" . $date2 . "'
								ORDER BY id DESC");

		$i = 0;
		while ($row = $result->fetch()) {
			$screens[$i]['id'] = $row['id'];
			$screens[$i]['date_time'] = $row['date_time'];
			$i++;
		}
		return $screens;
	}

	public static function getProccesByUserAndDate($id, $date1, $date2)
	{
		$db = Db::getConnection();

		$procces = array();

		$result = $db->query("SELECT id, date_time, name_process, window_title
								FROM processandscreen
								WHERE type='process' AND id_user=" . $id . " AND date_time >= '" . $date1 . "' AND date_time <= '" . $date2 . "'
								ORDER BY id DESC");

		$i = 0;
		while ($row = $result->fetch()) {
			$procces[$i]['id'] = $row['id'];
			$procces[$i]['date_time'] = $row['date_time'];
			$procces[$i]['name_process'] = $row['name_process'];
			$procces[$i]['window_title'] = $row['window_title'];
			$i++;
		}
		return $procces;
	}

	public static function getUrlsByUserAndDate($id, $date1, $date2)
	{
		$db = Db::getConnection();

		$url = array();

		$result = $db->query("SELECT id, date_time, url, window_title
								FROM processandscreen
								WHERE type='url' AND id_user=" . $id . " AND date_time >= '" . $date1 . "' AND date_time <= '" . $date2 . "'
								ORDER BY id DESC");

		$i = 0;
		while ($row = $result->fetch()) {
			$url[$i]['id'] = $row['id'];
			$url[$i]['date_time'] = $row['date_time'];
			$url[$i]['url'] = $row['url'];
			$url[$i]['window_title'] = $row['window_title'];
			$i++;
		}
		return $url;
	}

	public static function getScreensByUserAndDate($id, $date1, $date2)
	{
		$db = Db::getConnection();

		$screens = array();

		$result = $db->query("SELECT id, date_time
								FROM processandscreen
								WHERE type='screenshot' AND id_user=" . $id . " AND date_time >= '" . $date1 . "' AND date_time <= '" . $date2 . "'
								ORDER BY id DESC");

		$i = 0;
		while ($row = $result->fetch()) {
			$screens[$i]['id'] = $row['id'];
			$screens[$i]['date_time'] = $row['date_time'];
			$i++;
		}
		return $screens;
	}
}
