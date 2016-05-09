<?php 
use common\models\User;
use yii\helpers\Url;
 ?>
<h2>Usuarios
	<a  href='<?= Url::toRoute('users/new') ?>' class='btn btn-primary btn-sm' data-toggle='modalDinamic'>Nuevo Usuario</a>
</h2>
<hr>
<table data-ajax-url='<?= Url::toRoute('users/listing') ?>' class='hasDataTableAjax table table-condensed table-bordered'>
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Estatus</th>
            <th>Nivel de Acceso</th>
            <th>Acciones</th>
        </tr>
    </thead>
</table>