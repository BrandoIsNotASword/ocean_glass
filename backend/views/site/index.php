<?php
/* @var $this yii\web\View */

$this->title = 'La Gran Nación - Admin';
?>
<h1>Pedidos</h1>
<hr>
<ul class='nav nav-tabs dinamicTab'>
    <li class='active'><a href="#" data-toggle='tab'>Pendientes</a></li>
    <li><a href="#" data-toggle='tab'>Enviados</a></li>
    <li><a href="#" data-toggle='tab'>Cancelados</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active">
        <table class='hasDataTable table table-condensed table-bordered'>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Articulo</th>
                    <th>Monto</th>
                    <th>Metodo de pago</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
            <?php for($i=0;$i<3;$i++): ?>
                <tr>
                    <td>Daniel Pelcastre</td>
                    <td>10/May/2015 10:12 hrss</td>
                    <td>Camisa</td>
                    <td>$200 MXN</td>
                    <td>PayPal</td>
                    <td class='text-center'>
                        <a href="#" class='btn btn-info'><i class='icon-eye-open'></i></a>
                    </td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </div>
    <div class="tab-pane">
        <table class='hasDataTable table table-condensed table-bordered'>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Articulo</th>
                    <th>Monto</th>
                    <th>Metodo de pago</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
            <?php for($i=0;$i<3;$i++): ?>
                <tr>
                    <td>Daniel Pelcastre</td>
                    <td>10/May/2015 10:12 hrss</td>
                    <td>Camisa</td>
                    <td>$200 MXN</td>
                    <td>PayPal</td>
                    <td class='text-center'>
                        <a href="#" class='btn btn-info'><i class='icon-eye-open'></i></a>
                    </td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </div>
    <div class="tab-pane">
        <table class='hasDataTable table table-condensed table-bordered'>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Articulo</th>
                    <th>Monto</th>
                    <th>Metodo de pago</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
            <?php for($i=0;$i<3;$i++): ?>
                <tr>
                    <td>Daniel Pelcastre</td>
                    <td>10/May/2015 10:12 hrss</td>
                    <td>Camisa</td>
                    <td>$200 MXN</td>
                    <td>PayPal</td>
                    <td class='text-center'>
                        <a href="#" class='btn btn-info'><i class='icon-eye-open'></i></a>
                    </td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    </div>
</div>

