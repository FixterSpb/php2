<?php


class Autoload
{

    public function loadClass($className) {

        //app\models\Product
        //а надо
        //../models/Product.php
        //str_replace
        $fileName = str_replace("\\", "/", str_replace("app\\", "../", $className)) . ".php";
        echo "<br><br>", $className;
        echo "<br><br>", $fileName;

        if (file_exists($fileName)) {
            include $fileName;
        }

    }
}