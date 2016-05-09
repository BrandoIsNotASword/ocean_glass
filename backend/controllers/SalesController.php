<?php
namespace backend\controllers;

use Yii;
use backend\components\Controller;
use yii\helpers\Url;
use common\models\Sale;
use common\models\ItemColorSize;
class SalesController extends Controller
{
	public function actionIndex()
	{
		return $this->render('index');
	}
	public function actionFinished($id)
	{
		$sale = Sale::findOne($id);
		$sale->status = Sale::StatusFinished;
		$sale->save();
		$r = ['success'=>true,'callbackScript'=>"reloadCurrentModal();reloadAjaxTables();"];
		return json_encode($r);
	}
	public function actionPay($id)
	{
		$sale = Sale::findOne($id);
		$sale->status = Sale::StatusPayed;
		$sale->save();
		$sale->discountInventory();
		return json_encode(['success'=>true,'callbackScript'=>"
			reloadCurrentModal;
			reloadAjaxTables();
		"]);
	}
	public function actionListing($list)
    {
    	$sales = Sale::find();
		$cols = ['clientName','insertDate','refID','total','id'];
		// el orden y los filtros dependen del tipo de lista
		switch ($list) {
			case 'pending':
				$sales->where(['Sales.status'=>Sale::StatusPayed]);
				$sales->orderBy("insertDate ASC");
				break;	
			case 'cancelled':
				$sales->where(['Sales.status'=>Sale::StatusCancelled]);
				$sales->orderBy("Sales.id DESC");
				break;		
			case 'nopayment':
				$sales->where(['Sales.status'=>Sale::StatusPending]);
				$sales->orderBy("insertDate ASC");
				break;		
			case 'delivered':
				$sales->where(['Sales.status'=>Sale::StatusFinished]);
				$sales->orderBy("insertDate ASC");
				break;		
			default:
				break;
		}
		$totalAll = $sales->count();
		$totalFiltered = $totalAll;
		$sales->limit($_GET['length'])->offset($_GET['start']);
		$r=[];
		$r['draw'] = $_GET['draw'];
		$r['recordsTotal']=$totalAll;
		$r['recordsFiltered']=$totalFiltered;
		$r['data']=[];
		foreach($sales->all() as $o) {
			$actions=[];
			$actions[]="<a href='".Url::to(['sales/view','id'=>$o->id])."' class='btn btn-xs btn-primary' data-modal-width='600' data-toggle='modalDinamic'><i class='icon-eye-open'></i></a>";
			$r['data'][]=[
				$o->id,
				$o->clientName,
				$o->insertDate,
				'MX $'.number_format($o->total,2),
				"<div class='text-center'>".implode('',$actions)."</div>",
			];
		}
		$r['error']='';
		return json_encode($r);
    }
    public function actionView($id)
    {
    	$sale = Sale::findOne($id);
    	return $this->renderPartial('view',['sale'=>$sale]);
    }
	public function actionCancel($id)
	{
		$sale = Sale::findOne($id);
		$sale->status = Sale::StatusCancelled;
	    $sale->cancelUserID = Yii::$app->user->identity->id;
		$sale->recoverInventory();
		$sale->save();
		return json_encode(['success'=>true,'message'=>'<h4>Pedido cancelado</h4>','callbackScript'=>"reloadCurrentModal();reloadAjaxTables();"]);
	}
}