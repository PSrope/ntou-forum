<?php

require_once(__DIR__ . '/../includes/configs.php');

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
            <h1>&nbsp;<a href="home.php">海大留言板</a></h1>
            <div class="hr_line"></div>
            <?php
                if (Session::is_login()) {
                    require_once(__ROOT__ . '/layout/post_list.php');
                } else {
                    require_once(__ROOT__ . '/layout/not_login_msg.php');
                }
            ?>
        </div>
        <?php if (Session::is_login()) { require_once(__ROOT__ . '/layout/menu.php'); } ?>
    </body>
</html>
