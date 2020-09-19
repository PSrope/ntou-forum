<?php

require_once(__DIR__ . '/../includes/configs.php');

Session::REQUIRE_LOGIN();

$current_user = $SESSION->get('current_user');

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>使用者資料</title>
        <script src="https://kit.fontawesome.com/9a93ec8ea5.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="assets/stylesheets/style.css">
    </head>

    <body>
        <?php require_once(__ROOT__ . '/layout/menu.php'); ?>
        <div id="bgset3"></div>
        <div id="change_info">
            <div id="account_title">使 用 者 資 料</div>
            <div class="line2 account_input">
                <span id="msg"></span>
            </div>
            <div class="line2 account_input">用戶名&emsp;
                <div id="username"><?php echo $current_user->username; ?></div>
            </div>
            <div class="line2 account_input">暱稱&emsp;
                <div id="nickname"><?php echo $current_user->nickname; ?></div>
            </div>
            <div class="line2 account_input">信箱&emsp;
                <div id="email"><?php echo $current_user->email; ?></div>
            </div>
            <div class="line2 account_input">發文數&emsp;
                <div id="email"><?php echo $current_user->post_count; ?></div>
            </div>
            <div class="line2 account_input">註冊日期
                <div id="join-date"><?php echo $current_user->join_date; ?></div>
            </div>
            <div class="line2 account_input">上次登入
                <div id="last-login"><?php echo $current_user->last_login; ?></div>
            </div>
            <input id ="log_submit" class="log_button2" type="button"
                    value="管理文章" onclick="location.href='my_post.php'">
            <input id ="log_submit" class="log_button2" type="button"
                    value="修改資料" onclick="location.href='user_edit.php'">
            <input id ="log_submit" class="log_button2" type="button"
                    value="回首頁" onclick="location.href='home.php'">
        </div>
    </body>
</html>
