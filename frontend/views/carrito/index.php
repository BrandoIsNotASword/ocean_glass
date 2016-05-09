<?php 
use yii\helpers\Url;
use common\models\Item;
 ?>
 <?php
    $itemsCount = count($items);
    $total = 0;
 ?>

 <h1>Artículos en el carrito</h1>
<section id='cart'>
 <table class='table table-condensed table-bordered'>
    <thead>
        <tr>
            <th colspan='2'>Articulo</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($itemsCount!=0): ?>
            <?php foreach ($items as $itemId => $quantity): ?>
            <?php $item = Item::findOne($itemId); ?>
                <tr>
                    <td>
                        <?= $item->name ?>
                    </td>
                    <td>
                        <img src="<?= Yii::$app->controller->getUrlImg($item->getPrincipalImg(),2) ?>" >
                    </td>
                    <td>
                        <?= $quantity ?>
                    </td>
                    <td>
                        $<?= number_format($item->price,2) ?> MXN
                    </td>
                    <td>
                        $<?= number_format($item->price*$quantity,2) ?> MXN
                        <?php $total+=$item->price*$quantity; ?>
                    </td>
                    <td>
                        <a href="/carrito/delitem?item=<?= $item->id ?>" class='btn btn-danger btn-xs delitem'><i class='fa fa-trash fa-2x'></i></a>
                    </td>   
                </tr>
            <?php endforeach ?>
                <tr>
                    <td colspan='4'></td>
                    <td colspan='2'>Total $<?= number_format($total,2) ?> MXN <a href="/carrito/info">Continuar <i class='fa fa-arrow-right'></i></a></td>
                </tr>
        <?php else: ?>
            <tr>
                <td colspan='6' class='text-center'>No se han cargado artículos</td>
            </tr>
        <?php endif ?>
    </tbody>
 </table>
 <a href="/" style='font-size:20px' class='btn btn-primary'><i class='fa fa-arrow-left'></i> Continuar comprando</a>
</section>