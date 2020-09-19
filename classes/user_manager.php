<?php

require_once(__DIR__ . '/../includes/configs.php');

class UserManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function is_username_in_use($username)
    {
        $query = "SELECT * FROM user WHERE username = :username";
        $result = $this->DB->execute($query, ['username' => $username]);
        return !!$result;
    }

    public function is_email_in_use($email)
    {
        $query = "SELECT * FROM user WHERE email = :email";
        $result = $this->DB->execute($query, ['email' => $email]);
        return !!$result;
    }

    public function is_user_exist($user)
    {
        return $this->is_username_in_use($user->username) ||
               $this->is_email_in_use($user->email);
    }

    public function get_user_info($id_or_username) {
        $query = "SELECT * FROM user WHERE id = :id OR username = :username";
        $result = $this->DB->execute($query, ['id' => $id_or_username,
                                              'username' => $id_or_username]);
        if (!$result) {
            return null;
        }
        return new User($result[0]);
    }

    public function get_all_users()
    {
        $users = array();
        $query = "SELECT * FROM user";
        $result = $this->DB->execute($query);
        foreach ($result as $row) {
            $users[] = new User($row);
        }
        return $users;
    }

    public function create($user)
    {
        if ($this->is_user_exist($user)) {
            return [FAILURE, "Username/email is already in use."];
        }
        $query = "INSERT INTO user(username, password, email, nickname)
                  VALUES(:username, :password, :email, :nickname)";
        $this->DB->execute($query, [
            'username' => $user->username,
            'password' => $user->password,
            'email' => $user->email,
            'nickname' => $user->nickname
        ]);
        return [SUCCESS];
    }

    public function delete($user)
    {
        return [FAILURE, "Invalid operation."];
    }

    public function update($user)
    {
        $user_db = $this->get_user_info($user->id);
        $data_to_update = Comparer::compare($user, $user_db);
        if (!$data_to_update) {
            return [FAILURE, "Nothing to update."];
        }
        foreach ($data_to_update as $data) {
            $key = $data['key'];
            $value = $data['value'];
            $query = "UPDATE user SET $key = :value WHERE id = :id";
            $this->DB->execute($query, [
                'value' => $value,
                'id' => $user->id
            ]);
        }
        return [SUCCESS];
    }
}
