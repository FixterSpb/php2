<?php

use app\engine\App;

require_once '../vendor/autoload.php';
require_once '../helpers/helper.php';

$config = include "../config/config.php";

try {
   App::call()->run($config);
}catch (\Exception $e){
    var_dump($e);
}
