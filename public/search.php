<?php

require_once(__DIR__ . '/../includes/configs.php');

Session::REQUIRE_LOGIN();

if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $posts = $FORUM->search_post($keyword);
} else {
    $posts = array();
}

?>

<!DOCTYPE html>
<html lang="zh-TW">
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/9a93ec8ea5.js" crossorigin="anonymous"></script>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="assets/stylesheets/style.css">
        <title>海大留言板</title>
    </head>

    <body>
        <div style="line-height:10%;"><br></div>
        <div id="bgset4">
            <form action="search.php" method="GET">
                <div class="search_div">
                    <input name="keyword" id="search" class="search" type="search" placeholder="搜尋文章"></input>
                    <input class="search_button" type="submit" value="搜尋">
                </div>
            </form>
            <h1>&nbsp;<a href="home.php">搜尋文章<?php if (isset($keyword)) { echo '(關鍵字:'. $keyword . ')'; } ?></a></h1>
            <div class="hr_line"></div>
<?php

if (!$posts) {
    require_once(__ROOT__ . '/layout/no_post.php');
}

foreach ($posts as $post) {
    $author = $FORUM->get_user($post->author_id)[1];
    $is_author_login = !Comparer::compare($author, $SESSION->get('current_user'));
    echo '
            <div>
                <br>
                <div class="theme" type="text2" value="文章">
                    <span id="title"><a href="post.php?id='. $post->id .'">' . $post->title . '</a></span>
                    <span id="nickname" class="nickname">&nbsp;作者：' . $author->nickname . ' (' . $author->username . ')' . '</span><br>
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
        </div>
        <?php if (Session::is_login()) { require_once(__ROOT__ . '/layout/menu.php'); } ?>
    </body>
</html>
