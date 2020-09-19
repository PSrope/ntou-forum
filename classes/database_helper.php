<?php

require_once(__DIR__ . '/../includes/configs.php');

class DatabaseHelper
{
    public static function get_current_time()
    {
        $db = Database::get_instance();
        $query = "SELECT NOW()";
        $result = $db->execute($query);
        $now = $result[0]['NOW()'];
        return $now;
    }
}
