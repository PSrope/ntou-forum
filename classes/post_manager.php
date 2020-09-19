<?php

require_once(__DIR__ . '/../includes/configs.php');

class PostManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_post_info($post_id)
    {
        $query = "SELECT * from post WHERE id = :id LIMIT 0, 1";
        $result = $this->DB->execute($query, ['id' => $post_id]);
        if (!$result) {
            return null;
        }
        return new Post($result[0]);
    }

    public function get_all_posts()
    {
        $posts = array();
        $query = "SELECT * FROM post ORDER BY last_edit DESC";
        $result = $this->DB->execute($query);
        foreach ($result as $row) {
            $posts[] = new Post($row);
        }
        return $posts;
    }

    public function get_author_posts($author)
    {
        $posts = array();
        $query = "SELECT * FROM post WHERE author_id = :author_id";
        $result = $this->DB->execute($query, ['author_id' => $author->id]);
        foreach ($result as $row) {
            $posts[] = new Post($row);
        }
        return $posts;
    }

    public function get_user_post_count($user)
    {
        // COUNT() - aggregation function
        $query = "SELECT COUNT(*) FROM post WHERE author_id = :author_id";
        $result = $this->DB->execute($query, ['author_id' => $user->id]);
        return $result[0]['COUNT(*)'];
    }

    public function get_post_reply_count($post)
    {
        // COUNT() - aggregation function
        $query = "SELECT COUNT(*) FROM reply WHERE post_id = :post_id";
        $result = $this->DB->execute($query, ['post_id' => $post->id]);
        return $result[0]['COUNT(*)'];
    }

    public function search($keyword)
    {
        $posts = array();
        $pattern = '%' . $keyword . '%';
        $query = "SELECT post.*
                  FROM post
                  INNER JOIN user ON post.author_id = user.id
                  WHERE post.title LIKE ? OR
                        post.content LIKE ? OR
                        user.username LIKE ?";
        $result = $this->DB->execute($query, [$pattern, $pattern, $pattern]);
        foreach ($result as $row) {
            $posts[] = new Post($row);
        }
        return $posts;
    }

    public function create($post)
    {
        $query = "INSERT INTO post(author_id, title, content)
                  VALUES(:author_id, :title, :content)";
        $this->DB->execute($query,
                           ['author_id' => $post->author_id,
                            'title' => $post->title,
                            'content' => $post->content]);
        return [SUCCESS];
    }

    public function delete($post)
    {
        $this->DB->execute("SET FOREIGN_KEY_CHECKS = 0");
        $query = "DELETE reply, post
                  FROM post
                  LEFT JOIN reply ON (post.id = reply.post_id)
                  WHERE post.id = :id";
        $this->DB->execute($query, ['id' => $post->id]);
        $this->DB->execute("SET FOREIGN_KEY_CHECKS = 1");
        return [SUCCESS];
    }

    public function update($post)
    {
        $post_db = $this->get_post_info($post->id);
        $data_to_update = Comparer::compare($post, $post_db);
        if (!$data_to_update) {
            return [FAILURE, "Nothing to update."];
        }
        foreach ($data_to_update as $data) {
            $key = $data['key'];
            $value = $data['value'];
            $query = "UPDATE post SET $key = :value WHERE id = :id";
            $this->DB->execute($query, [
                'value' => $value,
                'id' => $post->id
            ]);
        }
        return [SUCCESS];
    }
}
