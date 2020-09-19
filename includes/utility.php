<?php

class Utility
{
    public static function redirect_to($url, $delay = 0)
    {
        header("refresh:$delay; url=$url");
        exit();
    }

    public static function camel_to_snake($CamelCase)
    {
        $pattern = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';
        preg_match_all($pattern, $CamelCase, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            if ($match == strtoupper($match)) {
                $match = strtolower($match);
            } else {
                $match = lcfirst($match);
            }
        }
        $snake_case = implode('_', $ret);
        return $snake_case;
    }
}
