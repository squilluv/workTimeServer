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

	public static function getCompsAjax()
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
		$res = "";
		foreach ($comps as $comp) {
			$result1 = $db->query("SELECT id, date_time
									FROM processandscreen 
									WHERE id_computer = " . $comp['id_computer'] . "
									ORDER BY id DESC LIMIT 1");
			$pas = array();
			$i = 0;
			while ($roww = $result1->fetch()) {
				$pas[$i]['date_time'] = $roww['date_time'];
				$i++;
			}
			foreach ($pas as $p) {
				$resultd = $db->query("SELECT NOW()");
				$datenow = $resultd->fetch();
				$date = (strtotime($datenow['NOW()']) - strtotime($p['date_time'])) / 60;
				$res = $res . '<a class="list-group-item list-group-item-action waves-effect">' . $comp['owner'];
				if ($date < 5) {
					$res = $res . ' <button class="cg"></button>';
				} else {
					$res = $res . ' <button class="cw"></button>';
				}
				$res = $res .  '</a>';
			}
		}
		return $res;
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
								WHERE type='process' AND id_computer=" . $id . "
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
								WHERE type='url' AND id_computer=" . $id . "
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
								WHERE type='screenshot' AND id_computer=" . $id . "
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
		$id_computer = $data['id_computer'];

		$db = Db::getConnection();

		$sql = "INSERT INTO processandscreen
        (date_time, type, name_process, url, window_title, id_computer) 
        VALUES 
        (NOW(), :type, :name_process, :url, :window_title, :id_computer)";

		$result = $db->prepare($sql);
		$result->bindParam(':type', $type, PDO::PARAM_STR);
		$result->bindParam(':name_process', $name_process, PDO::PARAM_STR);
		$result->bindParam(':url', $url, PDO::PARAM_STR);
		$result->bindParam(':window_title', $window_title, PDO::PARAM_STR);
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

		$db = Db::getConnection();

		$sql = "SELECT id_computer
				FROM computers
				WHERE name_computer = :comp";

		$result = $db->prepare($sql);
		$result->bindParam(':comp', $comp, PDO::PARAM_STR);
		$result->execute();

		$user = $result->fetch();
		if ($user) {
			$token = Main::getToken();
			$userId = $user['id_computer'];
			Main::updateToken($userId, $token);
			return $token . "-" . $userId;
		}
		return "Компьютер не найден";
	}

	public static function checkToken($data)
	{
		$token = $data['token'];

		$db = Db::getConnection();

		$sql = "SELECT id_computer
				FROM computers
				WHERE token = :token";

		$result = $db->prepare($sql);
		$result->bindParam(':token', $token, PDO::PARAM_STR);
		$result->execute();

		$user = $result->fetch();
		if ($user) {
			return true;
		}
		return false;
	}

	public static function updateToken($id, $token)
	{

		$db = Db::getConnection();

		$sql = "UPDATE computers SET token = :token WHERE id_computer = :id";

		$result = $db->prepare($sql);
		$result->bindParam(':id', $id, PDO::PARAM_STR);
		$result->bindParam(':token', $token, PDO::PARAM_STR);
		$result->execute();

		return $db->lastInsertId();
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
								WHERE type='process' AND id_computer=" . $id . " AND date_time >= '" . $date1 . "' AND date_time <= '" . $date2 . "'
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
								WHERE type='url' AND id_computer=" . $id . " AND date_time >= '" . $date1 . "' AND date_time <= '" . $date2 . "'
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
								WHERE type='screenshot' AND id_computer=" . $id . " AND date_time >= '" . $date1 . "' AND date_time <= '" . $date2 . "'
								ORDER BY id DESC");

		$i = 0;
		while ($row = $result->fetch()) {
			$screens[$i]['id'] = $row['id'];
			$screens[$i]['date_time'] = $row['date_time'];
			$i++;
		}
		return $screens;
	}

	public static function addComp($comp, $owner)
	{

		$db = Db::getConnection();

		$sql = "INSERT INTO computers
        (name_computer, owner) 
        VALUES 
        (:comp, :owner)";

		$result = $db->prepare($sql);
		$result->bindParam(':comp', $comp, PDO::PARAM_STR);
		$result->bindParam(':owner', $owner, PDO::PARAM_STR);
		$result->execute();

		return $db->lastInsertId();
	}

	public static function getToken($count = 254)
	{
		$result = '';
		$array = array_merge(range('a', 'z'), range('0', '9'));
		for ($i = 0; $i < $count; $i++) {
			$result .= $array[mt_rand(0, 35)];
		}
		return $result;
	}
}
