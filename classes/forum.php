<?php

require_once(__DIR__ . '/../includes/configs.php');

class Forum
{
    private static $_instance;
    private $_current_user;

    private $_user_manager;
    private $_post_manager;
    private $_reply_manager;

    private function __construct()
    {
        global $SESSION;
        $this->_current_user = $SESSION->get('current_user') ?? null;
        $this->_user_manager = new UserManager();
        $this->_post_manager = new PostManager();
        $this->_reply_manager = new ReplyManager();
    }

    public function signup($username, $password, $password_confirmation, $email)
    {
        if ($password != $password_confirmation) {
            return [FAILURE, "Password do not match."];
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $new_user = new User([
            'username' => $username,
            'password' => $hashed_password,
            'email' => $email
        ]);
        return $this->_user_manager->create($new_user);
    }

    public function change_password($old_password,
                                    $password,
                                    $password_confirmation)
    {
        if (!password_verify($old_password, $this->_current_user->password)) {
            return [FAILURE, "Your password was incorrect."];
        }
        if ($password != $password_confirmation) {
            return [FAILURE, "Passwords do not match."];
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $this->update_user_info(['password' => $hashed_password]);
        return [SUCCESS];
    }

    public function update_user_info($data)
    {
        foreach ($data as $key => $value) {
            $this->_current_user->$key = $value;
        }
        $this->_user_manager->update($this->_current_user);
    }

    public function get_user($user_id)
    {
        $result = $this->_user_manager->get_user_info($user_id);
        if (!$result) {
            return [FAILURE, "User not found."];
        }
        return [SUCCESS, $result];
    }

    public function get_post($post_id)
    {
        $result = $this->_post_manager->get_post_info($post_id);
        if (!$result) {
            return [FAILURE, "Post not found."];
        }
        return [SUCCESS, $result];
    }

    public function get_reply($reply_id)
    {
        $result = $this->_reply_manager->get_reply_info($reply_id);
        if (!$result) {
            return [FAILURE, "Reply not found."];
        }
        return [SUCCESS, $result];
    }

    public function create_post($title, $content)
    {
        $uid = $this->_current_user->id;
        $new_post = new Post([
            'author_id' => $uid,
            'title' => $title,
            'content' => $content]
        );
        $result = $this->_post_manager->create($new_post);
        if ($result[0] == SUCCESS) {
            ++$this->_current_user->post_count;
            $this->_user_manager->update($this->_current_user);
        }
        return $result;
    }

    public function create_reply($post, $content)
    {
        if (empty($content)) {
            return [FAILURE, "Reply content is empty."];
        }
        $uid = $this->_current_user->id;
        $new_reply = new Reply([
            'user_id' => $uid,
            'post_id' => $post->id,
            'content' => $content]
        );
        $result = $this->_reply_manager->create($new_reply);
        if ($result[0] == SUCCESS) {
            ++$post->reply_count;
            $this->_post_manager->update($post);
        }
        return $result;
    }

    public function edit_post($post, $data)
    {
        foreach ($data as $key => $value) {
            $post->$key = $value;
        }
        $post->last_edit = DatabaseHelper::get_current_time();
        $this->_post_manager->update($post);
    }

    public function edit_reply($reply, $data)
    {
        foreach ($data as $key => $value) {
            $reply->$key = $value;
        }
        $this->_reply_manager->update($reply);
    }

    public function delete_post($post_id)
    {
        $result = $this->get_post($post_id);
        if ($result[0] == SUCCESS) {
            --$this->_current_user->post_count;
            $this->_user_manager->update($this->_current_user);
            return $this->_post_manager->delete($result[1]);
        }
        return $result;
    }

    public function delete_reply($reply_id)
    {
        $result = $this->get_reply($reply_id);
        if ($result[0] == SUCCESS) {
            $post = $this->get_post($result[1]->post_id)[1];
            --$post->reply_count;
            $this->_post_manager->update($post);
            return $this->_reply_manager->delete($result[1]);
        }
        return $result;
    }

    public function search_post($keyword)
    {
        $result = $this->_post_manager->search($keyword);
        return $result;
    }

    public static function get_instance()
    {
        if (!self::$_instance) {
            self::$_instance = new Forum();
        }
        return self::$_instance;
    }
}
