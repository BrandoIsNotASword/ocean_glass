<?php 
use yii\helpers\Html;
use yii\helpers\Url;
 ?>
<h2>
	Configuraciones
</h2>
<hr>
<div class="row">
	<div class="col-md-5">
		<div class="well">
			<form class='validateForm ajaxSubmit' method='post' action='<?= Url::toRoute('settings/update') ?>'>
				<div class="form-group">
					<label>Correo Principal</label>
					<input type='text' name='settings[principalEmail]' value='<?= isset($settings['principalEmail'])?$settings['principalEmail']:'' ?>' class='form-control input-sm'>
				</div>
				<hr>
				<h4 class='text-center'>Credenciales de PayPal </h4>
				<div class="form-group">
					<label>Usuario de Paypal:</label>
					<input type='text' name='settings[paypalAccount]' value='<?= isset($settings['paypalAccount'])?$settings['paypalAccount']:'' ?>' class='form-control input-sm'>
				</div>
				<div class="form-group">
					<label>Usuario:</label>
					<input type='text' name='settings[paypalUser]' value='<?= isset($settings['paypalUser'])?$settings['paypalUser']:'' ?>' class='form-control input-sm'>
				</div>
				<div class="form-group">
					<label>Contraseña:</label>
					<input type='text' name='settings[paypalPass]' value='<?= isset($settings['paypalPass'])?$settings['paypalPass']:'' ?>' class='form-control input-sm'>
				</div>
				<div class="form-group">
					<label>Firma:</label>
					<input type='text' name='settings[paypalSign]' value='<?= isset($settings['paypalSign'])?$settings['paypalSign']:'' ?>' class='form-control input-sm'>
				</div>
				<div class="form-group">
					<label>ID de aplicacion:</label>
					<input type='text' name='settings[paypalApp]' value='<?= isset($settings['paypalApp'])?$settings['paypalApp']:'' ?>' class='form-control input-sm'>
				</div>
				<div class="form-group">
					<label>Ambiente:</label>
					<select class='form-control input-sm' name='settings[paypalEnv]'>
						<option <?= isset($settings['paypalEnv']) && $settings['paypalEnv']=='live'?"selected='selected'":''; ?> value='live'>Producción</option>
						<option <?= isset($settings['paypalEnv']) && $settings['paypalEnv']=='sandbox'?"selected='selected'":''; ?> value='sandbox'>Pruebas</option>
					</select>
				</div>
				<div class="form-group text-right">
					<button type='submit' class='btn btn-primary'>Actualizar</button>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-7">
		<div class="well">
			<form class='validateForm ajaxSubmit' method='post' action='<?= Url::toRoute('settings/update') ?>'>
				<h4>Información de Ocean Glass</h4>
				<div class="row">
					<div class="col-md-4 form-group">
						<label>Email</label>
						<input class='form-control input-sm' type='text'name='settings[adminEmail]' value='<?= isset($settings['adminEmail'])?$settings['adminEmail']:'' ?>'>
					</div>
					<div class="col-md-4 form-group">
						<label>Telefono</label>
						<input class='form-control input-sm' type='text'name='settings[phone]' value='<?= isset($settings['phone'])?$settings['phone']:'' ?>'>
					</div>
				</div>
				<div class="form-group">
					<label>Dirección:</label>
					<textarea rows='4' class='form-control input-sm' name='settings[address]'><?= isset($settings['address'])?$settings['address']:'' ?></textarea>
				</div>
				<div class="form-group text-right">
					<button type='submit' class='btn btn-primary'>Actualizar</button>
				</div>
			</form>
		</div>
	</div>
</div>