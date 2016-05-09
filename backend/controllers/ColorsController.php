<?php
namespace backend\controllers;

use Yii;
use backend\components\Controller;
// use yii\helpers\Url;
// use yii\web\UploadedFile;
// use common\models\Item;
use common\models\Color;
use common\models\ItemColor;

class ColorsController extends Controller
{
	public function actionNew($fast=false)
	{
		return $this->renderPartial('new',['fast'=>$fast]);
	}
	public function actionEdit($id)
	{
		return $this->renderPartial('edit',['color'=>Color::findOne($id)]);
	}
	public function actionCreate()
	{
		$c = new Color;
		$c->name = $_POST['name'];
		$r = ['success'=>false];
		if($c->save()){
			$r['success']=true;
			$r['message']="Color agregado con exito";
			if(Yii::$app->request->post('fast')){
				$r['callbackScript']="
				closeCurrentModal(function(){
					reloadCurrentModal();
				});
				";				
			}else{
				$r['callbackScript']="location.reload();";
			}
		}else{
			$r['message']=reset($c->getErrors())[0];
		}
		return json_encode($r);
	}
	public function actionUpdate($id)
	{
		$c = Color::findOne($id);
		// $c->hex = $_POST['color'];
		$c->name = $_POST['name'];
		$r = ['success'=>false];
		if($c->save()){
			$r['success']=true;
			$r['message']="Color editado con exito";
			$r['callbackScript']="location.reload();";
			// $r['callbackScript']="
			// closeCurrentModal(function(){
			// 	reloadCurrentModal();
			// });
			// ";
		}else{
			$r['message']=reset($c->getErrors())[0];
		}
		return json_encode($r);
	}
	public function actionDelete($id)
	{
		$r = ['success'=>false];
		$color = Color::findOne($id);
		if(ItemColor::find()->where(['colorID'=>$id])->count()==0){
			$color->delete();
			$r['success']=true;
			$r['callbackScript']="location.reload();";
		}else{
			$r['message']="Color en uso, imposible eliminar";
		}
		return json_encode($r);
	}
}