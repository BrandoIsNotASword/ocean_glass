<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Content;
?>
 <?php $obj = new Content();?>
<div class="modal-header myheader">
	  <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3 class='modal-title'>Nueva Sección</h3>
</div>
	<form method='post' class='validateForm ajaxSubmit' enctype='multipart/form-data' action='<?= Url::to(['content/create']) ?>'>
<div class="modal-body">
		<div class="form-group">
			<label><b>Id</b></label>
			<?= Html::activeInput('text',$obj,'id',['class'=>'form-control input-sm required']);?>
		</div>
		<div class="form-group">
			<label><b>Titulo de la sección</b></label>
			<?= Html::activeInput('text',$obj,'title',['class'=>'form-control input-sm required']);?>
		</div>
		<div class="form-group">
			<label><b>Banner</b></label>
			<input class='imgField' type="file" name='banner' accept='.jpeg,.png,.jpg'>
		</div>
		<div class="form-group">
			<label><b>Contenido</b></label>
			<?= Html::activeTextArea($obj,'bodyText',['class'=>'content-section-new']);?>
		</div>
</div>
<div class="modal-footer text-right">
	<button class="btn btn-default" type='button' data-dismiss='modal'>Cerrar</button>
	<button class="forSection btn btn-primary" type='submit'>Guardar</button>
</div>
	</form>
<script>
	$(".content-section-new").trumbowyg({
		btnsDef: {
		    // Create a new dropdown
		    image: {
		        dropdown: ['insertImage', 'base64'],
		        ico: 'insertImage',
		        langs:'es',
		    }
		},
	  	btns: ['viewHTML',
	    '|', 'formatting',
	    '|', 'btnGrp-design',
	    '|', 'link',
	    '|', 'image',
	    '|', 'btnGrp-justify',
	    '|', 'btnGrp-lists',
	    '|', 'horizontalRule'],
		lang:'es',
	    fullscreenable: true,
	    removeformatPasted: true
	});

	// $('.forSection').on('click',function(e){

	// 	e.preventDefault();
	// 	var end_url = $('#formContentNew').attr('data-url');
	// 	var section_title = $('.content-new').val();
	// 	var section_text = $('#content-section-new').trumbowyg('html');
	// 	alert(section_text);
	// 	$.ajax({
	// 		type: "post",
	// 		url: end_url,
	// 		data: {
	// 			title: section_title,
	// 			text: section_text
	// 		},
	// 		success: function(result){
	// 			console.log(result);
	// 		}
	// 	});

	// });

</script>
