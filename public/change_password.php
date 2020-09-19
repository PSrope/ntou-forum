<?php

require_once(__DIR__ . '/../includes/configs.php');

Session::REQUIRE_LOGIN();

$current_user = $SESSION->get('current_user');

if (isset($_POST['submit'])) {
    $old_password = $_POST['old_password'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];
    $result = $FORUM->change_password($old_password,
                                      $password, $password_confirmation);
    if ($result[0] == SUCCESS) {
        $SESSION->logout();
        Utility::redirect_to('login.php');
    } else {
        $SESSION->set('flash_msg', $result[1]);
        Utility::redirect_to('change_password.php');
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>修改密碼</title>
        <script src="https://kit.fontawesome.com/9a93ec8ea5.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/stylesheets/style.css">
    </head>

    <body>
        <?php require_once(__ROOT__ . '/layout/menu.php'); ?>
        <form id="change-password-form" action="" method="POST">
            <div id="bgset3"></div>
            <div id="change_info">
                <div id="account_title">修&nbsp;改&nbsp;密&nbsp;碼</div>
                <div class="line2 account_input"><span id="msg"></span></div>
                <div class="line2 account_input">舊密碼&emsp;&emsp;
                    <input id="old_password" name="old_password" type="password" placeholder="" required>
                </div>
                <div class="line2 account_input">新密碼&emsp;&emsp;
                    <input id="password" name="password" type="password" placeholder="" required>
                </div>
                <div class="line2 account_input">確認新密碼
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder="" required>
                </div>
                <p style="color: #cc3333;" class="msg-error" id="error-msg"><?php echo $SESSION->get('flash_msg'); ?></p>
                <input name="submit" id ="log_submit" class="log_button2" type="submit" value="確認重設">
                <input id ="cancel_change_password" class="log_button2" type="button " style="height: 40px;"
                       value="取消密碼重設" onclick="location.href='user.php'">
            </div>
        </form>
        <script>
            function isPasswordMatch(password, password_confirmation) {
                return password === password_confirmation;
            }

            $("#password_confirmation").blur(function() {
                let password = $("#password");
                if (isPasswordMatch(password.val(), this.value)) {
                    $("#error-msg").html("");
                } else {
                    $("#error-msg").html("Passwords do not match.");
                }
            });

            $("#change-password-form").submit(function() {
                let password = $("#password");
                let password_confirmation = $("#password_confirmation");
                return isPasswordMatch(password.val(), password_confirmation.val());
            });
        </script>
    </body>
</html>

<?php

if ($SESSION->get('flash_msg')) {
    $SESSION->set('flash_msg', "");
}

?>
