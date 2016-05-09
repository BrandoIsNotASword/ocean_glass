<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\LoginForm;

?>
<div id="logindiv" style='display:none'>
	<?php $login = new LoginForm;?>
    <?php $form = ActiveForm::begin(['id' =>'login-form','action'=>'/site/login','enableAjaxValidation'=>true,'validateOnSubmit'=>true,'validateOnType'=>false,'validateOnChange'=>false,'validateOnBlur'=>false]); ?>
		<p><a href='/site/signup'>Crea una Cuenta</a></p>
			<?= $form->field($login,'email',['options'=>['class'=>'userfield']])->label('Email') ?>
            <?php // Html::activeInput('text',$login, 'username',['class'=>'login username-field']) ?>
            <?php // Html::error($login,'username') ?>
			<!-- <input id='userLogin' type='text'> -->
			<?= $form->field($login,'password',['options'=>['class'=>'passfield']])->passwordInput()->label('Contraseña') ?>
            <?php // Html::activeInput('password',$login,'password',['class'=>'login password-field']) ?>
            <?php // Html::error($login,'password') ?>
		<button type='submit' class="button-div" data-loading-text="<i class='fa fa-refresh fa-spin'></i>">
			<p>entrar</p>
		</button>
    <?php ActiveForm::end(); ?>
</div>