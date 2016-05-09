<?php 
use yii\helpers\Url;
use yii\helpers\Html;
 ?>
 <div class="modal-header myheader">
 	<button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">&times;</button>
 	<h3 class='modal-title'>Movimientos en inventario - <?= $item->name ?></h3>
 </div>
<div class="modal-body">
	<h3 class='modal-title'>STOCK: <strong><?= $item->stock ?></strong></h3>
	<a href='<?= Url::to(['item-stocks/new','item'=>$item->id]) ?>' data-toggle='modalDinamic' class='btn btn-info pull-right'>Agregar o eliminar inventario</a>
	<table data-ajax-url='<?= Url::to(['item-stocks/listing-by-item','item'=>$item->id]) ?>' class='hasDataTableAjax table table-condensed table-bordered table-hover table-striped'>
		<thead>
			<tr>
				<th>Fecha</th>
				<th>Cantidad</th>
				<th>Notas</th>
			</tr>
		</thead>
	</table>
</div>