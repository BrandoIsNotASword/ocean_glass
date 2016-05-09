<?php 
namespace backend\controllers;

use Yii;
use backend\components\Controller;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\ItemStock;
use common\models\Item;

class ItemStocksController extends Controller{
	public function actionNew($item)
	{
		$item = Item::findOne($item);
		$model = new ItemStock;
		$model->itemID = $item->id;
		return $this->renderPartial('new',['model'=>$model]);
	}
	public function actionCreate()
	{
		$r = ['success'=>false];
		$model = new ItemStock;
        $model->load(Yii::$app->request->post());
		if($model->save()){
			$model->item->updateStock();
			$r['success']=true;
			$r['message']="Inventario modificado";
			$r['callbackScript']="closeCurrentModal(reloadCurrentModal);";
		}else{
			$r['message']=reset($model->getErrors())[0];
		}
		return json_encode($r);
	}
	public function actionListingByItem($item)
	{
		$inv = ItemStock::find()->where(['itemID'=>$item]);
		$cols = ['date','quantity','notes'];
		$totalAll = $inv->count();
		// criteria
		foreach($cols as $index => $c){
			$inv->andWhere(['like',$c,$_GET['columns'][$index]['search']['value']]);
		}
		$totalFiltered = $inv->count();
		$inv->orderBy($cols[$_GET['order'][0]['column']].' '.$_GET['order'][0]['dir']);
		$inv->limit($_GET['length'])->offset($_GET['start']);
		$r=[];
		$r['draw'] = $_GET['draw'];
		$r['recordsTotal']=$totalAll;
		$r['recordsFiltered']=$totalFiltered;
		$r['data']=[];
		foreach($inv->all() as $i) {
			$r['data'][]=[
				date('d/m/Y H:i:s',strtotime($i->date)),
				$i->quantity,
				$i->notes,
			];
		}
		$r['error']='';
		return json_encode($r);
	}
}
 ?>
