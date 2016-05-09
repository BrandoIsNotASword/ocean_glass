<?php
namespace backend\components;

use Yii;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use common\models\Image;
use yii\web\UploadedFile;
/**
 * Site controller
 */
class Controller extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login','error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function($rule,$action){
                            $this->redirect(Url::toRoute('site/login'));
                         },
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
        ];
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    public function getUrlImg($img,$size=0)
    {
        if($img){
            return Url::to(['images/image','id'=>$img->id."-$size.".($size==0?$img->extension:'png')]);
        }
        return "/img/no-img.gif";
    }
    public function saveImage($imgName,$fromTable,$referenceID,$unique = false,$principal=true)
    {
        $arch = UploadedFile::getInstanceByName($imgName);
        if(isset($arch)){
            $images=null;
            if($unique){
                $images = Image::find()->where(['referenceID'=>$referenceID,'fromTable'=>$fromTable])->all();
            }
            $img = new Image;
            $img->filename = $arch->name;
            $img->fromTable = $fromTable;
            $img->extension = $arch->extension;
            $img->content = file_get_contents($arch->tempName);
            $img->type = $arch->type;
            $img->size = $arch->size;
            $img->referenceID = $referenceID;
            $img->principal = $principal;
            if($img->save()){
                if(isset($images)){
                    foreach ($images as $i) {
                        $i->delete();
                    }
                }
            }
            return $img->save();
        }
        return false;
    }
}