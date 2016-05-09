<?php
namespace frontend\components;

use Yii;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Item;
use common\models\Size;
use common\models\ItemColor;
use common\models\ItemColorSize;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use common\models\Content;
/**
 * Site controller
 */
class Controller extends \yii\web\Controller
{
    protected $cart;
	public $login;
    public function beforeAction($event)
    {
        $this->view->title='Ocean Glass';
        return parent::beforeAction($event);
    }
    public function init()
    {
        $this->cart = $this->getCart();
	}
    public function getUrlImg($img,$size=0,$external=false)
    {
        if($img){
            return Url::to(['imagenes/imagen','id'=>$img->id."-$size.".($size==0?$img->extension:'png')],$external);
        }
        return "/img/no-img.gif";
    }
    protected function getCart()
    {
    	$session = Yii::$app->session;
    	$cart = unserialize($session->get('cart'));
    	if(!isset($cart) || !$cart){
    		$session->set('cart',serialize([]));
    		$cart = [];
    	}
    	return $cart;
    }
    protected function addToCart($itemID,$quantity,&$error="")
    {
        $item = Item::findOne($itemID);
        // if(isset($this->cart[$item->id])) $this->cart[$item->id]=$quantity;
        // else $this->cart[$item->id]=$quantity;
        $this->cart[$item->id]=$quantity;
        if($item->stock<$this->cart[$item->id]){
    		$error="Articulo agotado para la cantidad seleccionada";
    		return false;            
        }
    	$this->saveCart();
    	return true;
    }
    protected function saveCart()
    {
    	Yii::$app->session->set('cart',serialize($this->cart));
    }
    protected function getImages($key='home')
    {
        $c = Content::findOne(['key'=>$key]);
        if(isset($c)){
            return $c->images;
        }
        return [];
    }
}