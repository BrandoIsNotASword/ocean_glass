<?php
namespace backend\controllers;

use Yii;
use backend\components\Controller;
use yii\helpers\Url;
use common\models\User;

class UsersController extends Controller
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
		$n = new User;
		$n->scenario='create';
		$n->attributes = $_POST['User'];
		$n->generateAuthKey();
		if($n->save()){
			$r['success']=true;
			$r['message']="Guardado Exitoso";
			$r['callbackScript']="closeCurrentModal();";
		}else{
			$r['message']=reset($n->getErrors())[0];
		}
		return json_encode($r);
	}
	public function actionEdit($id)
	{
		$user = User::findOne($id);
		return $this->renderPartial('edit',['user'=>$user]);	
	}
	public function actionUpdatepass($id)
	{
		$user = User::findOne($id);
		$user->scenario = 'changePassword';
		$user->password_hash = $_POST['User']['password_hash'];
		$user->comparePassword = $_POST['User']['comparePassword'];
		$r = ['success'=>false];
		if($user->save()){
			$r['success']=true;
			$r['message']="Contraseña actualizada";
			$r['callbackScript']="closeCurrentModal();";
		}else{
			$r['message']=reset($user->getErrors())[0];
		}
		return json_encode($r);
	}
	public function actionUpdate($id)
	{
		$r = ['success'=>false];
		$n = User::findOne($id);
		$n->attributes = $_POST['User'];
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
		$s = User::findOne($id);
		$s->delete();
		return json_encode(['success'=>true]);
	}
	public function actionListing()
    {
    	$users = User::find();
		$cols = ['username','firstName','lastName','email','status','accessLevel','id'];
		$totalAll = $users->count();
		// criteria
		foreach ($cols as $index => $c) {
			$users->andWhere(['like',$c,$_GET['columns'][$index]['search']['value']]);
		}
		$totalFiltered = $users->count();
		$users->orderBy($cols[$_GET['order'][0]['column']].' '.$_GET['order'][0]['dir']);
		$users->limit($_GET['length'])->offset($_GET['start']);
		$r=[];
		$r['draw'] = $_GET['draw'];
		$r['recordsTotal']=$totalAll;
		$r['recordsFiltered']=$totalFiltered;
		$r['data']=[];
		foreach($users->all() as $u) {
			$actions=[];
			$actions[]="<a href='".Url::to(['users/edit','id'=>$u->id])."' class='btn btn-xs btn-primary'  data-toggle='modalDinamic'><i class='icon-eye-open'></i></a>";
			$actions[]="<a href='".Url::to(['users/delete','id'=>$u->id])."' class='btn btn-xs btn-danger show-warning ajaxLink'><i class='icon-trash'></i></a>";
			$r['data'][]=[
				$u->username,
				$u->firstName,
				$u->lastName,
				$u->email,
				$u->getStatusArray()[$u->status],
				$u->getAccessLevelArray()[$u->accessLevel],
				"<div class='text-center'>".implode('',$actions)."</div>",
			];
		}
		$r['error']='';
		return json_encode($r);
    }
}