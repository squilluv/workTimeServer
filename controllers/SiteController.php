<?php

class SiteController
{
    public function actionIndex()
    {
        if (User::isGuest()) {
            header("Location: /login");
        } else {
            $procces = array();
            $procces = Main::getProcces();

            $url = array();
            $url = Main::getUrls();

            $comps = array();
            $comps = Main::getComps();

            $users = array();
            $users = Main::getComps();

            $screens = array();
            $screens = Main::getScreens();
        }

        if (isset($_COOKIE['date1']) && isset($_COOKIE['date2'])) {
            $date1 = $_COOKIE['date1'];
            $date2 = $_COOKIE['date2'];
            $procces = array();
            $procces = Main::getProccesByDate($date1, $date2);

            $url = array();
            $url = Main::getUrlsByDate($date1, $date2);

            $screens = array();
            $screens = Main::getScreensByDate($date1, $date2);
        }

        if (isset($_POST['filter'])) {
            $date1 = $_POST['date1'];
            $date2 = $_POST['date2'];

            $procces = array();
            $procces = Main::getProccesByDate($date1, $date2);

            $url = array();
            $url = Main::getUrlsByDate($date1, $date2);

            $screens = array();
            $screens = Main::getScreensByDate($date1, $date2);
        }

        if (isset($_POST['addMachine'])) {
            $comp = $_POST['comp'];
            $owner = $_POST['owner'];

            $machine = Main::addComp($comp, $owner);

            $comps = array();
            $comps = Main::getComps();
        }

        require_once(ROOT . '/views/site/index.php');
    }

    public function actionUser($userId)
    {
        if (User::isGuest()) {
            header("Location: /login");
        } else {
            $procces = array();
            $procces = Main::getProccesByUser($userId);

            $url = array();
            $url = Main::getUrlsByUser($userId);

            $comps = array();
            $comps = Main::getComps();

            $users = array();
            $users = Main::getComps();

            $screens = array();
            $screens = Main::getScreensByUser($userId);

            if (isset($_COOKIE['date1']) && isset($_COOKIE['date2'])) {
                $date1 = $_COOKIE['date1'];
                $date2 = $_COOKIE['date2'];

                $procces = array();
                $procces = Main::getProccesByUserAndDate($userId, $date1, $date2);

                $url = array();
                $url = Main::getUrlsByUserAndDate($userId, $date1, $date2);

                $screens = array();
                $screens = Main::getScreensByUserAndDate($userId, $date1, $date2);
            }

            if (isset($_POST['filter'])) {
                $date1 = $_POST['date1'];
                $date2 = $_POST['date2'];
                setcookie('date1', $date1);
                setcookie('date2', $date2);

                $procces = array();
                $procces = Main::getProccesByUserAndDate($userId, $date1, $date2);

                $url = array();
                $url = Main::getUrlsByUserAndDate($userId, $date1, $date2);

                $screens = array();
                $screens = Main::getScreensByUserAndDate($userId, $date1, $date2);
            }

            if (isset($_POST['addMachine'])) {
                $comp = $_POST['comp'];
                $owner = $_POST['owner'];

                $machine = Main::addComp($comp, $owner);

                $comps = array();
                $comps = Main::getComps();
            }

            require_once(ROOT . '/views/site/index.php');
        }
        return true;
    }

    public function actionLogin()
    {
        $login = '';
        $password = '';

        if (isset($_POST['submit'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];

            $userId = User::checkUserData($login, $password);

            if ($userId == false) {
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {
                User::auth($userId);

                header("Location: /");
            }
        }

        require_once(ROOT . '/views/user/login.php');

        return true;
    }

    public function actionLogout()
    {
        ob_start();
        unset($_SESSION["user"]);
        header("Location: /login");

        return true;
    }

    public function actionApiComps()
    {
        header("Content-type: application/json");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === "POST") {
            $response = Main::getMachine($_POST);
            echo $response;
        }
        return true;
    }

    public function actionApiPostProccess()
    {
        header("Content-type: application/json");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === "POST") {
            if (Main::checkToken($_POST)) {
                $id = Main::postProccess($_POST);
                echo $id;
            }
        }
        return true;
    }

    public function actionAjaxComps()
    {
        $df = Main::getCompsAjax();
        echo $df;
        return $df;
    }
}
