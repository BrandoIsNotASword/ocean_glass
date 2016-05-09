<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Inventory;
?>
<div class="modal-header myheader">
		<button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class='modal-title'>Modificar inventario</h4>
</div>
<form class='validateForm ajaxSubmit' method='post' action='<?= Url::to(['item-stocks/create']) ?>'>
	<div class="modal-body">
		<div class="form-group">
			<label>Articulo</label>
			<input type='text' class='form-control input-sm' value='<?= $model->item->name ?>' disabled>
			<?= Html::activeInput('hidden',$model,'itemID') ?>
		</div>					
		<div class="row">
			<div class="form-group col-md-6">
				<label>Cantidad (puede usar negativos)</label>
				<?= Html::activeInput('text',$model,'quantity',['class'=>'form-control input-sm number required']) ?>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type='submit' class='btn btn-primary'>Agregar</button>
	</div>
</form>
