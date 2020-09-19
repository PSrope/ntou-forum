<?php

class Post
{
    public $id;
    public $author_id;
    public $title;
    public $content;
    public $reply_count;
    public $create_time;
    public $last_edit;

    public function __construct($post_info = array())
    {
        if ($post_info) {
            $this->id = $post_info['id'] ?? null;
            $this->author_id = $post_info['author_id'];
            $this->title = $post_info['title'];
            $this->content = $post_info['content'];
            $this->reply_count = $post_info['reply_count'] ?? 0;
            $this->create_time = $post_info['create_time'] ?? null;
            $this->last_edit = $post_info['last_edit'] ?? null;
        }
    }
}
