<?php
namespace backend\controllers;

use Yii;
use backend\components\Controller;
use yii\helpers\Url;
use common\models\Item;
use common\models\Image;
use common\models\User;
use yii\web\UploadedFile;
use common\models\ItemStock;

class ItemsController extends Controller
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
		$item = Item::findOne($id);
		$item->updateStock();
		return $this->renderPartial('edit',['item'=>$item]);	
	}
	public function actionCreate()
	{
		$r = ['success'=>false];
		$n = new Item;
		$n->attributes = $_POST['Item'];
		$n->stock = $n->firstStock;
		$n->url = $this->createSlug($n->name);
		$aux = 1;
		while(Item::find()->where(['url'=>$n->url])->count()>0){
			// tuyo?
			$n->url.=$aux;
			$aux++;
		}
		if($n->save()){
			// agrega inventario
			$inv = new ItemStock;
			$inv->itemID = $n->id;
			$inv->quantity = $n->firstStock;
			$inv->userID = Yii::$app->user->identity->id;
			$inv->notes = "Inventario inicial";
			$inv->save();

			$this->saveImages($n->id);
			$r['success']=true;
			$editLink =  \yii\helpers\Url::to(['items/edit','id'=>$n->id]);
			$r['message']="Guardado Exitoso";
			$r['callbackScript']="
			// location.reload();
			var cur = getCurrentModal();
			cur.data('relatedTarget','$editLink');
			reloadCurrentModal();
			";
		}else{
			$r['message']=reset($n->getErrors())[0];
		}
		return json_encode($r);
	}
	public function actionUpdate($id)
	{
		$r = ['success'=>false,'message'=>"No tienes permisos para esta accion"];
		if(Yii::$app->user->identity->accessLevel==User::AccessLevelMaster){
			$n = Item::findOne($id);
			$n->attributes = $_POST['Item'];
			$n->url = $this->createSlug($n->name);
			if($n->save()){
				$r['success']=true;
				$editLink =  \yii\helpers\Url::to(['items/edit','id'=>$n->id]);
				$r['message']="Actualización Exitosa";
			}else{
				$r['message']=reset($n->getErrors())[0];
			}
		}
		return json_encode($r);
	}
	public function createSlug($string){
	   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
	   return strtolower($slug);
	}
	public function actionDelete($id)
	{
		$r = ['success'=>false,'message'=>"No tienes permisos para esta accion"];
		if(Yii::$app->user->identity->accessLevel==User::AccessLevelMaster){
			$item = Item::findOne($id);
			$r['callbackScript']="reloadAjaxTables();";
		}
		return json_encode($r);	
	}
	public function saveImages($id)
	{
		$archives = UploadedFile::getInstancesByName('images');
		$principal = true;
		if(isset($archives) && count($archives)>0){
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
					$img->principal = $principal;
					$img->save();
					$principal = false;
				}
			}
		}
	}
	public function actionInventory($id)
	{
		return $this->renderPartial('stocks',['item'=>Item::findOne($id)]);
	}
	public function actionGallery($id)
	{
		return $this->renderPartial('gallery',['item'=>Item::findOne($id)]);
	}
	public function actionColorimg($id)
    {
        $color = ItemColor::findOne($id);
        return $this->renderPartial('color_img',['color'=>$color]);
    }
	public function actionChangeimages($id)
    {
        $color = ItemColor::findOne($id);
        $r=['success'=>false];
        $postImages = isset($_POST['images'])?$_POST['images']:[];
        $prevImgs = [];
        foreach($color->images as $im){
        	if(!in_array($im->id,$postImages)){
        		$color->unlink('images',$im,true);
        	}else{
        		$prevImgs[]=$im->id;
        	}
        }
        foreach($postImages as $imgId){
        	if(!in_array($imgId,$prevImgs)){
        		$color->link('images',Image::findOne($imgId));
        	}
        }
		$r['success']=true;
		$r['message']="Imagenes actualizadas";
		$r['callbackScript']="reloadCurrentModal();";
        return json_encode($r);
    }
    public function actionUpdatecolor($id)
    {
    	$color = ItemColor::findOne($id);
		$r['success']=true;
		$r['callbackScript']="reloadCurrentModal();";
		// elimina los tamaños relacionados y vuelve a crear, necesario optimizar
		foreach($color->sizes as $s) {
			$s->delete();
		}
		foreach(Size::find()->all() as $s){
			$aux = new ItemColorSize;
			$aux->itemColorID = $color->id;
			$aux->sizeID = $s->id;
			$aux->quantity = isset($_POST['sizes']["{$s->id}"])?$_POST['sizes']["{$s->id}"]:0;
			$aux->save();
		}
		$color->updateInventory();
		return json_encode($r);
    }
    public function actionDelcolor($id)
    {
    	$color = ItemColor::findOne($id);
    	$item = $color->item;
    	foreach($color->sizes as $s){
    		$s->delete();
    	}
    	$color->unlinkAll('images',true);
    	$color->delete();
    	$item->updateInventory();
    	return json_encode(['success'=>true,'message'=>'Eliminacion exitosa','callbackScript'=>'reloadCurrentModal();']);
    }
    public function actionListing()
    {
    	$items = Item::find()->where("status != ".Item::StatusDeleted);
		$cols = ['Items.name','price','status','Items.id','Items.id'];
		$totalAll = $items->count();
		// criteria
		foreach($cols as $index => $c){
			$items->andWhere(['like',$c,$_GET['columns'][$index]['search']['value']]);
		}
		$totalFiltered = $items->count();
		$items->orderBy($cols[$_GET['order'][0]['column']].' '.$_GET['order'][0]['dir']);
		$items->limit($_GET['length'])->offset($_GET['start']);
		$r=[];
		$r['draw'] = $_GET['draw'];
		$r['recordsTotal']=$totalAll;
		$r['recordsFiltered']=$totalFiltered;
		$r['data']=[];
		foreach($items->all() as $i) {
			$actions=[];
			$actions[]="<a href='".Url::to(['items/edit','id'=>$i->id])."' class='btn btn-xs btn-primary' data-toggle='modalDinamic'><i class='icon-edit'></i></a>";
			$actions[]="<a href='".Url::to(['items/delete','id'=>$i->id])."' class='btn btn-xs btn-danger show-warning ajaxLink'><i class='icon-trash'></i></a>";
			$r['data'][]=[
				$i->name,
				"$".number_format($i->price,2),
				$i->getStatusArray()[$i->status],
				$i->stock,
				"<img style='max-width:100px;max-height:150px' src='".$this->getUrlImg($i->getPrincipalImg(),2)."'>",
				"<div class='text-center'>".implode('',$actions)."</div>",
			];
		}
		$r['error']='';
		return json_encode($r);
    }
    public function actionUpdatepositions($id)
    {
    	$item = Item::findOne($id);
    	$positions = $_POST['positions'];
    	foreach($item->images as $img) {
    		if(isset($positions["{$img->id}"])){
				$img->updateAttributes(['order'=>$positions["{$img->id}"]]);
    		}
    	}
    }
    public function actionTest()
    {
    	// phpinfo();
    	echo date('Y-m-d H:i:s');
    }
}