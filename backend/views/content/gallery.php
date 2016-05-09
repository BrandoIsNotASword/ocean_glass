<?php 
use yii\helpers\Url;
use yii\helpers\Html;
 ?>
	<div class="modal-header myheader">
	  <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">&times;</button>
	  <h3 class='modal-title'>Imágenes</h3>
	</div>
 <div class="modal-body text-center">
 	<div class="row" id='testsort' data-url='<?= Url::to(['content/updatepositions','id'=>$content->id]) ?>'>
 		<?php foreach ($content->images as $i): ?>
 		<div class="col-md-3 text-center" data-img='<?= $i->id ?>' style='margin-bottom:10px;'>
			<img class='' style='border:1px solid grey' src="<?= Yii::$app->controller->getUrlImg($i,2) ?>" data-zoom-image='<?= Yii::$app->controller->getUrlImg($i) ?>'>
			<div style='' class="text-center">
				<a href='<?= Url::to(['images/delete','id'=>$i->id]) ?>' data-loading-text="<i class='icon-refresh icon-spin'></i>" class='ajaxLink show-warning btn btn-danger btn-xs'><i class='icon-trash'></i></a>
				<button type='button' class='btn btn-info btn-xs btn-move'><i class='icon-fullscreen'></i></button>
			</div>
 		</div>
 		<?php endforeach ?>
 	</div>
		<!-- <div style='margin-top:10px'> -->
		<!-- </div> -->
 	<hr>
 	<h3>Agregar Imagenes</h3>
 	<form method='post' class='validateForm ajaxSubmit' action='<?= Url::toRoute(['content/addimages','id'=>$content->id]) ?>' enctype='multipart/form-data'>
		<input  type='file' name='images[]' class='imgField required' accept='.jpeg,.png,.jpg' multiple> 
		<br>
		<button type='submit' class='btn btn-success'>Agregar</button>
 	</form>
 </div>
 <script>
 $("#testsort").sortable({
 	// items:".col-md-3",
 	cancel:"a",
 	update:function(e,ui){
 		var positions = {};
 		$(this).find('.col-md-3').each(function(index,value){
 			positions[$(value).data('img')]=index;
 		});
 		$.post($(this).data('url'),{positions:positions});
 	}
 });
 </script>