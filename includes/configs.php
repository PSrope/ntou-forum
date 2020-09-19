<?php

define('__ROOT__', dirname(__DIR__));
define('ENV', require_once(__ROOT__ . '/config/environments.php'));

define('SUCCESS', true);
define('FAILURE', false);

require_once(__ROOT__ . '/includes/utility.php');
require_once(__ROOT__ . '/config/database.php');
require_once(__ROOT__ . '/config/session.php');

// autoloading classes
spl_autoload_register(function($ClassName) {
    $class_name = Utility::camel_to_snake($ClassName);
    $filename = __ROOT__ . '/classes/' . $class_name . '.php';
    if (file_exists($filename)) {
        require_once($filename);
    } else {
        die($filename . " not found.");
    }
});

$SESSION = Session::get_instance();
$FORUM = Forum::get_instance();
