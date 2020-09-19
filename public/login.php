<?php

require_once(__DIR__ . '/../includes/configs.php');

Session::REDIRECT_IF_LOGIN('home.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $SESSION->login($username, $password);
    if (Session::is_login()) {
        Utility::redirect_to('home.php');
    } else {
        $SESSION->set('flash_msg', "Invalid username/password.");
        Utility::redirect_to('login.php');
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>登入</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/9a93ec8ea5.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="assets/stylesheets/style.css">
    </head>
    <body>
        <div id="bgset">
            <form id="login-form" action="" method="POST">
                <div id="login">
                    <div id="login_title">海 大 留 言 板</div>

                    <div class="line"><span id="msg"></span></div>
                    <div class="line">
                        <i class="fas fa-user"></i>
                        <input name="username" id="username" type="text" placeholder="請輸入帳號" required />
                    </div>
                    <br>
                    <div class="line">
                        <i class="fas fa-lock"></i>
                        <input name="password" id="password" type="password" placeholder="請輸入密碼" required />
                    </div>
                    <p style="color: #cc3333;" class="msg-error" id="login_msg"><?php echo $SESSION->get('flash_msg'); ?></p>
                    <input id="log_submit" class="log_button" type="submit" name="submit" value="登入">
                    <hr>
                    <input id="log_signup" class="log_button" type="button" value="註冊" onclick="location.href='signup.php';">
                </div>
            </form>
        </div>
    </body>
</html>

<?php

if ($SESSION->get('flash_msg')) {
    $SESSION->set('flash_msg', "");
}

?>
