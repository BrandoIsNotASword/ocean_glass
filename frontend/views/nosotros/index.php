<?php
use yii\helpers\Url;
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title ="Nosotros | ".$this->title;
?>
<div id="Banner" class="clearfix slider-wrapper theme-light">
        <div id="slider" class="nivoSlider">
        <?php if (isset($images) && $images): ?>
            <?php $aux = Yii::$app->controller; ?>
            <?php foreach ($images as $index=>$i):?>
                <?=Html::img($aux->getUrlImg($i),['width'=>'955','height'=>'480'])?>
                <!-- <img src="" style='width:955;height:480;' title='image1Title'> -->
            <?php endforeach ?>
        <?php else: ?>
            <?=Html::img('@web/images/slider/sample2.jpg',['width'=>'955','height'=>'480'])?>
            <?=Html::img('@web/images/slider/sample3.jpg',['width'=>'955','height'=>'480'])?>
            <?=Html::img('@web/images/slider/sample4.jpg',['width'=>'955','height'=>'480'])?>            
        <?php endif ?>
        </div>
</div>
<section class="FullLayout white">
	<div class="CenterLayout">
        <div class="row">
            <div class="col-md-4">
                <img src="/images/logos/megustamex.png" alt="MegustaMex" width="298" height="324">
            </div>
            <div style='padding:40px 0' class="col-md-7">
                <h1>Acerca de Nosotros</h1>
                <?= $content ?>
            </div>
        </div>
  </div>
</section>