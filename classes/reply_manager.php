<?php

require_once(__DIR__ . '/../includes/configs.php');

class ReplyManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_reply_info($reply_id)
    {
        $query = "SELECT * from reply WHERE id = :id";
        $result = $this->DB->execute($query, ['id' => $reply_id]);
        if (!$result) {
            return null;
        }
        return new Reply($result[0]);
    }

    public function get_all_replies($post_id)
    {
        $replies = array();
        $query = "SELECT * FROM reply WHERE post_id = :post_id ORDER BY create_time";
        $result = $this->DB->execute($query, ['post_id' => $post_id]);
        foreach ($result as $row) {
            $replies[] = new Reply($row);
        }
        return $replies;
    }

    public function create($reply)
    {
        $query = "INSERT INTO reply(user_id, post_id, content)
                  VALUES(:user_id, :post_id, :content)";
        $result = $this->DB->execute($query,
                                     ['user_id' => $reply->user_id,
                                      'post_id' => $reply->post_id,
                                      'content' => $reply->content]);
        return [SUCCESS];
    }

    public function delete($reply)
    {
        $query = "DELETE FROM reply WHERE id = :id";
        $this->DB->execute($query, ['id' => $reply->id]);
        return [SUCCESS];
    }

    public function update($reply)
    {
        return [SUCCESS];
    }
}
