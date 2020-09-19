<?php

require_once(__DIR__ . '/../includes/configs.php');

class Session
{
    private static $_instance;

    private const LOGIN_FAILURE = 0;
    private const LOGIN_SUCCESS = 1;

    private function __construct()
    {
        $this->create();
    }

    public static function get_instance()
    {
        if (!self::$_instance) {
            self::$_instance = new Session();
        }
        return self::$_instance;
    }

    public function create()
    {
        session_start();
	}

    public function clear()
    {
        session_unset();
        session_destroy();
		$this->create();
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    public function login($username, $password)
    {
        if (Session::is_login()) {
            die("Logged in already.");
        }
        $user_manager = new UserManager();
        $user = $user_manager->get_user_info($username);
        if ($user && password_verify($password, $user->password)) {
            $user->last_login = DatabaseHelper::get_current_time();
            $user_manager->update($user);
            $this->set('current_user', $user);
            return SUCCESS;
        }
        return FAILURE;
    }

    public function logout()
    {
        $this->clear();
    }

    public static function is_login()
    {
        return isset($_SESSION['current_user']) && !!$_SESSION['current_user'];
    }

    public static function REQUIRE_LOGIN()
    {
        $login_path = 'login.php';
        if (!Session::is_login()) {
            Utility::redirect_to($login_path);
        }
    }

    public static function REDIRECT_IF_LOGIN($url)
    {
        if (Session::is_login()) {
            Utility::redirect_to($url);
        }
    }
}
