<?php

require_once(__DIR__ . '/../includes/configs.php');

Session::REDIRECT_IF_LOGIN('home.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];
    $email = $_POST['email'];
    $result = $FORUM->signup($username,
                             $password,
                             $password_confirmation,
                             $email);
    if ($result[0] == SUCCESS) {
        $SESSION->set('flash_msg', "Sign up successfully, please log in.");
        Utility::redirect_to("login.php");
    } else {
        $SESSION->set('flash_msg', $result[1]);
        Utility::redirect_to("signup.php");
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>註冊</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/stylesheets/style.css">
    </head>
    <body>
        <form id="signup-form" action="" method="POST">
            <div id="bgset2"></div>
            <div id="signup">
                <div id="signup_title">註冊</div>

                <div class="line2"><span id="msg"></span></div>
                <div id="signup_input", class="line2">帳號&emsp;&emsp;
                    <input name="username" id="username" type="text" placeholder="請輸入帳號" required />
                </div>
                <div id="signup_input", class="line2">密碼&emsp;&emsp;
                    <input name="password" id="password" type="password" placeholder="請輸入密碼" required />
                </div>
                <div id="signup_input", class="line2">確認密碼
                    <input name="password_confirmation" id="password_confirmation" type="password" placeholder="確認密碼" required />
                </div>
                <div id="signup_input", class="line2">信箱&emsp;&emsp;
                    <input name="email" id="email" type="email" placeholder="輸入信箱" required />
                </div>
                <p style="color: #cc3333;" class="msg-error" id="password_confirm_msg"><?php echo $SESSION->get('flash_msg'); ?></p>
                <input id ="signup_submit" class="log_button2" type="submit" name="submit" value="註冊">
                <hr>
                <input id ="log_submit" class="log_button2" type="button" value="登入" onclick="location.href='login.php';">
            </div>
        </form>

        <script>
            function isPasswordMatch(password, password_confirmation) {
                return password === password_confirmation;
            }

            $("#password_confirmation").blur(function() {
                let password = $("#password");
                if (isPasswordMatch(password.val(), this.value)) {
                    $("#password_confirm_msg").html("");
                } else {
                    $("#password_confirm_msg").html("Passwords do not match.");
                }
            });

            $("#signup-form").submit(function() {
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
