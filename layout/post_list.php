<?php

require_once(__DIR__ . '/../includes/configs.php');

Session::REQUIRE_LOGIN();

if (isset($_POST['delete'])) {
    $post_id = $_POST['post_id'];
    $FORUM->delete_post($post_id);
}

?>

<!DOCTYPE html>

<?php

$posts = (new PostManager())->get_all_posts();

if (!$posts) {
    require_once(__DIR__ . '/no_post.php');
}

foreach ($posts as $post) {
    $author = $FORUM->get_user($post->author_id)[1];
    $is_author_login = !Comparer::compare($author, $SESSION->get('current_user'));
    echo '
<div>
    <br>
    <div class="theme" type="text2" value="文章">
        <span id="title"><a href="post.php?id='. $post->id .'">' . $post->title . '</a></span>
        <span id="nickname" class="nickname">&nbsp;作者：' . $author->nickname . ' (' . $author->username . ')' . '</span>
        <span style="float:right; padding-top: 20px; padding-right: 50px;">留言數：' . $post->reply_count . '</span><br>
        <span id="created_at">發布：' . $post->create_time . '</span><br>
        <span id="updated_at">更新：' . $post->last_edit . '</span><br>';
    if ($is_author_login) {
        echo '
        <form action="" method="POST">
            <input type="hidden" name="post_id" value="' . $post->id . '">
            <input class="log_button button_mes to_edit"" type="button" value="編輯文章" onclick="location.href=\'edit_post.php?id=' . $post->id . '\';">
            <input name="delete" class="log_button button_mes to_edit"" type="submit" value="刪除文章" onclick="if (!confirm(\'Are you sure to delete this post?\')) { return false; }">
        </form>
';
    }
    echo '
    </div>
</div>
';
}

?>

<div class="page_button" style="display: none;">
    <br>
    <input id="next_page" class="next_page" type="button" value="下一頁">
    <input id="last_page" class="last_page" type="button" value="上一頁">
</div>
