<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Item;
 ?>
<h2>
	Reportes
</h2>
<div class="row">
	<div class="col-md-6">
		<form action='<?= Url::toRoute('reports/export') ?>' method='post' class='well'>
			<h3 class='modal-title'>Reporte de Ventas</h3>
			<div class="row">
				<div class="col-md-4 form-group">
					<label>De:</label>
					<input name='start' type='text' value='<?= date('Y-m-d') ?>' class='calendarField form-control input-sm required'>
				</div>
				<div class="col-md-4 form-group">
					<label>Hasta:</label>
					<input name='end' type='text' value='<?= date('Y-m-d',strtotime('+1 day')) ?>' class='calendarField form-control input-sm required'>
				</div>
				<div class="col-md-4 form-group text-center">
					<button type='submit' class='btn btn-primary'>Exportar</button>
				</div>
			</div>
		</form>
	</div>
</div>
