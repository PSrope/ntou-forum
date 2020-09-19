<?php

require_once(__DIR__ . '/../includes/configs.php');
require_once(__ROOT__  . '/vendor/autoload.php');

use josegonzalez\Dotenv\Loader as Dotenv;

$loader = new Dotenv(__ROOT__ . '/.env');
$loader->parse();
$env = $loader->toArray();

return $env;
