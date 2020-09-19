<?php

require_once(__DIR__ . '/../includes/configs.php');

if (Session::is_login()) {
    $SESSION->logout();
}

Utility::redirect_to('home.php');
