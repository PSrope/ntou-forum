<?php

class Reply
{
    public $id;
    public $user_id;
    public $post_id;
    public $content;
    public $create_time;
    public $last_edit;

    public function __construct($reply_info)
    {
        if ($reply_info) {
            $this->id = $reply_info['id'] ?? null;
            $this->user_id = $reply_info['user_id'];
            $this->post_id = $reply_info['post_id'];
            $this->content = $reply_info['content'];
            $this->create_time = $reply_info['create_time'] ?? null;
            $this->last_edit = $reply_info['last_edit'] ?? null;
        }
    }
}
