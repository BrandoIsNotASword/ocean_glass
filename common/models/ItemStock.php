<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class ItemStock extends ActiveRecord
{
	public static function tableName()
	{
		return "ItemStocks";
	}
	public function rules()
	{
		return [
			[['itemID','quantity'],'required','message'=>'Campo {attribute} es requerido'],
			[['quantity'],'number','message'=>'Campo {attribute} debe ser un numero'],
			[['notes'],'safe'],
		];
	}
	public function getItem()
	{
		return $this->hasOne(Item::classname(),['id'=>'itemID']);
	}
}