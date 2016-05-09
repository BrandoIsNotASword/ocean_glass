<?php 
use common\models\GarmentType;
use common\models\Item;
use common\models\Color;
use yii\helpers\Url;
 ?>
	<h2>
		Articulos
		<a  href='<?= Url::toRoute('items/new') ?>' class='btn btn-primary btn-sm' data-toggle='modalDinamic'>Nuevo Articulo</a>
	</h2>
	<hr>
	<table data-ajax-url='<?= Url::toRoute('items/listing') ?>' class='hasDataTableAjax table table-condensed table-bordered table-hover table-striped'>
		<thead>
			<tr>
				<th>
					<input type='text' placeholder='Nombre' class='form-control input-sm'>
				</th>
				<th>
					<input type='text' placeholder='Precio' class='form-control input-sm'>
				</th>
				<th class='no-sorting'>
					<select class='form-control input-sm'>
						<option value=''>Estado</option>
							<option value='<?= Item::StatusActive ?>'>Activo</option>
							<option value='<?= Item::StatusInactive ?>'>Inactivo</option>
					</select>
				</th>
				<th style='width:20%'>Stock</th>
				<th class='no-sorting'>Imagen</th>
				<th class='no-sorting'>Acciones</th>
			</tr>
		</thead>
	</table>