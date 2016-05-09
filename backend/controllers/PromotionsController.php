<?php
namespace backend\controllers;

use Yii;
use backend\components\Controller;
use common\models\Promotion;
use common\models\Item;
use common\models\GarmentType;
use yii\helpers\Url;
class PromotionsController extends Controller
{
	public function actionIndex()
	{
		return $this->render('index');
	}
	public function actionNew()
	{
		return $this->renderPartial('new');
	}
	public function actionEdit($id)
	{
		return $this->renderPartial('edit',['promotion'=>Promotion::findOne($id)]);
	}
	public function actionCreate()
	{
		$r = ['success'=>false];
		$n = new Promotion;
		// var_dump($_POST);exit;
		$n->attributes = $_POST['Promotion'];
		if($n->save()){
			$pass = false;
			if($n->type==Promotion::TypeItems && isset($_POST['items']) && $_POST['items']){
				foreach ($_POST['items'] as $itemID) {
					$n->link('items',Item::findOne($itemID));
				}
				$pass = true;
			}else if($n->type==Promotion::TypeGarmentTypes && isset($_POST['garmentTypes']) && $_POST['garmentTypes']){
				foreach($_POST['garmentTypes'] as $garmentTypeID) {
					$n->link('garmentTypes',GarmentType::findOne($garmentTypeID));
				}
				$pass = true;
			}else{
				$r['message']="Debe seleccionar un tipo de prenda o algun objeto";
				$n->delete();
			}
			if($pass){
				$r['success']=true;
				$r['message']="Guardado Exitoso";
				$r['callbackScript']="closeCurrentModal();";
			}
		}else{
			$r['message']=reset($n->getErrors())[0];
		}
		return json_encode($r);
	}
	public function actionUpdate($id)
	{
		$r = ['success'=>false];
		$n = Promotion::findOne($id);
		// var_dump($_POST);exit;
		$n->attributes = $_POST['Promotion'];
		if($n->save()){
			foreach($n->items as $i) {
				$n->unlink('items',$i,true);
			}
			foreach($n->garmentTypes as $g) {
				$n->unlink('garmentTypes',$g,true);
			}
			$pass = false;
			if($n->type==Promotion::TypeItems && isset($_POST['items']) && $_POST['items']){
				foreach ($_POST['items'] as $itemID) {
					$n->link('items',Item::findOne($itemID));
				}
				$pass = true;
			}else if($n->type==Promotion::TypeGarmentTypes && isset($_POST['garmentTypes']) && $_POST['garmentTypes']){
				foreach($_POST['garmentTypes'] as $garmentTypeID) {
					$n->link('garmentTypes',GarmentType::findOne($garmentTypeID));
				}
				$pass = true;
			}else{
				$r['message']="Debe seleccionar un tipo de prenda o algun objeto";
				$n->delete();
			}
			if($pass){
				$r['success']=true;
				$r['message']="Guardado Exitoso";
				$r['callbackScript']="reloadCurrentModal();";
			}
		}else{
			$r['message']=reset($n->getErrors())[0];
		}
		return json_encode($r);
	}

	public function actionDelete($id)
	{
		$p = Promotion::findOne($id);
		foreach($p->items as $i) {
			$p->unlink('items',$i,true);
		}
		foreach($p->garmentTypes as $g) {
			$p->unlink('garmentTypes',$g,true);
		}
		// Promotion::deleteAll(['referenceID'=>$id]);
		$p->delete();
		$this->redirect(Url::toRoute('promotions/'));
	}
    public function actionListing()
    {
    	$promotions = Promotion::find();
		$cols = ['id','name','startDate','uses','id','id'];
		$totalAll = $promotions->count();
		// criteria
		foreach ($cols as $index => $c) {
			$promotions->andWhere(['like',$c,$_GET['columns'][$index]['search']['value']]);
		}
		$totalFiltered = $promotions->count();
		$promotions->orderBy($cols[$_GET['order'][0]['column']].' '.$_GET['order'][0]['dir']);
		$promotions->limit($_GET['length'])->offset($_GET['start']);
		$r=[];
		$r['draw'] = $_GET['draw'];
		$r['recordsTotal']=$totalAll;
		$r['recordsFiltered']=$totalFiltered;
		$r['data']=[];
		foreach($promotions->all() as $p) {
			$actions=[];
			$actions[]="<a href='".Url::to(['promotions/edit','id'=>$p->id])."' class='btn btn-xs btn-primary' data-modal-width='700' data-toggle='modalDinamic'><i class='icon-eye-open'></i></a>";
			$actions[]="<a href='".Url::to(['promotions/delete','id'=>$p->id])."' class='btn btn-xs btn-danger show-warning'><i class='icon-trash'></i></a>";
			$r['data'][]=[
				$p->id,
				$p->name,
				date('d/m/Y',strtotime($p->startDate)).' - '.date('d/m/Y',strtotime($p->endDate)),
				$p->uses,
				$p->description,
				"<div class='text-center'>".implode('',$actions)."</div>",
			];
		}
		$r['error']='';
		return json_encode($r);
    }
}