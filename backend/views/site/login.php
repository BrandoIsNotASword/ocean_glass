<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\assets\LoginAsset;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<div class="account-container">
    <div class="content clearfix">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        
            <!-- <h1>Inicia Sesion</h1>        -->
            <div class="text-center">
                <img src="/img/Logo.png" style='max-width:100%; background-color:#B83A4D;'>
            </div>
            <br>
            <br>
            <div class="login-fields">
                <div class="field">
                    <label for="username">Username</label>
                    <!-- <input type="text" id="username" name="username" value="" placeholder="Username" class="login username-field" /> -->
                    <?= Html::activeTextInput($model, 'username',['placeholder'=>'Username','class'=>'login username-field']) ?>
                    <?= Html::error($model, 'username') ?>
                </div> 
                
                <div class="field">
                    <label for="password">Password:</label>
                    <!-- <input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/> -->
                    <?= Html::activePasswordInput($model,'password',['placeholder'=>'Password','class'=>'login password-field']) ?>
                    <?= Html::error($model, 'password') ?>
                </div> 
                
            </div> <!-- /login-fields -->
            
            <div class="login-actions">
                
                <!-- <span class="login-checkbox"> -->
                    <!-- <input id="Field" name="Field" type="checkbox" class="" value="First Choice" tabindex="4" /> -->
                    <?= Html::activeCheckbox($model,'rememberMe',['class'=>'field login-checkbox','label'=>'Recuerdame','labelOptions'=>['class'=>'login-checkbox']]) ?>
                    <!-- <label class="choice" for="Field">Recuerdame</label> -->
                <!-- </span> -->
                                    
                
            </div> <!-- .actions -->
            <div class="text-center">
            <button type='submit' class="btn btn-success btn-large">Entrar</button>
            </div>
            
                <?php ActiveForm::end(); ?>
        
    </div> <!-- /content -->
    
</div> <!-- /account-container -->
 <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
