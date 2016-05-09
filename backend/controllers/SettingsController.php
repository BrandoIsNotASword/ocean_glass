<?php 
namespace backend\controllers;

use Yii;
use backend\components\Controller;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Setting;

class SettingsController extends Controller{
	public function actionIndex(){
		// obteniendo configuraciones
		$settings = Setting::find()->all();
		return $this->render("index",['settings'=>ArrayHelper::map($settings,'id','value')]);
	}

	public function actionNew(){
		return $this->renderPartial("new");
	}

	public function actionCreate(){
		$r=['success'=>false];
		$set = new Setting();
		$set->attributes = $_POST['Content'];
		if($set->save()) {
			$r['success']=true;
		}
		return json_encode($r);
	}
	public function beforeAction($action) {
	    $this->enableCsrfValidation = false;
	    return parent::beforeAction($action);
	}
	public function actionUpdate()
	{
		foreach ($_POST['settings'] as $s=>$value){
			$set = Setting::findOne($s);
			if(!isset($set)){$set = new Setting;$set->id = $s;}
			$set->value = $value;
			$set->save();
		}
		return json_encode(['success'=>true,'message'=>'Actualizacion exitosa']);
	}
}
 ?>
