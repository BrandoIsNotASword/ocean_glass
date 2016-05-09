<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use common\models\Sale;
 ?>
<div class="modal-header">
	<h3 class="modal-title">Venta: <?= $sale->id ?></h3>
</div>
<div class="modal-body">
	<h4>Datos del cliente</h4>
	<div class="row">
		<div class="col-md-4">
			<p class='no-margin'><strong>Nombre:</strong></p>
			<p><?= Html::encode($sale->clientName) ?></p>
		</div>
		<div class="col-md-4">
			<p class='no-margin'><strong>Email:</strong></p>
			<p><?= Html::encode($sale->clientEmail) ?></p>
		</div>
		<div class="col-md-4">
			<p class='no-margin'><strong>Fecha:</strong></p>
			<p class='text-uppercase'><?= date('d/m/Y g:i:s A',strtotime($sale->insertDate)) ?></p>
		</div>
		<div class="col-md-4">
			<p class='no-margin'><strong>Estado del pedido:</strong></p>
			<p class='text-uppercase'><?= $sale->getStatusArray()[$sale->status] ?></p>
		</div>
		<div class="col-md-4">
			<p class='no-margin'><strong>Metodo de pago:</strong></p>
			<p class='text-uppercase'>PAYPAL</p>
		</div>
	</div>
	<div class='text-right'>
		<?php if($sale->status == Sale::StatusPending): ?>
			<a href='<?= Url::to(['sales/pay','id'=>$sale->id]) ?>' class='btn btn-success btn-sm show-warning ajaxLink'>Pagar</a>
		<?php endif ?>
		<?php if (in_array($sale->status,[Sale::StatusPending,Sale::StatusPayed])): ?>
			<a href='<?= Url::to(['sales/cancel','id'=>$sale->id]) ?>' class='ajaxLink show-warning btn btn-danger btn-sm'>Cancelar pedido</a>
		<?php endif ?>
		<?php if ($sale->status == Sale::StatusPayed): ?>
			<a href='<?= Url::to(['sales/finished','id'=>$sale->id]) ?>' class='ajaxLink show-warning btn btn-danger btn-sm'>Finalizar pedido</a>
		<?php endif ?>
	</div>
	<hr>
	<h3>Detalles de la venta:</h3>
	<table class='table table-condensed table-striped'>
		<thead>
			<tr>
				<th class='text-center'>Articulo</th>
				<th class='text-center'>Cantidad</th>
				<th class='text-center'>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php $total = 0; ?>
			<?php foreach ($sale->saleItems as $i): ?>
			<tr>
				<td class='text-center'><a data-toggle='modalDinamic' href="<?= Url::to(['items/edit','id'=>$i->itemID]) ?>"><?= $i->item->name ?></a></td>
				<td class='text-center'><?= $i->quantity ?></td>
				<td class='text-center'>$<?= number_format($i->total,2) ?> MXN</td>
				<?php $total+=$i->total ?>
			</tr>
			<?php endforeach ?>
			<tr class='no-border'>
				<td ></td>
				<td class='text-right'><strong>Total:</strong></td>
				<td class='text-center'><strong>$<?= number_format($sale->total,2) ?> MXN</strong></td>
			</tr>
		</tbody>
	</table>
	<hr>
	<h3>Dirección de Envio</h3>
	<address>
		<?= $sale->clientAddress ?>
	</address>
</div>
<div class="modal-footer">
	<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
</div>