<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use common\models\Sale;
 ?>
 <div style="width:80%;margin:0 auto">
	<h2>Hola <?= Html::encode($sale->clientName) ?>!</h2>
	<h3>
		Muchas gracias por tu compra, esta es la confirmación de tu pago. Nos comunicaremos para hacerte llegar tu compra.
		<br>
		!Muchas Gracias!			
	</h3>
<h3><strong>Venta:</strong> <?= $sale->id ?></h3>
<hr>
<h3>Datos del Cliente</h3>
<table style="width:100%">
	<tbody>
	<tr>
		<td>
			<strong>Nombre:</strong><br>
			<?= Html::encode($sale->clientName) ?>
			<br>
		</td>
		<td>
			<strong>Email:</strong><br>
			<?= Html::encode($sale->clientEmail) ?>
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			<strong>Fecha:</strong><br>
			<?= date('d/m/Y g:i:s A',strtotime($sale->insertDate)) ?>
			<br>
		</td>
		<td>
			<strong>Estado del pedido:</strong><br>
			<?= strtoupper($sale->getStatusArray()[$sale->status]) ?>
			<br>
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			<strong>Metodo de pago:</strong><br>
			PAYPAL
			<br>
		</td>
		<td></td>
		<td></td>
	</tr>
</tbody>
</table>
<br>
<hr>
<h3>Detalles de la venta:</h3>

<table style="width:100%" order="1" cellpadding="5">
	<tbody>
		<tr style="background-color:#333333;color:#fff">
			<td style="text-align:center">Articulo</td>
			<td style="text-align:center">Cantidad</td>
			<td style="text-align:center">Total</td>
		</tr>

		<?php $total = 0; ?>
		<?php foreach($sale->saleItems as $i): ?>
		<tr>
			<td style="text-align:center"><?= $i->item->name ?></td>
			<td style="text-align:center"><?= $i->quantity ?></td>
			<td style="text-align:center">$<?= number_format($i->total,2) ?> MXN</td>
			<?php $total+=$i->total ?>
		</tr>
		<?php endforeach ?>
		<tr class="no-border">
			<td colspan="3"></td>
			<td style="text-align:right"><strong>Total:</strong></td>
			<td style="text-align:center"><strong>$<?= number_format($sale->total,2) ?> MXN</strong></td>
		</tr>
	</tbody>
</table>
</div>