<?php if (count($basket) === 0): ?>
<h2>Корзина пуста</h2>
<?php else:?>

<table style="max-width: 768px; margin: 0 auto">
    <tr>
        <th style="padding: 5px">Наименование</th>
        <th style="padding: 5px; text-align: center">Цена</th>
        <th style="padding: 5px; text-align: center">Количество</th>
        <th style="padding: 5px; text-align: center">Сумма</th>
        <th></th>
    </tr>
    <?php foreach ($basket as $item): ?>
    <tr>
        <td style="padding: 5px"><?= $item['name'] ?></td>
        <td style="padding: 5px; text-align: center"><?= $item['price'] ?></td>
        <td style="padding: 5px; text-align: center"><?= $item['qty'] ?></td>
        <td style="padding: 5px; text-align: center"><?= $item['price'] * $item['qty'] ?></td>
        <td><button>X</button></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php endif; ?>
