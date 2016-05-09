<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
?>
<section>
        <form action='<?= Yii::$app->request->url ?>' action='get'>
            <br>
            Artículos por página:
            <?php $issetLimit = isset($_GET['limit']); ?>
            <select id='elementsPerPage' name='limit' style='width:70px;display:inline-block' class='form-control input-sm'>
                <option <?= $issetLimit && $_GET['limit']=='9'?"selected='selected'":'' ?>value='9'>9</option>
                <option <?= $issetLimit && $_GET['limit']=='15'?"selected='selected'":'' ?>value='15'>15</option>
                <option <?= $issetLimit && $_GET['limit']=='50'?"selected='selected'":'' ?>value='50'>50</option>
            </select>
            <?php if (isset($_GET['q'])): ?>
                <input type='hidden' value='<?= $_GET['q'] ?>' name='q'>
            <?php endif ?>
        </form>
        
        <h3 class='text-center'>Artículos</h3>
        <?php $last = -1; ?>
        <div class="row">
        <?php //for($j=0;$j<5;$j++): ?>
        <?php foreach ($items as $index => $i): ?>
            <div class="item col-md-3">
                <div class="border">
                <?= Html::img(Yii::$app->controller->getUrlImg($i->getPrincipalImg(),1))?>
                <h4><?= $i->name ?></h4>
                <p><strong>$<?= number_format($i->price,2) ?> MXN</strong></p>
                <!-- <p><?= $i->description ?></p> -->
                <form method='post' action='<?= Url::to(['carrito/additem']) ?>' class="text-center">
                    <input type='hidden' value='<?= $i->id ?>' name='item'>
                    <select class='form-control input-sm' name='quantity'>
                        <?php for($aux=1;$aux<=$i->stock;$aux++): ?>
                        <option value='<?= $aux ?>'><?= $aux ?></option>
                        <?php endfor; ?>
                    </select>
                    <br>
                    <button class='btn btn-sm btn-primary' href="#" data-item='<?= $i->id ?>'><i class='fa fa-plus'></i> Agregar a carrito</button>
                </form>
                </div>
            </div>
        <?php endforeach ?>
        <?php //endfor; ?>
        </div>
        <?php if (count($items)==0): ?>
        <div class="text-center">
            <h4 class='text-center'>No se encontraron artículos</h4>
            <i class='fa fa-frown-o fa-2x'></i>
            <br>
            <br>
        </div>
        <?php endif ?>
        <div class="text-center">
            <?= LinkPager::widget(['pagination' => $pag]) ?>
        </div>
</section>