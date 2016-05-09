<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Item;
use common\models\GarmentType;
 ?>
<div class="modal-header myheader-edit">
	<button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3 class='modal-title'>Edicion de Articulo</h3>
</div>
	<form method='post' enctype='multipart/form-data' class='ajaxSubmit validateForm' action='<?= Url::to(['items/update','id'=>$item->id]) ?>'>
<div class="modal-body">
	<div class="row">
		<div class="form-group col-md-6">
			<label>Nombre</label>
			<?= Html::activeInput('text',$item,'name',['class'=>'form-control input-sm required']); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 form-group">
			<label>Estado</label>
			<?= Html::activeDropDownList($item,'status',$item->getStatusArray(),['class'=>'form-control input-sm']); ?>			
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 form-group">
			<label>Precio</label>
			<div class="input-group">
				<span class='input-group-addon'>$</span>
			<?= Html::activeInput('text',$item,'price',['class'=>'form-control input-sm required number numberField']); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label>Descripcion</label>
		<?= Html::activeTextArea($item,'description',['class'=>'form-control input-sm']); ?>
	</div>
	<hr>
	<div class="text-center">
		<a href='<?= Url::toRoute(['items/gallery','id'=>$item->id]) ?>' class='btn btn-xs btn-info' data-modal-width='700' data-toggle='modalDinamic'>IMAGENES</a>
		<a data-modal-width='800px' href='<?= Url::toRoute(['items/inventory','id'=>$item->id]) ?>' class='btn btn-xs btn-info' data-toggle='modalDinamic'>INVENTARIO</a>
	</div>
</div>
<div class="modal-footer text-right">
	<button type='button' data-dismiss='modal' class='btn btn-default'>Cerrar</button>
	<button type='submit' class='btn btn-primary'>Guardar</button>
</div>
	</form>