<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
 ?>
<div class="modal-header myheader">
 	<button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">&times;</button>
 	<h4 class='modal-title'>Imagen de Color: <?= $color->color->name ?></h4>
</div>
<form class='ajaxSubmit' method='post' action='<?= Url::to(['items/changeimages','id'=>$color->id]) ?>'>
<div class="modal-body text-center">
	 <div class="row">
	 	<?php $relatedImages = ArrayHelper::map($color->images,'id','id'); ?>
 		<?php foreach ($color->item->images as $i): ?>
 		<div class="col-md-4 text-center" style='margin-bottom:10px'>
				<label>
			<img class='' src="<?= Yii::$app->controller->getUrlImg($i,2) ?>" data-zoom-image='<?= Yii::$app->controller->getUrlImg($i,1) ?>'>
			<div style='' class="text-center">
				<input <?= in_array($i->id,$relatedImages)?"checked='checked'":'' ?> type='checkbox' name='images[]' value='<?= $i->id ?>'>
			</div>
				</label>
 		</div>
 		<?php endforeach ?>
 	</div>
</div>
<div class="modal-footer">
	<button type='submit' class='btn btn-primary'>Guardar</button>
</div>
</form>