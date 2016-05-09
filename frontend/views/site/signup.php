<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */
?>
<!-- <div id="loginLayout"> -->
    <!-- <h1 class='text-center'><?= Html::encode($this->title) ?></h1> -->
        <?php // $form->field($model,'email') ?>
        <?php // $form->field($model,'compareEmail') ?>
        <?php // $form->field($model,'firstName') ?>
        <?php // $form->field($model,'lastName') ?>
        <?php // $form->field($model,'password')->passwordInput() ?>
        <?php // $form->field($model,'comparePassword')->passwordInput() ?>
        <?php // $form->field($model,'phone') ?>
        <!-- <br> -->
<!-- </div> -->

<section class="FullLayout white">
    <div class="CenterLayout">
    <h1>&nbsp;</h1>
    <div id="Login">
        <h1>Login</h1>
      <h3>¿Nuevo en La Gran Nación?</h3>
        <p>Registra tus datos a continuación</p>
        <h3></h3>

    <?php $form = ActiveForm::begin(['id' =>'form-signup']);?>
        <div class="CompraLabel">
          <p>Nombre(s)</p>
            <?= Html::activeInput('text',$model,'firstName',['class'=>'InputLabel','placeholder'=>'Nombre(s)']) ?>
            <?= Html::error($model,'firstName',['class'=>'error-field-yii']) ?>
        </div>
        <div class="CompraLabel">
          <p>Apellidos</p>
            <?= Html::activeInput('text',$model,'lastName',['class'=>'InputLabel','placeholder'=>'Apellidos']) ?>
            <?= Html::error($model,'lastName',['class'=>'error-field-yii']) ?>
        </div>
        <div class="CompraLabel">
          <p>Teléfono</p>
            <?= Html::activeInput('text',$model,'phone',['class'=>'InputLabel','placeholder'=>'Teléfono']) ?>
            <?= Html::error($model,'phone',['class'=>'error-field-yii']) ?>
          <p>Favor de incluir la clave LADA</p>
        </div>
        <div class="CompraLabel">
          <p>Correo ELectrónico</p>
            <?= Html::activeInput('text',$model,'email',['class'=>'InputLabel','placeholder'=>'Correo Electrónico']) ?>
            <?= Html::error($model,'email',['class'=>'error-field-yii']) ?>
        </div>
        <div class="CompraLabel">
          <p>Verifica Correo ELectrónico</p>
            <?= Html::activeInput('text',$model,'compareEmail',['class'=>'InputLabel','placeholder'=>'Correo Electrónico Nuevamente']) ?>
            <?= Html::error($model,'compareEmail',['class'=>'error-field-yii']) ?>
        </div>
        <div class="clearfix"></div>
        <div class="CompraLabel">
          <p>Contraseña</p>
            <?= Html::activeInput('password',$model,'password',['class'=>'InputLabel','placeholder'=>'Correo Electrónico']) ?>
            <?= Html::error($model,'password',['class'=>'error-field-yii']) ?>
        </div>
        <div class="CompraLabel">
          <p>Repite Contraseña</p>
            <?= Html::activeInput('password',$model,'comparePassword',['class'=>'InputLabel','placeholder'=>'Correo Electrónico Nuevamente']) ?>
            <?= Html::error($model,'comparePassword',['class'=>'error-field-yii']) ?>
        </div>
        <div id="RememberMe">
            <label>Recuerdame en esta computadora
            <?= Html::activeCheckbox($model,'rememberMe',['label'=>'']) ?>
            </label>
        </div>
        <button type='submit' id="BtnLogin">Crear Cuenta</button>
        <p>Al crear una cuenta, estas de acuerdo con los <a href="#">Términos y Condiciones</a>, así como de las <a href="#">Políticas de Privacidad</a> de La Gran Nación. </p>
    <?php ActiveForm::end(); ?>
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    </div>
</section>
<script type="text/javascript">
    location.hash="Login";
</script>
