<?php
namespace frontend\controllers;

use Yii;
use frontend\components\Controller;
use common\models\Item;
use common\models\Content;
use common\models\Setting;
use yii\data\Pagination;
use yii\helpers\Url;
/**
 * Site controller
 */
class ProductosController extends Controller
{
	public function init()
	{
        Yii::$app->user->setReturnUrl(Yii::$app->request->getUrl());
	}
    public function getItemsPerPage()
    {
        // $set = Setting::findOne('pageItems');
        return isset($_GET['limit'])?$_GET['limit']:9;
    }
	public function actionIndex()
	{
		$query = Item::find()->where(['>','stock',0])->andWhere(['status'=>Item::StatusActive])->orderBy("RAND(".$this->getSeed().") DESC");
		$pag = new Pagination([
            'defaultPageSize' => $this->getItemsPerPage(),
            'totalCount' => $query->count(),
        ]);
        $items = $query
            ->offset($pag->offset)
            ->limit($pag->limit)
            ->all();
        return $this->render('index',['items'=>$items,'pag'=>$pag]);
	}
	public function actionBusqueda($q="")
	{
		$query = Item::find()->where(['>','stock',0])->andWhere(['like','name',$q])->andWhere(['status'=>Item::StatusActive])->orderBy('Items.id DESC');
		$pag = new Pagination([
            'defaultPageSize' => $this->getItemsPerPage(),
            'totalCount' => $query->count(),
        ]);
        $items = $query
            ->offset($pag->offset)
            ->limit($pag->limit)
            ->all();
        return $this->render('index',['items'=>$items,'pag'=>$pag,'title'=>'<h3 class="text-align:center">Busquedas con: "'.\yii\helpers\Html::encode($q).'"</h3>']);

	}
    public function getSeed()
    {
        $seed = Yii::$app->session->get('seed');   
        if(!isset($seed)){
            $seed = rand(10,500);
            Yii::$app->session->set('seed',$seed);   
        }
        return $seed;
    }
}