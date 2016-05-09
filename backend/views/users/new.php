<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\User;
 ?>
<div class="modal-header myheader">
	<button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3 class='modal-title'>Nuevo Usuario</h3>
</div>
<?php $g = new User; ?>
	<form method='post' enctype='multipart/form-data' class='ajaxSubmit validateForm' action='<?= Url::toRoute('users/create') ?>'>
<div class="modal-body">
	<div class="row">
		<div class="form-group col-md-6">
			<label>Nombre de Usuario</label>
			<?= Html::activeInput('text',$g,'username',['class'=>'form-control input-sm required']); ?>
		</div>
		<div class="form-group col-md-6">
			<label>Nivel de Acceso</label>
			<?= Html::activeDropDownList($g,'accessLevel',$g->getAccessLevelArray(),['class'=>'form-control input-sm required']); ?>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<label>Nombres</label>
			<?= Html::activeInput('text',$g,'firstName',['class'=>'form-control input-sm required']); ?>
		</div>
		<div class="form-group col-md-6">
			<label>Apellidos</label>
			<?= Html::activeInput('text',$g,'lastName',['class'=>'form-control input-sm required']); ?>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<label>Correo Electronico</label>
			<?= Html::activeInput('text',$g,'email',['class'=>'form-control input-sm required']); ?>
		</div>		
		<div class="form-group col-md-6">
			<label>Estatus</label>
			<?= Html::activeDropDownList($g,'status',$g->getStatusArray(),['class'=>'form-control input-sm required']); ?>
		</div>		
	</div>
	<div class="form-group">
		<label>Contraseña</label>
		<?= Html::activeInput('password',$g,'password_hash',['class'=>'form-control input-sm required']); ?>
	</div>
	<div class="form-group">
		<label>Repetir Contraseña</label>
		<?= Html::activeInput('password',$g,'comparePassword',['class'=>'form-control input-sm required']); ?>
	</div>
</div>
<div class="modal-footer text-right">
	<button type='button' data-dismiss='modal' class='btn btn-default'>Cancelar</button>
	<button type='submit' class='btn btn-primary'>Guardar</button>
</div>
</form>