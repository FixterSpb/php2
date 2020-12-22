<?php

include "../config/config.php";
include "../engine/Autoload.php";
require_once '../vendor/autoload.php';
require_once '../helpers/helper.php';

use app\engine\{Autoload, App};

spl_autoload_register([new Autoload(), 'loadClass']);

(new App)->run();
//run() можно перенести в конструктор, но, думаю, так лучше -
// вдруг появится необходимость манипуляций с экземпляром App извне
// до запуска run()