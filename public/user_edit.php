<?php

require_once(__DIR__ . '/../includes/configs.php');

Session::REQUIRE_LOGIN();

$current_user = $SESSION->get('current_user');

if (isset($_POST['submit'])) {
    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $FORUM->update_user_info(['nickname' => $nickname,
                              'email' => $email]);
    Utility::redirect_to('user.php');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>修改使用者資料</title>
        <script src="https://kit.fontawesome.com/9a93ec8ea5.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="assets/stylesheets/style.css">
    </head>

    <body>
        <?php require_once(__ROOT__ . '/layout/menu.php'); ?>
        <form action="" method="POST">
            <div id="bgset3"></div>
            <div id="change_info">
                <div id="account_title">修 改 使 用 者 資 料</div>

                <div class="line2 account_input"><span id="msg"></span></div>
                <div class="line2 account_input">暱稱&emsp;&emsp;
                    <input id="change_nickname" name="nickname" type="text" value="<?php echo $current_user->nickname; ?>" required>
                </div>
                <div class="line2 account_input">信箱&emsp;&emsp;
                    <input id="email" name="email" type="email" value="<?php echo $current_user->email; ?>" required>
                </div>
                <br>
                <input id ="log_submit" name="submit" class="log_button2" type="submit" value="確認重設">
                <input id ="cancel_reset" class="log_button2" type="button" style="height: 40px;"
                       value="取消修改" onclick="location.href='user.php'">
                <hr>
                <input id ="change_password_btn" class="log_button2" type="button" style="height: 40px;"
                       value="修改密碼" onclick="location.href='change_password.php'">
                    </div>
        </form>
    </body>
</html>
