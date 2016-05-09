
<?php 
	use yii\helpers\Url;
	use yii\helpers\Html;
 ?>
 <div class="row product-background" style='margin-top:30px;padding-bottom:80px'>
 	<div class="col-md-6 col-md-offset-2" style='overflow:hidden'>
 		<div style='width:300px;float:left' style="margin-bottom:15px;">
 			<div class="col-xs-12 product-detail separate-product">
 				<div style='width:266px;height:274px;position:relative'>
	        		<?= Html::img(Yii::$app->controller->getUrlImg($item->getPrincipalImg()),['class'=>'principal-image','style'=>'max-width:100%;max-height:100%;position:absolute;top:0;bottom:0;right:0;left:0;margin:auto'])?>
 				</div>
 			</div>
 			<?php foreach ($item->images as $img): ?>
	 			<div class="col-xs-6 col-md-3 ">
	 			   <a href="#" class="thumbnail ">
	 			     <?= Html::img(Yii::$app->controller->getUrlImg($img),['class'=>'miniature','style'=>'background-color:white;min-height:50px;height:50px;width:auto;'])?>
	 			   </a>
	 			 </div>
 			<?php endforeach ?> 			
 		</div>
 		<div class="col-md-4">
 			        <div class="ProductName separate-product-price"><h1><?= $item->name ?></h1></div>
 				        <div class="Stars">
 				        	<span class="StarActive">*</span>
 				            <span class="StarInactive">*</span>
 				            <span class="StarInactive">*</span>
 				            <span class="StarInactive">*</span>
 				            <span class="StarInactive">*</span>
 				        </div><br>	    	
 				        <div class="ProductDescr"><?= $item->description ?></div>
 				        <br>
 				        <div style='color:#b83a4d;opacity:.5' class="ProductDescr"><strong>Articulo Disponible en Stock</strong></div><br><br>
 				        <div  class="ProductDescr"><span><i class="fa fa-heart"></i></span> Agregar a la lista de deseos</div><br>
 						<!-- <div class="col-xs-12"> -->
 								<?php Html::img('',['height'=>'50'])?>
 						<!-- </div> -->
 						<div class="col-xs-12">
 							<?=Html::img('@web/images/icons/01_twitter.png')?>
 							<?=Html::img('@web/images/icons/02_facebook.png')?>
 							<?=Html::img('@web/images/icons/14_google+.png')?>
 							<?=Html::img('@web/images/icons/13_pinterest.png')?>
 						</div>
 		</div>
 	</div>
 		<div class="col-md-3">
 			<?php 
                $promoAux = $item->getBestPromotion();
                 ?>
                 <?php if(isset($promoAux)): ?>
 					<div class="ProductPrice separate-product-price text-right h2">$<?= number_format($promoAux->applyPromotion($item->price),2) ?>  <span class="PromoPrice">$<?= number_format($item->price,2) ?></span></div><br>
               <?php else: ?>
 					<div class="ProductPrice separate-product-price text-right h2">$<?= number_format($item->price,2) ?></div><br>
                 <?php endif ?>
 			<div class='row'>
 				<div class="col-xs-4">
 					<label>Cantidad</label>
 				</div>
 				<div class="col-xs-8">
 					<button class="btn btn-default">1</button>
 					<button class="btn btn-default"><i class='fa fa-minus'></i></button>
 					<button class="btn btn-default"><i class='fa fa-plus'></i></button>
 				</div>
 			</div>
 			<button style='margin-top:20px' class="addbutton btn btn-lg btn-primary btn-block">AÑADIR A CARRITO</button>
 		</div>
 </div>
 