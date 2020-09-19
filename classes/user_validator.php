<?php

require_once(__DIR__ . '/../includes/configs.php');

class UserValidator
{
    private $_messages = array();

    public function get_messages() {
        return $this->_messages;
    }

    public function is_password_match($password, $password_confirmation)
    {
        if ($password != $password_confirmation) {
            $this->_messages[] = "Passwords do not match.";
            return false;
        }
        return true;
    }

    public function is_username_exist($username)
    {
        $DB = Database::get_instance();
        $query = "SELECT * FROM user WHERE username = ?";
        $result = $DB->execute($query, [$username]);
        if ($result) {
            $this->_messages[] = "Username is already in use.";
            return true;
        }
        return false;
    }

    public function is_email_exist($email)
    {
        $DB = Database::get_instance();
        $query = "SELECT * FROM user WHERE email = ?";
        $result = $DB->execute($query, [$email]);
        var_dump($result);
        if ($result) {
            $this->_messages[] = "Email is already in use.";
            return true;
        }
        return false;
    }
}
