<?php
namespace backend\controllers;

use Yii;
use backend\components\Controller;
use yii\helpers\Url;
use common\models\ShippingMethod;

class ShippingController extends Controller
{
	public function actionIndex()
	{
		return $this->render('index');
	}
	public function actionNew()
	{
		return $this->renderPartial('new');
	}
	public function actionCreate()
	{
		$r = ['success'=>false];
		$n = new ShippingMethod;
		$n->attributes = $_POST['ShippingMethod'];
		if($n->save()){
			$r['success']=true;
			$r['message']="Guardado Exitoso";
			$r['callbackScript']="
			closeCurrentModal();
			";
		}else{
			$r['message']=reset($n->getErrors())[0];
		}
		return json_encode($r);
	}
	public function actionEdit($id)
	{
		$sm = ShippingMethod::findOne($id);
		return $this->renderPartial('edit',['sm'=>$sm]);	
	}
	public function actionUpdate($id)
	{
		$r = ['success'=>false];
		$n = ShippingMethod::findOne($id);
		$n->attributes = $_POST['ShippingMethod'];
		if($n->save()){
			$r['success']=true;
			$r['message']="Actualizacion Exitosa";
		}else{
			$r['message']=reset($n->getErrors())[0];
		}
		return json_encode($r);
	}
	public function actionDelete($id)
	{
		$s = ShippingMethod::findOne($id);
		if($s->getOrders()->count()==0){
			$s->delete();
		}
		return $this->redirect(Url::toRoute('shipping/'));
	}
	public function actionListing()
    {
    	$shipping = ShippingMethod::find();
		$cols = ['name','price','id','status','id','id'];
		$totalAll = $shipping->count();
		// criteria
		foreach ($cols as $index => $c) {
			$shipping->andWhere(['like',$c,$_GET['columns'][$index]['search']['value']]);
		}
		$totalFiltered = $shipping->count();
		$shipping->orderBy($cols[$_GET['order'][0]['column']].' '.$_GET['order'][0]['dir']);
		$shipping->limit($_GET['length'])->offset($_GET['start']);
		$r=[];
		$r['draw'] = $_GET['draw'];
		$r['recordsTotal']=$totalAll;
		$r['recordsFiltered']=$totalFiltered;
		$r['data']=[];
		foreach($shipping->all() as $s) {
			$actions=[];
			$actions[]="<a href='".Url::to(['shipping/edit','id'=>$s->id])."' class='btn btn-xs btn-primary'  data-toggle='modalDinamic'><i class='icon-eye-open'></i></a>";
			$actions[]="<a href='".Url::to(['shipping/delete','id'=>$s->id])."' class='btn btn-xs btn-danger'><i class='icon-trash'></i></a>";
			$r['data'][]=[
				$s->name,
				number_format($s->price,2),
				$s->getShippingCompanyName(),
				$s->getStatusArray()[$s->status],
				$s->description,
				"<div class='text-center'>".implode('',$actions)."</div>",
			];
		}
		$r['error']='';
		return json_encode($r);
    }
}