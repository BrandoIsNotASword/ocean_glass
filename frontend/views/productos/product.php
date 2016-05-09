<?php 
	use yii\helpers\Url;
	use yii\helpers\Html;
	use common\models\Size;
	use Yii;
// use common\models\ItemColor;
$this->title = $item->name." | La Gran Nación";
?>
<?php 
$exhausted = $item->inventory<=0;
Yii::$app->user->setReturnUrl(Yii::$app->request->getUrl());
$colors = $item->colors;
 ?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55bd69935eba19c9" async="async"></script>

<section id='productDetail' class='white'>
	<div class="CenterLayout">
		<div class="row">
			<div class="col-md-6">
				<div class='img-content'>
					<img alt='<?= $item->name ?>' src="<?= Yii::$app->controller->getUrlImg($item->getPrincipalImg()) ?>" id='principal-product-image'>
				</div>
				<p id='colorName' class='text-center'></p>
				<div id="miniatures" style='overflow:hidden'>
					<?php foreach ($item->images as $img): ?>
						<?php $color=$item->getColorRelatedToImage($img) ?>
						<a href="#" class="thumbnail" data-color-id='<?= isset($color)?$color->id:'' ?>' data-color-name='<?= isset($color)?$color->color->name:'' ?>' data-image='<?= Yii::$app->controller->getUrlImg($img) ?>' >
							<img alt='<?= $item->name ?>' src="<?= Yii::$app->controller->getUrlImg($img,2) ?>" style='background-color:white' id='principal-product-image'>
		 			   </a>													
					<?php endforeach ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-6">
				 		<div class="ProductName"><h1><?= $item->name ?></h1></div>
 				        <!-- <div class="Stars"> -->
 				        	<?php $stars=$item->score ?>
		                    <?php for($s=0;$s<5;$s++): ?>
			            	  <!-- <span class="<?= $s+1<=$stars?"StarActive":"StarInactive" ?>">*</span> -->
		                    <?php endfor; ?>
 				        <!-- </div><br>	    	 -->
 				        <div class="ProductDescr"><?= $item->description ?></div>
 				        <br>
 				        <div style='color:#b83a4d;opacity:.5' class="ProductDescr"><strong>
 				        	<?php if ($exhausted): ?>
 				        		Articulo Agotado
 				        	<?php else: ?>
 				        		Articulo Disponible en Stock
 				        	<?php endif ?>

 				        </strong></div><br><br>
 						<div class="col-md-12">
							<div class="addthis_sharing_toolbox"></div>
 						</div>
					</div>
					<div class="col-md-6">
						<?php 
			               $promoAux = $item->getBestPromotion();
			                ?>
			                <?php if(isset($promoAux)): ?>
								<div class="ProductPrice separate-product-price text-right h2">$<?= number_format($promoAux->applyPromotion($item->price),2) ?>  <span class="PromoPrice">$<?= number_format($item->price,2) ?> MXN</span></div><br>
			              <?php else: ?>
								<div class="ProductPrice separate-product-price text-right h2">$<?= number_format($item->price,2) ?> MXN</div><br>
			                <?php endif ?>
			            <form id='add-product-form' action='<?= Url::toRoute('carrito/additem') ?>' data-cart='<?= Url::toRoute('carrito/') ?>' data-k='<?= $item->id ?>'>
						<div class='row'>
							<input id='quantity-real' value='1' type='hidden'>
							<div class="col-md-4">
								<label>Cantidad:</label>
							</div>
							<div class="col-md-8 text-right">
								<button type='button' class="no-radius btn btn-default btn-sm quantity-product">1</button>
								<button type='button' class="no-radius btn btn-default quantity-product-minus btn-sm"><i class='fa fa-minus'></i></button>
								<button type='button' class="no-radius btn btn-default quantity-product-plus btn-sm"><i class='fa fa-plus'></i></button>
							</div>
						</div>
						<br>
						<div class='row'>
							<div class="col-md-4">
								<label>Talla:</label>
							</div>
							<div class="col-md-8 text-right">
								<select id='size' class='no-radius form-control input-sm'>
									<?php $availableSizes = $item->getAvailableSizesIds() ?>
									<?php $unitalla = $item->getUnitalla() ?>
									<?php if (isset($unitalla)): ?>
											<?php $available = in_array($unitalla->id,$availableSizes); ?>
											<option <?= !$available?"disabled":'' ?> value='<?= $unitalla->id ?>'><?= $unitalla->name ?> <?= !$available?"- agotado":'' ?></option>
									<?php else: ?>
										<?php foreach(Size::find()->orderBy('order ASC')->all() as $s): ?>
										<?php if ($s->name!='Unitalla'): ?>
											<?php $available = in_array($s->id,$availableSizes); ?>
											<?php if($s->name=="Extra Chica" || $s->name=="Extra Grande"): ?>
												<?php if ($item->forWoman && $s->name=="Extra Chica"): ?>
														<option <?= !$available?"disabled":'' ?> value='<?= $s->id ?>'><?= $s->name ?> <?= !$available?"- agotado":'' ?></option>
												<?php endif ?>
												<?php if ($item->forMen && $s->name=="Extra Grande"): ?>
														<option <?= !$available?"disabled":'' ?> value='<?= $s->id ?>'><?= $s->name ?> <?= !$available?"- agotado":'' ?></option>
												<?php endif ?>
											<?php else: ?>
													<option <?= !$available?"disabled":'' ?> value='<?= $s->id ?>'><?= $s->name ?> <?= !$available?"- agotado":'' ?></option>
											<?php endif ?>											
										<?php endif ?>
										<?php endforeach ?>										
									<?php endif ?>
								</select>
							</div>
						</div>
						<br>
						<div style='color:#b83a4d;display:none' class='text-center' id='select-color-warning'>
							<p><strong>Selecciona un color disponible</strong> <i class='fa fa-exclamation-circle'></i></p>
							<br>
						</div>
						<div class='row'>
							<div class="col-md-4">
								<label>Color:</label>
							</div>
							<div class="col-md-8 text-right">
								<?php $color = isset($colors[0])?$colors[0]->color->hex:'000' ?>
								<select id='item' class='no-radius form-control input-sm'>
								</select>
							</div>
						</div>
						<br>
						<button <?= $exhausted?"disabled":'' ?> type='submit'  style='margin-top:20px' data-added-text="<i class='fa fa-check'></i>" data-loading-text="<i class='fa fa-refresh fa-spin'></i>" class="addbutton btn btn-lg btn-primary btn-block"><?= $exhausted?"Articulo Agotado":'AÑADIR A CARRITO' ?></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
