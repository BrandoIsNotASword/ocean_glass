<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Inicia Sesion';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="loginLayout">
    <h1 class='text-center'><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <?= $form->field($model,'email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
        <div style="color:#999;margin:1em 0">
          <?= Html::a('¿Olvidates tu contraseña?', ['site/request-password-reset']) ?>.
        </div>
        <div class="form-group text-center">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
