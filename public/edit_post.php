<?php

require_once(__DIR__ . '/../includes/configs.php');

$post_id = $_GET['id'] ?? 0;
$result = $FORUM->get_post($post_id);
$post = $result[0] == SUCCESS ? $result[1] : null;
if ($post) {
    $author = $FORUM->get_user($post->author_id)[1];
    $is_author_login = !Comparer::compare($author, $SESSION->get('current_user'));
}

?>

<!DOCTYPE html>
<html lang="zh-TW">
    <head>
        <script src="https://kit.fontawesome.com/9a93ec8ea5.js" crossorigin="anonymous"></script>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="assets/stylesheets/style.css">
        <title>編輯文章</title>
    </head>

    <body>
        <?php
        if (!$post) {
            require_once(__ROOT__ . '/layout/post_not_found.php');
        } elseif (!$is_author_login) {
            require_once(__ROOT__ . '/layout/edit_post_no_authorization.php');
        } else {
            require_once(__ROOT__ . '/layout/edit_post.php');
        }
        ?>
    </body>
</html>
