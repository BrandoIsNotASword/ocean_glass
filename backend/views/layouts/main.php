<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
use common\models\User;
/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
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
    <?php $this->beginBody() ?>
    <div class="subnavbar" >
      <div class="subnavbar-inner">
        <div class="container">
          <ul class="mainnav" style='width:100%'>
            <li><img style='max-width:82px' src="/img/Logo.png"></li>
              <li class="<?= Yii::$app->controller->id=='sales'?"active":"" ?>"><a href="/"><i class="icon-dashboard"></i><span>Ventas</span> </a> </li>
              <li class="<?= Yii::$app->controller->id=='items'?"active":"" ?>"><a href="<?= Url::toRoute('items/') ?>"><i class="icon-list-alt"></i><span>Artículos</span> </a> </li>
              <?php if (Yii::$app->user->identity->accessLevel==User::AccessLevelMaster): ?>
                <li class="<?= Yii::$app->controller->id=='users'?"active":"" ?>"><a href="<?= Url::toRoute('users/') ?>"><i class="icon-group"></i><span>Usuario</span> </a> </li>
              <?php endif ?>
              <li class="<?= Yii::$app->controller->id=='settings'?"active":"" ?>"><a href="<?= Url::toRoute('settings/') ?>"><i class="icon-gear"></i><span>Configuraciones</span> </a> </li>
              <li class="<?= Yii::$app->controller->id=='reports'?"active":"" ?>"><a href="<?= Url::toRoute('reports/') ?>"><i class="icon-file"></i><span>Reportes</span> </a> </li>
              <li class="dropdown pull-right" style='border:0'>
                <a href="#" class="dropdown-toggle text-capitalize" data-toggle="dropdown">
                  <i class="icon-user"></i>
                  <span><?= Yii::$app->user->identity->username ?></span></a>
                <ul class="dropdown-menu">
                  <li><a href="javascript:;"><i class='icon-user'></i> Perfil</a></li>
                  <li><a href="<?= Url::toRoute('site/logout'); ?>"><i class='icon-signout'></i> Salir</a></li>
                </ul>
              </li>
         </li>
          </ul>
        </div>
        <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
  </div>

<div class="main">
  <div class="main-inner">
    <div class="container mycontainer">
       <?= $content ?>
        </div>
    </div>
</div>
<!-- warning model -->
<div id='warning-modal' class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-body">
        <h5>¿Esta seguro que desea continuar?</h5>       
        <p class='extra-message'></p>       
    </div>
    <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
           <a href='#' class="btn btn-primary action-button" data-loading-text="<i class='icon-refresh icon-spin'></i>">Continuar</a>
    </div>                                        
</div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
