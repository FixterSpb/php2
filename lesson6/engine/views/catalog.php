<h2>Каталог</h2>

<?php foreach ($catalog as $item):?>
<h3><a href="/?c=product&a=card&id=<?=$item['id']?>"><?=$item['name']?></a></h3>
<p><?=$item['description']?></p>
<p><?=$item['price']?></p>
<button>Купить</button>
<hr>
<?php endforeach;?>

<a href="/product/catalog?page=<?=$page?>">Далее</a>