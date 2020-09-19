<?php

require_once(__DIR__ . '/../includes/configs.php');

Session::REQUIRE_LOGIN();

$post_id = $_GET['id'] ?? 0;
$result = $FORUM->get_post($post_id);
$post = $result[0] == SUCCESS ? $result[1] : null;

?>

<!DOCTYPE html>
<html lang="zh-TW">
    <head>
        <script src="https://kit.fontawesome.com/9a93ec8ea5.js" crossorigin="anonymous"></script>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="assets/stylesheets/style.css">
        <title><?php echo $post ? $post->title : "Post not found"; ?></title>
    </head>

    <body>
        <?php if (Session::is_login()) { require_once(__ROOT__ . '/layout/menu.php'); } ?>

        <?php
        if ($post) {
            require_once(__ROOT__ . '/layout/post.php');
        } else {
            require_once(__ROOT__ . '/layout/post_not_found.php');
        }
        ?>
    </body>
</html>
