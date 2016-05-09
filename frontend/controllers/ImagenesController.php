<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Image;
use yii\imagine\Image as Image2;

class ImagenesController extends Controller
{
	public function actionImagen($id)
	{
		$aux = explode('-',$id);
		$id = $aux[0];
		$size = $aux[1];
		$i = Image::findOne($id);
		if($i){
			$segundos_cache = 30 * 24 * 60 * 60; // 30 días * 24 horas * 60 minutos * 60 segundos
			$expira = gmdate("D, d M Y H:i:s", time() + $segundos_cache) . " GMT";
			header("Expires: $expira");  
			header("Pragma: cache");  
			header("Cache-Control: max-age=$segundos_cache");
			header('Content-Type:'.($size==0?$i->type:'image/png'));
			switch ($size) {
				case 0:
				echo $i->content;
					break;
				case 1:
				echo $i->medium;
					break;
				case 2:
				echo $i->small;
					break;
				default:
					break;
			}
		}
	}
}