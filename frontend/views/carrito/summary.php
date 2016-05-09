<?php 
use yii\helpers\Url;
use yii\helpers\Html;
 ?>
<h3>Resumen de Compra</h3>
 <div class='loading-div text-center'>
    <br>
    <i class='fa fa-refresh fa-spin fa-4x'></i>
    <br>
 </div>
<div id="Productos">
	<div class="Items"><?= $totalProducts ?> <strong><?= $totalProducts==1?"Producto":"Productos"; ?></strong></div> 
    <div class="LinkDetalleCarrito"><a href="#test" data-toggle='modal'>Ver los detalles de mi compra</a></div>
</div>
<div id="SubTotales">
	<div class="Precios">
    	<p>Subtotal <span>MX $<?= number_format($subtotal,2) ?></span></p>
        <?php if (isset($shippingTotal)): ?>
        <p>Envío <span>MX $<?= number_format($shippingTotal,2) ?></span></p>
        <?php endif ?>
        <p>IVA <span>MX $<?= number_format($iva,2) ?></span></p>
    </div>
    <div class="Total">
    	<p>TOTAL <span>MX $<?= number_format($total,2) ?></span></p>
    </div>
</div>
