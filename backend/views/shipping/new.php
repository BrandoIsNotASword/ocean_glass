<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\ShippingMethod;
 ?>
<div class="modal-header myheader">
	<button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3 class='modal-title'>Nueva Forma de Envio</h3>
</div>
<?php $sm = new ShippingMethod;
$sm->order=1;
?>
	<form method='post' class='ajaxSubmit validateForm' action='<?= Url::toRoute('shipping/create') ?>'>
<div class="modal-body">
	<div class="row">
		<div class="col-md-6 form-group">
			<label>Nombre</label>
			<?= Html::activeInput('text',$sm,'name',['class'=>'form-control input-sm required']); ?>
		</div>		
		<div class="col-md-6 form-group">
			<label>Compañia</label>
			<?= Html::activeDropDownList($sm,'shippingCompanyID',$sm->getShippingCompanies(),['class'=>'form-control input-sm']) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 form-group">
			<label>Precio</label>
			<div class="input-group">
				<span class="input-group-addon">$</span>
				<?= Html::activeInput('text',$sm,'price',['class'=>'form-control input-sm numberField required']); ?>
			</div>
		</div>				
		<div class="col-md-6 form-group">
			<label>Estado</label>
			<?= Html::activeDropDownList($sm,'status',$sm->getStatusArray(),['class'=>'form-control input-sm']) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 form-group">
			<label>Orden</label>
			<?= Html::activeInput('text',$sm,'order',['class'=>'form-control input-sm required']); ?>
		</div>						
	</div>
	<div class="form-group">
		<label>Descripcion</label>
		<?= Html::activeTextArea($sm,'description',['class'=>'form-control input-sm']) ?>
	</div>
</div>
<div class="modal-footer text-right">
	<button type='button' data-dismiss='modal' class='btn btn-default'>Cancelar</button>
	<button type='submit' class='btn btn-primary'>Guardar</button>
</div>
	</form>