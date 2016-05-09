<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Item extends ActiveRecord
{
	const StatusActive = 1;
	const StatusInactive = 2;
	const StatusDeleted = 3;
	public $currentPromotion;
	public $firstStock;
	public static function tableName()
	{
		return "Items";
	}
	public function rules()
	{
		return [
			[['name','price','url'],'required'],
			['name','unique','message'=>"Este nombre de producto ya ha existe"],
			[['price','firstStock'],'number'],
			[['description','status'],'safe'],
		];
	}
	public function getImages()
	{
		return $this->hasMany(Image::className(),['referenceID'=>'id'])->andWhere(['fromTable'=>'Items'])->orderBy('orderx ASC');
	}
	public function getPrincipalImg()
	{
		$img = $this->getImages()->andWhere(['principal'=>1])->one();
		return $img?$img:$this->getImages()->one();
	}
	public function getStatusArray()
	{
		return [
			self::StatusActive => 'Activo',
			self::StatusInactive => 'Inactivo',
			self::StatusDeleted => 'Eliminado',
		];
	}
	public function updateStock()
	{
		$this->stock = $this->getItemStocks()->sum('quantity');
		$this->save();
	}
	public function getItemStocks()
	{
		return $this->hasMany(ItemStock::classname(),['itemID'=>'id']);
	}
	public function getBestPrice()
	{
		$promoAux = $this->getBestPromotion();
		$r = $this->price;
		if(isset($promoAux)){
			$r = $promoAux->applyPromotion($this->price);
		}
		return $r;
	}
}