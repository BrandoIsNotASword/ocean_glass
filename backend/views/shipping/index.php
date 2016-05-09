<?php 
use yii\helpers\Url;
 ?>
	<h2>
		Metodos de Envio
		<a  href='<?= Url::toRoute('shipping/new') ?>' class='btn btn-primary btn-sm' data-toggle='modalDinamic'>Nuevo</a>
	</h2>
	<hr>
	<table data-ajax-url='<?= Url::toRoute('shipping/listing') ?>' class='hasDataTableAjax table table-condensed table-bordered table-responsive table-hover'>
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Precio</th>
				<th>Compañia</th>
				<th>Estatus</th>
				<th>Descripcion</th>
				<th>Acciones</th>
			</tr>
		</thead>
	</table>
