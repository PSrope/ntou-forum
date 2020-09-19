<?php

require_once(__DIR__ . '/../includes/configs.php');

Session::REQUIRE_LOGIN();

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $FORUM->create_post($title, $content);
    Utility::redirect_to('home.php');
}

?>

<!DOCTYPE html>
<html lang="zh-TW">
    <head>
        <script src="https://kit.fontawesome.com/9a93ec8ea5.js" crossorigin="anonymous"></script>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="assets/stylesheets/style.css">
        <title>發布新文章</title>
    </head>

    <body>
        <form id="new-post-form" action="" method="POST">
            <h1>&nbsp;發布新文章</h1>
            <div class="hr_line"></div>
            <br>
            <div class="post_theme" value="文章">
                <span class="post_title">標題名稱：</span>
                <input id="p_title" name="title" type="text" placeholder="請輸入標題" required>
                <br>
            </div>

            <div class="post_theme con" value="文章">
                <span class="post_context">文章內容：</span>
                <br>
                <center>
                    <textarea id="p_context" name="content" placeholder="請輸入內文"></textarea>
                    <input id="postButton" name="submit" class="log_button button_mes" type="submit" value="發布文章">
                    <input id="cancelButton" class="log_button button_mes" type="button" value="取消發布" onclick="location.href='home.php';">
                </center>
            </div>

        </form>
    </body>
</html>
