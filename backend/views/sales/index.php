<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use common\models\Sale;
$this->title = 'Ventas | Ocean Glass';
?>
<h2>Ventas</h2>
<hr>
<ul class='nav nav-tabs dinamicTab'>
    <li class='active'><a href="#" data-toggle='tab'>Pendientes</a></li>
    <li><a href="#" data-toggle='tab'>Cancelados</a></li>
    <li><a href="#" data-toggle='tab'>Pendientes de pago</a></li>
    <li><a href="#" data-toggle='tab'>Terminados</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active">
        <table data-ordering='false' data-ajax-url='<?= Url::to(['sales/listing','list'=>'pending']) ?>' class='hasDataTableAjax table table-condensed table-bordered'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha de Ingreso</th>
                    <th>Total</th>
                    <th>Detalles</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="tab-pane">
       <table data-ordering='false' data-ajax-url='<?= Url::to(['sales/listing','list'=>'cancelled']) ?>' class='hasDataTableAjax table table-condensed table-bordered'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha de ingreso</th>
                    <th>Total</th>
                    <th>Detalles</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="tab-pane">
       <table data-ordering='false' data-ajax-url='<?= Url::to(['sales/listing','list'=>'nopayment']) ?>' class='hasDataTableAjax table table-condensed table-bordered'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha de ingreso</th>
                    <th>Total</th>
                    <th>Detalles</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="tab-pane">
       <table data-ordering='false' data-ajax-url='<?= Url::to(['sales/listing','list'=>'delivered']) ?>' class='hasDataTableAjax table table-condensed table-bordered'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha de ingreso</th>
                    <th>Total</th>
                    <th>Detalles</th>
                </tr>
            </thead>
        </table>
    </div>
</div>