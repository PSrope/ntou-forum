<?php

class Comparer
{
    public static function compare($obj1, $obj2)
    {
        $diff = array();
        foreach (get_object_vars($obj1) as $key => $value) {
            if ($obj1->$key != $obj2->$key) {
                $diff[] = ['key' => $key, 'value' => $value];
            }
        }
        return $diff;
    }
}
