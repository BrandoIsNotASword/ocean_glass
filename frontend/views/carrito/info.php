<?php 
use yii\helpers\Url;
use yii\helpers\Html;
?>
 <br>
 <br>
<section id='payment'>
    <form id='paymentForm' onsubmit="return false;" autocomplete='on' method='post' action='/carrito/makepayment'>
    <div class="row">
        <div class="col-md-9">
                <h3>Ingresar datos para la compra</h3>
                <p class='cartError text-center' style='display:none'></p>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Nombre*</label>
                        <input type='text' class='form-control input-sm' name='clientName' required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Correo Electrónico*</label>
                        <input type='email' class='form-control input-sm' name='clientEmail' required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Dirección*</label>
                        <textarea class='form-control input-sm' name='clientAddress' required></textarea>
                    </div>
                </div>
                <?php $sale = new \common\models\Sale; ?>
        </div>
        <div class="col-md-3">
            <div class="well">
                <h3 class='text-center'>Resumen</h3>
                <dl class='dl-horizontal'>
                    <dt>Artículos:</dt>
                    <dd><?= $totalItems ?></dd>
                    <dt>Total:</dt>
                    <dd>$<?= number_format($total,2) ?> MXN</dd>
                </dl>
                <div class="form-group text-center">
                    <button type='submit' class='btn btn-primary text-uppercase' data-loading-text="<i class='fa fa-refresh fa-spin'></i>" data-success-text="<i class='fa fa-check'></i>"><strong>Pagar con PayPal</strong> <i class='fa fa-paypal'></i></button>
                </div>
            </div>
        </div>
    </div>
            </form>
</section>