<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Content;
 ?>
 <?php $obj = new Content;?>
	<h2>
		Contenido Web
		<!-- <a  href='<?= Url::toRoute('content/new') ?>' class='btn btn-primary btn-sm' data-modal-width="1000" data-toggle='modalDinamic'>Nueva Sección</a> -->
	</h2>
	<hr>
	<ul class='nav nav-tabs dinamicTab'>
		<?php foreach ($content as $index=>$c): ?>
    		<li class='<?= $index==0?'active':'' ?>'><a href="#" data-toggle='tab'><?= $c->title ?></a></li>
		<?php endforeach ?>
	</ul>
  <div class="tab-content">
  	<?php foreach ($content as $i => $obj): ?>
    	<div class="<?= $i == 0 ? 'tab-pane active' : 'tab-pane' ?>">
    		<form enctype='multipart/form-data'  class='ajaxSubmit'  method='post' action='<?= Url::to(['content/update']) ?>'>
    			<input type='hidden' name='contentId' value='<?= $obj->id ?>'>
    			<?php if(isset($obj->banner)): ?>
    				<img style='max-width:100px' src="<?= Yii::$app->controller->getUrlImg($obj->banner) ?>">
    			<?php endif ?>
    			<div class="form-group">
    				<a href='<?= Url::to(['content/gallery','id'=>$obj->id]) ?>' data-toggle='modalDinamic' class='btn btn-warning'>Banners</a>
    				<!-- <input class='imgField' type="file" name='banner' accept='.jpeg,.png,.jpg'> -->
    			</div>
    			<div class="form-group">
    				<label><b>Contenido</b></label>
    				<?= Html::activeTextArea($obj,'bodyText',['class'=>'content-section']);?>
    			</div>
    			<div class="form-group text-right">
    				<button type='submit' class='btn btn-primary'>Guardar</button>
    			</div>
    		</form>
    	</div>
  	<?php endforeach ?>
  </div>
