<?php

require_once(__DIR__ . '/../includes/configs.php');

Session::REQUIRE_LOGIN();

if (isset($post) && $post) {
    $author = $FORUM->get_user($post->author_id)[1];
    $is_author_login = !Comparer::compare($author, $SESSION->get('current_user'));
} else {
    die('Something went wrong.');
}

if (isset($_POST['submit'])) {
    $content = $_POST['content'];
    $result = $FORUM->create_reply($post, $content);
    Utility::redirect_to('post.php?id=' . $post->id);
}

if (isset($_POST['delete'])) {
    if (isset($_POST['post_id'])) {
        $post_id = $_POST['post_id'];
        $FORUM->delete_post($post_id);
        Utility::redirect_to('home.php');
    } elseif (isset($_POST['reply_id'])) {
        $reply_id = $_POST['reply_id'];
        $FORUM->delete_reply($reply_id);
        Utility::redirect_to('post.php?id=' . $post->id);
    }
}

?>

<!DOCTYPE html>
<div>
    <h1>&nbsp;<a href="home.php">海大留言板</a></h1>
    <div class="hr_line"></div>
    <br>
    <div class="theme_message">
        <?php
            if ($is_author_login) {
                echo '<form action="" class="edit-btn" method="POST">' .
                     '    <input name="post_id" type="hidden" value="' . $post->id . '">' .
                     '    <input name="delete" class="log_button button_mes" type="submit" value="刪除文章" onclick="if (!confirm(\'Are you sure to delete this post?\')) { return false; }">' .
                     '    <input class="log_button button_mes" type="button" value="編輯文章" onclick="location.href=\'edit_post.php?id='. $post->id .'\'">' .
                     '</form><br>';
            }
        ?>
        <span id="title">&ensp;<?php echo $post->title; ?></span><br>
        <span id="nickname" class="nickname_mes">&ensp;&ensp;&ensp;作者：<?php echo $author->nickname . ' (' . $author->username . ')'; ?></span>
        <br>
        <div class="hr_line2"></div>
        <pre class="content">
<?php echo $post->content; ?>
        </pre>
        <span id="updated_at" class="timeset_mes">更新：<?php echo $post->last_edit; ?></span><br>
        <span id="created_at" class="timeset_mes">發布：<?php echo $post->create_time; ?></span><br>
    </div>

    <div class="hr_line2"></div>
<?php

$replies = (new ReplyManager())->get_all_replies($post->id);

foreach ($replies as $reply) {
    $author = $FORUM->get_user($reply->user_id)[1];
    $is_author_login = !Comparer::compare($author, $SESSION->get('current_user'));
    echo '
<div class = "comment">
';
    if ($is_author_login) {
        echo '
    <form action="" method="POST">
        <input type="hidden" name="reply_id" value="' . $reply->id . '">
        <input name="delete" class="log_button button_mes to_edit"" type="submit" value="刪除留言" onclick="if (!confirm(\'Are you sure to delete this reply?\')) { return false; }">
    </form>
';
    }
    echo '
    <span id="nickname" class="nickname_mes">' . $author->nickname . ' (' . $author->username . ')' . '</span><br>
    <span id="message">' . $reply->content . '</span><br>
    <span id="created_at" class="timeset_mes">發布：' . $reply->create_time . '</span><br>
</div>
';
}

?>
    <hr>
    <form action="" method="POST">
        <div id="reply">
            <div id="leave_message">
                <textarea rows="5" name="content" placeholder="想說些什麼嗎"></textarea>
            </div>
            <input id="postComment" name="submit" class="log_button button_mes" type="submit" value="留言">
        </div>
    </form>

</div>
