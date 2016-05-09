<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\User;
?>
<div class="modal-header myheader">
	<button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3 class='modal-title'>Nuevo Usuario</h3>
</div>
	<form method='post' enctype='multipart/form-data' class='ajaxSubmit validateForm' action='<?= Url::to(['users/update','id'=>$user->id]) ?>'>
<div class="modal-body">
	<div class="row">
		<div class="form-group col-md-6">
			<label>Nombre de Usuario</label>
			<?= Html::activeInput('text',$user,'username',['class'=>'form-control input-sm required']); ?>
		</div>
		<div class="form-group col-md-6">
			<label>Nivel de Acceso</label>
			<?= Html::activeDropDownList($user,'accessLevel',$user->getAccessLevelArray(),['class'=>'form-control input-sm required']); ?>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<label>Nombres</label>
			<?= Html::activeInput('text',$user,'firstName',['class'=>'form-control input-sm required']); ?>
		</div>
		<div class="form-group col-md-6">
			<label>Apellidos</label>
			<?= Html::activeInput('text',$user,'lastName',['class'=>'form-control input-sm required']); ?>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<label>Correo Electronico</label>
			<?= Html::activeInput('text',$user,'email',['class'=>'form-control input-sm required']); ?>
		</div>		
		<div class="form-group col-md-6">
			<label>Estatus</label>
			<?= Html::activeDropDownList($user,'status',$user->getStatusArray(),['class'=>'form-control input-sm required']); ?>
		</div>		
	</div>
	<div class="form-group">
		<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#user-change-pass'>Cambiar Contraseña</button>
	</div>
</div>
<div class="modal-footer text-right">
	<button type='button' data-dismiss='modal' class='btn btn-default'>Cancelar</button>
	<button type='submit' class='btn btn-primary'>Guardar</button>
</div>
	</form>

<div class="modal fade" id='user-change-pass'>
	<div class="modal-header">
		<h3 class="modal-title">Cambio de Contraseña</h3>
	</div>
		<form method='post' class='ajaxSubmit validateForm' action='<?= Url::to(['users/updatepass','id'=>$user->id]) ?>'>
	<div class="modal-body">
		<?php $aux = new User; ?>
			<div class="form-group">
				<label>Contraseña</label>
				<?= Html::activeInput('password',$aux,'password_hash',['class'=>'form-control input-sm required']); ?>
			</div>
			<div class="form-group">
				<label>Repetir Contraseña</label>
				<?= Html::activeInput('password',$aux,'comparePassword',['class'=>'form-control input-sm required']); ?>
			</div>
	</div>
	<div class="modal-footer">
		<button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>
		<button type='submit' class='btn btn-primary'>Actualizar</button>
	</div>
		</form>
</div>