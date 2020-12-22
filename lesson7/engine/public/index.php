<?php

include "../config/config.php";
include "../engine/Autoload.php";
require_once '../vendor/autoload.php';
require_once '../helpers/helper.php';

use app\engine\Autoload;
use app\engine\App;

spl_autoload_register([new Autoload(), 'loadClass']);

try {
    (new App)->run();
}catch (\Exception $e){
    var_dump($e);
}
