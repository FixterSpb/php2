<?php


namespace app\models\entities;

abstract class Model
{

    public function __set($name, $value) {
        if (property_exists($this, $name)){
            $this->$name = $value;
            if(isset($this->props[$name])) $this->props[$name] = true;
        }
    }

    public function __get($name) {
        return $this->$name;
    }

    public function __isset($name)
    {
        return property_exists($this, $name);
    }

    public function clearProps(){
        if (!property_exists($this, 'props')) return;

        foreach ($this->props as $key=>$value){
            $this->props[$key] = false;
        }
    }
}