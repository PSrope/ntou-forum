<?php

require_once(__DIR__ . '/../includes/configs.php');

abstract class Manager
{
    protected $DB;

    protected function __construct()
    {
        $this->DB = Database::get_instance();
    }

    abstract public function create($obj);
    abstract public function delete($obj);
    abstract public function update($obj);
}
