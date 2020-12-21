<?php

include "../config/config.php";
include "../engine/Autoload.php";
require_once '../vendor/autoload.php';
require_once '../helpers/helper.php';

use app\engine\Autoload;
use app\engine\App;

spl_autoload_register([new Autoload(), 'loadClass']);

try {
//    $session = new \app\engine\Session();
//    $session->destroy();
//    $session->user = '123';
//    var_dump($session->getId());
    (new App)->run();
}catch (\Exception $e){
    var_dump($e);
}
//run() можно перенести в конструктор, но, думаю, так лучше -
// вдруг появится необходимость манипуляций с экземпляром App извне
// до запуска run()