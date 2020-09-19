<?php

class User
{
    public $id;
    public $username;
    public $password;
    public $email;
    public $nickname;
    public $post_count;
    public $join_date;
    public $last_login;

    public function __construct($user_info = array())
    {
        if ($user_info) {
            $this->id = $user_info['id'] ?? null;
            $this->username = $user_info['username'];
            $this->password = $user_info['password'];
            $this->email = $user_info['email'];
            $this->nickname = $user_info['nickname'] ?? $user_info['username'];
            $this->post_count = $user_info['post_count'] ?? 0;
            $this->join_date = $user_info['join_date'] ?? null;
            $this->last_login = $user_info['last_login'] ?? null;
        }
    }
}
