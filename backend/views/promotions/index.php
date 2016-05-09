<?php 
use yii\helpers\Url;
use common\models\Promotion;
?>
<h2>
	Promociones
	<a  href='<?= Url::toRoute('promotions/new') ?>' class='btn btn-primary btn-sm' data-modal-width='700' data-toggle='modalDinamic'>Nueva Promocion</a>
</h2>
<hr>
<table data-ajax-url='<?= Url::toRoute('promotions/listing') ?>' class='table hasDataTableAjax table-condensed table-bordered table-hover table-striped'>
	<thead>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>De - Hasta</th>
			<th>Usos</th>
			<th style='width:30%'>Descripcion</th>
			<th>Acciones</th>
		</tr>
	</thead>
</table>