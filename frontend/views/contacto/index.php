<?php
use yii\captcha\Captcha;
use yii\helpers\Html;
use frontend\models\ContactForm;
$this->title ="Contacto | ".$this->title;
?>
<div id="Banner" class="clearfix slider-wrapper theme-light">
        <div id="slider" class="nivoSlider">
        <?php if (isset($images) && $images): ?>
            <?php $aux = Yii::$app->controller; ?>
            <?php foreach ($images as $index=>$i):?>
                <?=Html::img($aux->getUrlImg($i),['width'=>'955','height'=>'480'])?>
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
    <h1>&nbsp;</h1>
    <p id="contactError" class='cartError' style='text-align:center;display:none'></p>
      <p align="justify">&nbsp;</p>
  <div class="BlockMiniLeft">
       <?= $content ?>
  </div>
    <div class="BlockMediumRight">
      <h2><strong>Formulario de Contacto</strong></h2>
      <?php $m = new  ContactForm;?>
      <form id="Contact" action='/site/contact' method='post'>
        <div id="Formulario">
          <div class="Label">
            <p>* Nombre</p>
            <?= Html::activeInput('text',$m,'name',['placeholder'=>'* Nombre','class'=>'FormLabel']) ?>
            <!-- <input id="name" name="name" placeholder="* Nombre" class="FormLabel" > -->
          </div>
          <div class="Label">
            <p>* Apellido</p>
            <?= Html::activeInput('text',$m,'lastName',['placeholder'=>'* Apellido','class'=>'FormLabel']) ?>
            <!-- <input id="lastname" name="lastname" placeholder="* Apellido" class="FormLabel" > -->
          </div>
          <div class="Label">
            <p>* E-mail</p>
            <?= Html::activeInput('text',$m,'email',['placeholder'=>'* E-mail','class'=>'FormLabel']) ?>
            <!-- <input id="mail" name="mail" placeholder="* E-mail" class="FormLabel" > -->
          </div>
          <div class="LabelArea">
            <p>* Mensaje</p>
            <?= Html::activeTextArea($m,'body',['placeholder'=>'* Mensaje','class'=>'FormText']) ?>
            <!-- <textarea id="message" name="message" placeholder="* Mensaje" class="FormText"></textarea> -->
          </div>
          <div class="LabelArea">
            <p>Codigo de Verificación</p>
            <div class="text-center">
              <div class="g-recaptcha" data-sitekey="6Len9QgTAAAAAEUSzVxoXszw1knja48vMdv7QNdi"></div>
            </div>
            <?php //Captcha::widget(['model'=>$m,'attribute'=>'verifyCode','options'=>['class'=>'FormLabel','placeholder'=>'Codigo de Verificación']]) ?>
          </div>
          <button id="SendBtn" class="FormSend FX" type='submit' data-loading-text="<i class='fa fa-refresh fa-spin'></i>">enviar</button>
          <!-- <input  type="submit"   value="enviar" > -->
          <p>Nota: Los campos marcados con * son obligatorios</p>
        </div>
    </form>
    </div>
    
    <div class="clearfix"></div>
  </div>
</section>
<script src='https://www.google.com/recaptcha/api.js'></script>