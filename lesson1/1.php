<?php

/*
 * Честно говоря, с фантазией у меня не очень и придумать взаимодействующие сущности - пожалуй было самым сложным
 * в этом задании :(
 */

class Human {
    public $name = "";
    public $money = 0;

    public function __construct($name = "Безымянный", $money = 0)
    {
        echo("Привет, меня зовут $name. У меня есть $money монет.<br>");
        $this->name = $name;
        $this->money = $money;

    }

}

class Seller extends Human{

    public $products = 0;

    public function __construct($name = "Безымянный продавец", $money = 0, $products = 0)
    {
        parent::__construct($name, $money);
        echo("Я продавец. У меня есть $products продуктов. Я их продаю механикам.<br>");
        $this->products = $products;
    }

    public function sellProducts(Mechanic $unit, $product)
    {
        $incHealth = 10 * $product;
        $amount = 5 * $product;

        $unit->health += $incHealth;
        echo "Продавец, $this->name продал $product шт. продуктов механику $unit->name.<br>";
        echo "$unit->name поел и его здоровье улучшилось на $incHealth%. Теперь оно составляет $unit->health%.<br>";

        $unit->money -= $amount;
        $this->money += $amount;
        echo "$unit->name теперь имеет $unit->money монет, а $this->name - $this->money.<br>";

        $this->products -= $product;
        echo "У $this->name осталось $this->products шт. продуктов.<br>";

    }
}

class Provider extends Human{
    public $boxProducts = 0;
    public $carHealth = 0;

    public function __construct($name = "Безымянный поставщик", $money = 0, $boxProducts = 0, $carHealth = 100)
    {
        parent::__construct($name, $money);

        $this->boxProducts = $boxProducts;
        $this->carHealth = $carHealth;

        echo("Я поставщик. У меня есть $this->boxProducts коробок продуктов. Я их поставляю продавцам на своем автомобиле.<br>");
        echo("Состояние моего автомобиля - $this->carHealth %.<br>");
    }

    public function provideProducts(Seller $unit, $box)
    {

        $incProd = 10 * $box;
        $decCarHealth = 5 * $box;
        $amount = 4 * $box;

        $unit->products += $incProd;
        echo "Поставщик $this->name привез продавцу $unit->name $box коробок продуктов.<br>";
        echo "Теперь у $unit->name $unit->products шт. продуктов, ";

        $this->boxProducts -= $box;
        echo "а у $this->name осталось $this->boxProducts коробок.<br>";


        $unit->money -= $amount;
        $this->money += $amount;
        echo "$unit->name заплатил $amount монет.<br>";
        echo "$unit->name теперь имеет $unit->money монет, а $this->name - $this->money.<br>";

        $this->carHealth -= $decCarHealth;
        echo "Техническое состояние автомобиля $this->name снизилось на $decCarHealth% и теперь составляет $this->carHealth%.<br>";
    }
}

class Mechanic extends Human{

    public $carParts = 0;
    public $health = 0;

    public function __construct($name = "Безымянный механик", $money = 0, $carParts = 0, $health = 100)
    {
        parent::__construct($name, $money);

        $this->carParts = $carParts;
        $this->health = $health;

        echo("Мое здоровье: $health%. У меня есть $carParts запчастей. Я ремонтирую автомобили.<br>");
    }

    public function repairCar(Provider $unit, $carHealth)
    {

        $amount = $carHealth;
        $decHealth = $carHealth;


        $unit->carHealth += $carHealth;
        echo "Механик $this->name отремонтировал автомобить поставщика $unit->name. <br>";
        echo "Состояние автомобиля теперь $unit->carHealth%.<br>";


        $unit->money -= $amount;
        $this->money += $amount;
        echo "$unit->name заплатил за работу $amount монет.<br>";
        echo "Теперь $unit->name имеет $unit->money монет, а $this->name - $this->money.<br>";

        $this->health -= $decHealth;
        echo "В процессе работы здоровье $this->name уменьшилось на $decHealth %. Теперь его здоровье составляет $this->health%.<br>";
    }

}

$seller = new Seller('Alex', 100, 10);
echo "<br>";

$provider = new Provider('John', 100, 5, 80);
echo "<br>";

$mechanic = new Mechanic('Bob', 20, 30, 100);
echo "<br>";

var_dump($seller);
echo "<br>";
var_dump($provider);
echo "<br>";
var_dump($mechanic);
echo "<br><br>";

$mechanic->repairCar($provider, 20);
echo "<br>";
$seller->sellProducts($mechanic, 2);
echo "<br>";
$provider->provideProducts($seller, 2);
echo "<br>";

var_dump($seller);
echo "<br>";
var_dump($provider);
echo "<br>";
var_dump($mechanic);
echo "<br><br>";
