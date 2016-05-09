<?php
namespace backend\controllers;

use Yii;
use backend\components\Controller;
use yii\helpers\Url;
use yii\web\UploadedFile;
use common\models\Item;
use common\models\Image;

class ImagesController extends Controller
{
	public function actionImage($id)
	{
		$aux = explode("-",$id);
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
	public function actionDelete($id)
	{
		$r = ['success'=>false];
		$img = Image::findOne($id);
		if($img){
			$img->delete();
			$r['success']=true;
			$r['message']="Eliminacion exitosa";
			$r['callbackScript']="reloadCurrentModal();";
		}
		return json_encode($r);
	}
	public function actionAdd($id)
	{
		$r = ['success'=>false];
		$item = Item::findOne($id);
		$archives = UploadedFile::getInstancesByName('images');
		if(isset($item) && isset($archives) && count($archives)>0){
			foreach ($archives as $i => $arch){
				if(!$arch->hasError){
					$img = new Image;
					$img->filename = $arch->name;
					$img->fromTable = 'Items';
					$img->extension = $arch->extension;
					$img->content = file_get_contents($arch->tempName);
					$img->type = $arch->type;
					$img->size = $arch->size;
					$img->referenceID = $id;
					$img->principal = false;
					$img->save();
				}
			}
		}
		$r['success']=true;
		$r['message']="Carga exitosa";
		$r['callbackScript']="reloadCurrentModal();";
		return json_encode($r);
	}
	public function actionPrincipal($id)
	{
		$r = ['success'=>true,'message'=>'Imagen Principal Actualizada'];
		$r['callbackScript']="reloadCurrentModal();";
		foreach (Image::findOne($id)->item->images as $i) {
			$i->updateAttributes(['principal'=>$i->id==$id]);
		}
		return json_encode($r);
	}
	public function actionGenerate()
	{
		foreach (Image::find()->all() as $i) {
			$i->generateThumbnails();
			$i->save();
		}
	}
}