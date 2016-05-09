<?php 
use yii\helpers\Url;
?>
<div class="modal-header myheader">
		<button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class='modal-title'>Agrega un color</h4>
</div>
<form class='validateForm ajaxSubmit' method='post' action='<?= Url::to(['colors/update','id'=>$color->id]) ?>'>
	<div class="modal-body">
		<div class="row">
		<div class="col-md-4 form-group">
			<label>Nombre:</label>
			<input type='text' value='<?= $color->name ?>' name='name' class='form-control input-sm required'>
		</div>					
		</div>
<!-- 		<div class="form-group">
			<input style='cursor:pointer' value='<?= $color->hex ?>' type='color' name='color' class='form-control input-sm'>
		</div> -->
	</div>
<div class="modal-footer">
	<button type='submit' class='btn btn-primary'>Guardar</button>
</div>
</form>
