<?php

require_once(__DIR__ . '/../includes/configs.php');

if (isset($_POST['delete'])) {
    $post_id = $_POST['post_id'];
    $FORUM->delete_post($post_id);
}

?>

<!DOCTYPE html>
<html lang="zh-TW">
    <head>
        <script src="https://kit.fontawesome.com/9a93ec8ea5.js" crossorigin="anonymous"></script>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="assets/stylesheets/style.css">
        <title>管理我的文章</title>
    </head>

    <body>
        <div id="bgset4">
            <form action="search.php" method="GET">
                <div class="search_div">
                    <input name="keyword" class="search" type="search" placeholder="搜尋文章"></input>
                    <input class="search_button" type="submit" value="搜尋">
                </div>
            </form>

            <div><h1>&nbsp;<a href="home.php">管理我的文章</a></h1></div>

<?php

$current_user = $SESSION->get('current_user');
$posts = (new PostManager())->get_author_posts($current_user);

if (!$posts) {
    require_once(__DIR__ . '/no_post.php');
}

foreach ($posts as $post) {
    echo '
        <div>
            <br>
            <div class="theme" type="text2" value="文章">
                <span id="title"><a href="post.php?id='. $post->id .'">' . $post->title . '</a></span>
                <span style="float:right; padding-top: 20px; padding-right: 50px;">留言數：' . $post->reply_count . '</span><br>
                <span id="created_at">發布：' . $post->create_time . '</span><br>
                <span id="updated_at">更新：' . $post->last_edit . '</span><br>
                <form action="" method="POST">
                    <input type="hidden" name="post_id" value="' . $post->id . '">
                    <input class="log_button button_mes to_edit"" type="button" value="編輯文章" onclick="location.href=\'edit_post.php?id=' . $post->id . '\';">
                    <input name="delete" class="log_button button_mes to_edit"" type="submit" value="刪除文章" onclick="if (!confirm(\'Are you sure to delete this post?\')) { return false; }">
                </form>
            </div>
        </div>
';
}

?>

        <?php require_once(__ROOT__ . '/layout/menu.php'); ?>
    </body>
</html>
