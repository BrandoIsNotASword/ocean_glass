<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Item;
use common\models\GarmentType;
 ?>
<div class="modal-header myheader">
 	<button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3 class='modal-title'>Articulo Nuevo</h3>
</div>
<?php $i = new Item; ?>
	<form method='post' enctype='multipart/form-data' class='ajaxSubmit validateForm' action='<?= Url::toRoute('items/create') ?>'>
<div class="modal-body">
	<div class="row">
		<div class="form-group col-md-6">
			<label>Nombre</label>
			<?= Html::activeInput('text',$i,'name',['class'=>'form-control input-sm required']); ?>
		</div>
		<div class="col-md-6 form-group">
			<label>Estado</label>
			<?php $status=$i->getStatusArray();unset($status[Item::StatusDeleted]) ?>
			<?= Html::activeDropDownList($i,'status',$status,['class'=>'form-control input-sm']); ?>			
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 form-group">
			<label>Precio</label>
			<div class="input-group">
				<span class='input-group-addon'>$</span>
			<?= Html::activeInput('text',$i,'price',['class'=>'form-control input-sm required number numberField']); ?>
			</div>
		</div>
		<div class="col-md-6 form-group">
			<label>Inventario incial</label>
			<?= Html::activeInput('text',$i,'firstStock',['class'=>'form-control input-sm required number']); ?>
		</div>
	</div>
	<div class="form-group">
		<label>Descripcion</label>
		<?= Html::activeTextArea($i,'description',['class'=>'form-control input-sm']); ?>
	</div>
	<hr>
	<h3>Imagen</h3>
	<input type='file' name='images[]' class='imgField' accept='.jpeg,.png,.jpg' multiple> 
<!-- 	<hr>
	<h3>Colores</h3>
	<input type='color' name='images[]' class='colorField[]' multiple> 
 --></div>
<div class="modal-footer text-right">
	<button type='button' data-dismiss='modal' class='btn btn-default'>Cancelar</button>
	<button type='submit' class='btn btn-primary'>Continuar con el inventario</button>
</div>
	</form>
